<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management with Progress</title>
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
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
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
        .close:hover {
            color: black;
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
        
        // DOM elements
        const fetchBtn = document.getElementById('fetchBtn');
        const loadFromDBBtn = document.getElementById('loadFromDBBtn');
        const clearDBBtn = document.getElementById('clearDBBtn');
        const tableBody = document.getElementById('productsTableBody');
        const modal = document.getElementById('progressModal');
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');
        const closeBtn = document.querySelector('.close');
        
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
                progressBar.style.backgroundColor = "#ff5252"; // red
            } else if (percent < 70) {
                progressBar.style.backgroundColor = "#ffeb3b"; // yellow
                progressBar.style.color = "black";
            } else {
                progressBar.style.backgroundColor = "#4CAF50"; // green
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
                    const batchSize = Math.ceil(totalCount / 10); // Update progress every 10%
                    let nextProgressUpdate = 60;
                    
                    products.forEach((product, index) => {
                        const request = store.put(product);
                        
                        request.onsuccess = () => {
                            storedCount++;
                            
                            // Update progress every batch or when complete
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
        
        // Display products in table
        function displayProducts(products) {
            // Clear existing table rows
            tableBody.innerHTML = '';
            
            if (products.length === 0) {
                const row = document.createElement('tr');
                row.innerHTML = '<td colspan="4" style="text-align: center;">No products found</td>';
                tableBody.appendChild(row);
                return;
            }
            
            // Sort by updatedAt (newest first)
            products.sort((a, b) => new Date(b.updatedAt) - new Date(a.updatedAt));
            
            // Add products to table
            products.forEach(product => {
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
        
        closeBtn.addEventListener('click', hideProgressModal);
        
        // Close modal when clicking outside of it
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