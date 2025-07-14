// Database setup
const dbName = 'localDB1';
const dbVersion = 1;

let db;
let currentPage = 1;
const itemsPerPage = 10;

// Open or create IndexedDB
const openDB = () => {
    return new Promise((resolve, reject) => {
        const request = indexedDB.open(dbName, dbVersion);
        
        request.onupgradeneeded = (event) => {
            const db = event.target.result;
            
            // Create products store if it doesn't exist
            if (!db.objectStoreNames.contains('products')) {
                db.createObjectStore('products', { keyPath: 'productId' });
            }
            
            // Create customers store if it doesn't exist
            if (!db.objectStoreNames.contains('customers')) {
                db.createObjectStore('customers', { keyPath: 'customerId' });
            }
        };
        
        request.onsuccess = (event) => {
            db = event.target.result;
            resolve(db);
        };
        
        request.onerror = (event) => {
            console.error('IndexedDB error:', event.target.error);
            reject(event.target.error);
        };
    });
};

// Store data in IndexedDB
const storeData = (storeName, data) => {
    return new Promise((resolve, reject) => {
        //const transaction = db.transaction([storeName], 'readwrite');
        const transaction = db.transaction(storeName, 'readwrite');
        const store = transaction.objectStore(storeName);
        
        // Clear existing data
        const clearRequest = store.clear();
        
        clearRequest.onsuccess = () => {
            let count = 0;
            let total = data.length;
            
            if (total === 0) {
                resolve();
                return;
            }
            
            // Update progress every 10 items or when complete
            const updateProgress = () => {
                const progress = Math.floor((count / total) * 100);
                document.getElementById(`${storeName}-progress`).style.width = `${progress}%`;
                
                // Update overall progress
                const productsProgress = document.getElementById('products-progress').style.width;
                const customersProgress = document.getElementById('customers-progress').style.width;
                
                const productsPercent = parseInt(productsProgress) || 0;
                const customersPercent = parseInt(customersProgress) || 0;
                const overallPercent = Math.floor((productsPercent + customersPercent) / 2);
                
                document.getElementById('overall-progress').style.width = `${overallPercent}%`;
            };
            
            // Store each item
            data.forEach(item => {
                const request = store.put(item);
                
                request.onsuccess = () => {
                    count++;
                    if (count % 10 === 0 || count === total) {
                        updateProgress();
                    }
                    
                    if (count === total) {
                        resolve();
                    }
                };
                
                request.onerror = (event) => {
                    console.error(`Error storing item in ${storeName}:`, event.target.error);
                    reject(event.target.error);
                };
            });
        };
        
        clearRequest.onerror = (event) => {
            console.error(`Error clearing ${storeName}:`, event.target.error);
            reject(event.target.error);
        };
    });
};

// Fetch data from API
const fetchData = async (endpoint, progressKey) => {
    try {
        // Show initial progress
        document.getElementById(`${progressKey}-progress`).style.width = '0%';
        
        const response = await fetch(`services/${endpoint}`);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        //alert(data.length);
        await storeData(progressKey, data);
        
        // Complete progress
        document.getElementById(`${progressKey}-progress`).style.width = '100%';
        
        return data;
    } catch (error) {
        console.error(`Error fetching ${endpoint}:`, error);
        throw error;
    }
};

// Load all data with progress tracking
const loadAllData = async () => {
    $('#progressModal').modal('show');
    
    try {
        await openDB();
        
        // Fetch both datasets in parallel
        await Promise.all([
            fetchData('products.php', 'products'),
            fetchData('customers.php', 'customers')
        ]);
        
        // Update overall progress to 100%
        document.getElementById('overall-progress').style.width = '100%';
        
        // Enable close button
        document.getElementById('closeModalBtn').disabled = false;
        
        // Load products for display
        loadProducts();
    } catch (error) {
        console.error('Error loading data:', error);
        alert(JSON.stringify(error));
        alert('Error loading data. Please check console for details.');
    }
};

// Get products from IndexedDB
const getProducts = () => {
    return new Promise((resolve, reject) => {
        const transaction = db.transaction(['products'], 'readonly');
        const store = transaction.objectStore('products');
        const request = store.getAll();
        
        request.onsuccess = () => {
            resolve(request.result);
        };
        
        request.onerror = (event) => {
            console.error('Error getting products:', event.target.error);
            reject(event.target.error);
        };
    });
};

// Display products in table with pagination
const loadProducts = async () => {
    try {
        const products = await getProducts();
        displayProducts(products, currentPage);
        setupPagination(products);
    } catch (error) {
        console.error('Error loading products:', error);
    }
};

// Display products for a specific page
const displayProducts = (products, page) => {
    const tableBody = document.getElementById('product-table-body');
    tableBody.innerHTML = '';
    
    const startIndex = (page - 1) * itemsPerPage;
    const endIndex = Math.min(startIndex + itemsPerPage, products.length);
    
    for (let i = startIndex; i < endIndex; i++) {
        const product = products[i];
        const row = document.createElement('tr');
        
        row.innerHTML = `
            <td>${product.productId}</td>
            <td>${product.name}</td>
            <td>${product.price}</td>
            <td>${new Date(product.updatedAt).toLocaleString()}</td>
        `;
        
        tableBody.appendChild(row);
    }
};

// Setup pagination controls
const setupPagination = (products) => {
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = '';
    
    const pageCount = Math.ceil(products.length / itemsPerPage);
    
    // Previous button
    const prevLi = document.createElement('li');
    prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
    prevLi.innerHTML = `<a class="page-link" href="#">Previous</a>`;
    prevLi.addEventListener('click', (e) => {
        e.preventDefault();
        if (currentPage > 1) {
            currentPage--;
            displayProducts(products, currentPage);
            setupPagination(products);
        }
    });
    pagination.appendChild(prevLi);
    
    // Page numbers
    for (let i = 1; i <= pageCount; i++) {
        const pageLi = document.createElement('li');
        pageLi.className = `page-item ${i === currentPage ? 'active' : ''}`;
        pageLi.innerHTML = `<a class="page-link" href="#">${i}</a>`;
        pageLi.addEventListener('click', (e) => {
            e.preventDefault();
            currentPage = i;
            displayProducts(products, currentPage);
            setupPagination(products);
        });
        pagination.appendChild(pageLi);
    }
    
    // Next button
    const nextLi = document.createElement('li');
    nextLi.className = `page-item ${currentPage === pageCount ? 'disabled' : ''}`;
    nextLi.innerHTML = `<a class="page-link" href="#">Next</a>`;
    nextLi.addEventListener('click', (e) => {
        e.preventDefault();
        if (currentPage < pageCount) {
            currentPage++;
            displayProducts(products, currentPage);
            setupPagination(products);
        }
    });
    pagination.appendChild(nextLi);
};

// Initialize the application when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    loadAllData();
    
    // Close modal handler
    document.getElementById('closeModalBtn').addEventListener('click', () => {
        $('#progressModal').modal('hide');
    });
});