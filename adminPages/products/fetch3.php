<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management with Pagination</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            position: sticky;
            top: 0;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .controls {
            margin: 20px 0;
        }
        button {
            padding: 8px 16px;
            margin-right: 10px;
            cursor: pointer;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 5px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        /* Progress Bar Styles */
        .progress-container {
            width: 100%;
            background-color: #f0f0f0;
            border-radius: 10px;
            margin: 20px 0;
        }
        .progress-bar {
            height: 30px;
            border-radius: 10px;
            width: 0%;
            background-color: #4CAF50;
            text-align: center;
            line-height: 30px;
            color: white;
            transition: width 0.3s ease;
        }
        .progress-text {
            text-align: center;
            margin-bottom: 10px;
        }
        
        /* Pagination Styles */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination button {
            padding: 8px 16px;
            margin: 0 4px;
            border: 1px solid #ddd;
            background-color: white;
            cursor: pointer;
        }
        .pagination button.active {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
        }
        .pagination button:hover:not(.active) {
            background-color: #ddd;
        }
        .pagination button:disabled {
            background-color: #f1f1f1;
            color: #aaa;
            cursor: not-allowed;
        }
        .page-info {
            text-align: center;
            margin-top: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>Product Management</h1>
    
    <div class="controls">
        <button id="fetchBtn">Fetch and Store Products</button>
        <button id="loadFromDBBtn">Load from LocalDB</button>
        <button id="clearDBBtn">Clear LocalDB</button>
    </div>
    
    <div id="productsTableContainer">
        <table id="productsTable">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Last Updated</th>
                </tr>
            </thead>
            <tbody id="productsTableBody">
                <!-- Products will be inserted here -->
            </tbody>
        </table>
        
        <div id="pageInfo" class="page-info"></div>
        
        <div class="pagination">
            <button id="firstPage">First</button>
            <button id="prevPage">Previous</button>
            <div id="pageNumbers"></div>
            <button id="nextPage">Next</button>
            <button id="lastPage">Last</button>
        </div>
    </div>

    <!-- Progress Modal -->
    <div id="progressModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Processing Data</h2>
            <div id="progressText" class="progress-text">Starting...</div>
            <div class="progress-container">
                <div id="progressBar" class="progress-bar">0%</div>
            </div>
        </div>
    </div>

    <script>
        // Database variables
        const dbName = 'localDB';
        const dbVersion = 1;
        const storeName = 'products';
        let db;
        
        // Pagination variables
        const itemsPerPage = 10;
        let currentPage = 1;
        let totalPages = 1;
        let allProducts = [];
        
        // DOM elements
        const fetchBtn = document.getElementById('fetchBtn');
        const loadFromDBBtn = document.getElementById('loadFromDBBtn');
        const clearDBBtn = document.getElementById('clearDBBtn');
        const tableBody = document.getElementById('productsTableBody');
        const modal = document.getElementById('progressModal');
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');
        const closeBtn = document.querySelector('.close');
        const firstPageBtn = document.getElementById('firstPage');
        const prevPageBtn = document.getElementById('prevPage');
        const nextPageBtn = document.getElementById('nextPage');
        const lastPageBtn = document.getElementById('lastPage');
        const pageNumbersDiv = document.getElementById('pageNumbers');
        const pageInfoDiv = document.getElementById('pageInfo');

        // Initialize the database
        function initDB() {
            return new Promise((resolve, reject) => {
                const request = indexedDB.open(dbName, dbVersion);
                
                request.onerror = (event) => {
                    showError('Error opening database: ' + event.target.error);
                    reject('Database error: ' + event.target.errorCode);
                };
                
                request.onsuccess = (event) => {
                    db = event.target.result;
                    console.log('Database initialized');
                    resolve(db);
                };
                
                request.onupgradeneeded = (event) => {
                    const db = event.target.result;
                    if (!db.objectStoreNames.contains(storeName)) {
                        db.createObjectStore(storeName, { keyPath: 'productId' });
                        console.log('Database created');
                    }
                };
            });
        }
        
        // Show modal with progress bar
        function showProgressModal() {
            modal.style.display = 'block';
            progressBar.style.width = '0%';
            progressBar.textContent = '0%';
        }
        
        // Hide modal
        function hideProgressModal() {
            modal.style.display = 'none';
        }
        
        // Update progress bar
        function updateProgress(percent, message) {
            progressBar.style.width = percent + '%';
            progressBar.textContent = percent + '%';
            progressText.textContent = message;
            
            // Change color based on progress
            if (percent < 30) {
                progressBar.style.backgroundColor = "#ff5252";
            } else if (percent < 70) {
                progressBar.style.backgroundColor = "#ffeb3b";
                progressBar.style.color = "black";
            } else {
                progressBar.style.backgroundColor = "#4CAF50";
                progressBar.style.color = "white";
            }
        }
        
        // Fetch products from API
        async function fetchProducts() {
            try {
                updateProgress(10, 'Fetching products from API...');
                
                const response = await fetch('services/products.php');
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const products = await response.json();
                
                updateProgress(40, `Fetched ${products.length} products successfully`);
                return products;
            } catch (error) {
                updateProgress(0, 'Error fetching products: ' + error.message);
                setTimeout(hideProgressModal, 2000);
                throw error;
            }
        }
        
        // Store products in IndexedDB with progress updates
        async function storeProducts(products) {
            return new Promise((resolve, reject) => {
                if (!db) {
                    reject('Database not initialized');
                    return;
                }
                
                updateProgress(50, 'Preparing to store products...');
                
                const transaction = db.transaction(storeName, 'readwrite');
                const store = transaction.objectStore(storeName);
                
                // Clear existing data first
                const clearRequest = store.clear();
                
                clearRequest.onsuccess = () => {
                    updateProgress(60, 'Storing products in LocalDB...');
                    
                    let storedCount = 0;
                    const totalCount = products.length;
                    const batchSize = Math.ceil(totalCount / 10);
                    let nextProgressUpdate = 60;
                    
                    products.forEach((product, index) => {
                        const request = store.put(product);
                        
                        request.onsuccess = () => {
                            storedCount++;
                            
                            if (storedCount % batchSize === 0 || storedCount === totalCount) {
                                const progress = 60 + Math.floor((storedCount / totalCount) * 30);
                                if (progress > nextProgressUpdate) {
                                    nextProgressUpdate = progress;
                                    updateProgress(
                                        progress,
                                        `Stored ${storedCount} of ${totalCount} products`
                                    );
                                }
                            }
                            
                            if (storedCount === totalCount) {
                                updateProgress(100, 'All products stored successfully!');
                                setTimeout(() => {
                                    hideProgressModal();
                                    resolve();
                                }, 1000);
                            }
                        };
                        
                        request.onerror = (event) => {
                            updateProgress(0, 'Error storing product: ' + event.target.error);
                            setTimeout(hideProgressModal, 2000);
                            reject(event.target.error);
                        };
                    });
                };
                
                clearRequest.onerror = (event) => {
                    updateProgress(0, 'Error clearing store: ' + event.target.error);
                    setTimeout(hideProgressModal, 2000);
                    reject(event.target.error);
                };
            });
        }
        
        // Load products from IndexedDB
        function loadProductsFromDB() {
            return new Promise((resolve, reject) => {
                if (!db) {
                    reject('Database not initialized');
                    return;
                }
                
                const transaction = db.transaction(storeName, 'readonly');
                const store = transaction.objectStore(storeName);
                const request = store.getAll();
                
                request.onsuccess = (event) => {
                    const products = event.target.result;
                    console.log(`Loaded ${products.length} products from LocalDB`);
                    resolve(products);
                };
                
                request.onerror = (event) => {
                    showError('Error loading products: ' + event.target.error);
                    reject(event.target.error);
                };
            });
        }
        
        // Clear IndexedDB
        function clearDB() {
            return new Promise((resolve, reject) => {
                if (!db) {
                    reject('Database not initialized');
                    return;
                }
                
                const transaction = db.transaction(storeName, 'readwrite');
                const store = transaction.objectStore(storeName);
                const request = store.clear();
                
                request.onsuccess = () => {
                    console.log('LocalDB cleared');
                    resolve();
                };
                
                request.onerror = (event) => {
                    showError('Error clearing LocalDB: ' + event.target.error);
                    reject(event.target.error);
                };
            });
        }
        
        // Display products in table with pagination
        function displayProducts(products) {
            allProducts = products;
            totalPages = Math.ceil(allProducts.length / itemsPerPage);
            currentPage = 1;
            
            updatePagination();
            renderTable();
        }
        
        // Render the current page of products
        function renderTable() {
            // Clear existing table rows
            tableBody.innerHTML = '';
            
            if (allProducts.length === 0) {
                const row = document.createElement('tr');
                row.innerHTML = '<td colspan="4" style="text-align: center;">No products found</td>';
                tableBody.appendChild(row);
                updatePageInfo(0, 0, 0);
                return;
            }
            
            // Calculate start and end index
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, allProducts.length);
            const pageProducts = allProducts.slice(startIndex, endIndex);
            
            // Sort by updatedAt (newest first)
            pageProducts.sort((a, b) => new Date(b.updatedAt) - new Date(a.updatedAt));
            
            // Add products to table
            pageProducts.forEach(product => {
                const row = document.createElement('tr');
                
                // Format price with 2 decimal places
                const formattedPrice = parseFloat(product.price).toFixed(2);
                
                // Format date
                const updatedDate = new Date(product.updatedAt);
                const formattedDate = updatedDate.toLocaleDateString() + ' ' + updatedDate.toLocaleTimeString();
                
                row.innerHTML = `
                    <td>${product.productId}</td>
                    <td>${product.name}</td>
                    <td>$${formattedPrice}</td>
                    <td>${formattedDate}</td>
                `;
                
                tableBody.appendChild(row);
            });
            
            updatePageInfo(startIndex + 1, endIndex, allProducts.length);
        }
        
        // Update pagination controls
        function updatePagination() {
            // Clear existing page numbers
            pageNumbersDiv.innerHTML = '';
            
            // Calculate which page numbers to show (max 5 at a time)
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, currentPage + 2);
            
            // Adjust if we're at the beginning or end
            if (currentPage <= 3) {
                endPage = Math.min(5, totalPages);
            }
            if (currentPage >= totalPages - 2) {
                startPage = Math.max(1, totalPages - 4);
            }
            
            // Create page number buttons
            for (let i = startPage; i <= endPage; i++) {
                const pageBtn = document.createElement('button');
                pageBtn.textContent = i;
                if (i === currentPage) {
                    pageBtn.classList.add('active');
                }
                pageBtn.addEventListener('click', () => {
                    currentPage = i;
                    renderTable();
                    updatePagination();
                });
                pageNumbersDiv.appendChild(pageBtn);
            }
            
            // Enable/disable navigation buttons
            firstPageBtn.disabled = currentPage === 1;
            prevPageBtn.disabled = currentPage === 1;
            nextPageBtn.disabled = currentPage === totalPages;
            lastPageBtn.disabled = currentPage === totalPages;
        }
        
        // Update page information text
        function updatePageInfo(start, end, total) {
            if (total === 0) {
                pageInfoDiv.textContent = 'Showing 0 of 0 products';
            } else {
                pageInfoDiv.textContent = `Showing ${start} to ${end} of ${total} products`;
            }
        }
        
        // Show error message
        function showError(message) {
            alert(message);
        }
        
        // Event listeners
        fetchBtn.addEventListener('click', async () => {
            showProgressModal();
            try {
                const products = await fetchProducts();
                await storeProducts(products);
                displayProducts(products);
            } catch (error) {
                console.error('Error:', error);
            }
        });
        
        loadFromDBBtn.addEventListener('click', async () => {
            try {
                const products = await loadProductsFromDB();
                displayProducts(products);
            } catch (error) {
                console.error('Error:', error);
            }
        });
        
        clearDBBtn.addEventListener('click', async () => {
            try {
                await clearDB();
                displayProducts([]);
            } catch (error) {
                console.error('Error:', error);
            }
        });
        
        // Pagination event listeners
        firstPageBtn.addEventListener('click', () => {
            currentPage = 1;
            renderTable();
            updatePagination();
        });
        
        prevPageBtn.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
                updatePagination();
            }
        });
        
        nextPageBtn.addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                renderTable();
                updatePagination();
            }
        });
        
        lastPageBtn.addEventListener('click', () => {
            currentPage = totalPages;
            renderTable();
            updatePagination();
        });
        
        closeBtn.addEventListener('click', hideProgressModal);
        
        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                hideProgressModal();
            }
        });
        
        // Initialize the application
        (async function() {
            try {
                await initDB();
                // Try to load products from DB on startup
                const products = await loadProductsFromDB();
                displayProducts(products);
            } catch (error) {
                console.error('Initialization error:', error);
            }
        })();
    </script>
</body>
</html>