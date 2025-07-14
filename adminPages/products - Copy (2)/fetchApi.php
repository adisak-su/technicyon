<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
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
        .status {
            margin: 10px 0;
            padding: 10px;
            border-radius: 4px;
        }
        .loading {
            background-color: #fff3cd;
            color: #856404;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <h1>Product Management</h1>
    
    <div class="controls">
        <button id="fetchBtn">Fetch Products</button>
        <button id="loadFromDBBtn">Load from LocalDB</button>
        <button id="clearDBBtn">Clear LocalDB</button>
    </div>
    
    <div id="status" class="status"></div>
    
    <div id="tableContainer">
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
        const statusDiv = document.getElementById('status');
        const tableBody = document.getElementById('productsTableBody');
        
        // Initialize the database
        function initDB() {
            return new Promise((resolve, reject) => {
                const request = indexedDB.open(dbName, dbVersion);
                
                request.onerror = (event) => {
                    showStatus('Error opening database', 'error');
                    reject('Database error: ' + event.target.errorCode);
                };
                
                request.onsuccess = (event) => {
                    db = event.target.result;
                    showStatus('Database initialized', 'success');
                    resolve(db);
                };
                
                request.onupgradeneeded = (event) => {
                    const db = event.target.result;
                    if (!db.objectStoreNames.contains(storeName)) {
                        const store = db.createObjectStore(storeName, { keyPath: 'productId' });
                        showStatus('Database created', 'success');
                    }
                };
            });
        }
        
        // Fetch products from API
        async function fetchProducts() {
            showStatus('Fetching products from API...', 'loading');
            
            try {
                const response = await fetch('services/products.php');
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const products = await response.json();
                
                showStatus(`Fetched ${products.length} products from API`, 'success');
                return products;
            } catch (error) {
                showStatus('Error fetching products: ' + error.message, 'error');
                throw error;
            }
        }
        
        // Store products in IndexedDB
        function storeProducts(products) {
            return new Promise((resolve, reject) => {
                if (!db) {
                    reject('Database not initialized');
                    return;
                }
                
                const transaction = db.transaction(storeName, 'readwrite');
                const store = transaction.objectStore(storeName);
                
                // Clear existing data first
                const clearRequest = store.clear();
                
                clearRequest.onsuccess = () => {
                    showStatus('Storing products in LocalDB...', 'loading');
                    
                    let storedCount = 0;
                    const totalCount = products.length;
                    
                    products.forEach(product => {
                        const request = store.put(product);
                        
                        request.onsuccess = () => {
                            storedCount++;
                            if (storedCount === totalCount) {
                                showStatus(`Stored ${storedCount} products in LocalDB`, 'success');
                                resolve();
                            }
                        };
                        
                        request.onerror = (event) => {
                            showStatus('Error storing product: ' + event.target.error, 'error');
                            reject(event.target.error);
                        };
                    });
                };
                
                clearRequest.onerror = (event) => {
                    showStatus('Error clearing store: ' + event.target.error, 'error');
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
                
                showStatus('Loading products from LocalDB...', 'loading');
                
                const transaction = db.transaction(storeName, 'readonly');
                const store = transaction.objectStore(storeName);
                const request = store.getAll();
                
                request.onsuccess = (event) => {
                    const products = event.target.result;
                    showStatus(`Loaded ${products.length} products from LocalDB`, 'success');
                    resolve(products);
                };
                
                request.onerror = (event) => {
                    showStatus('Error loading products: ' + event.target.error, 'error');
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
                
                showStatus('Clearing LocalDB...', 'loading');
                
                const transaction = db.transaction(storeName, 'readwrite');
                const store = transaction.objectStore(storeName);
                const request = store.clear();
                
                request.onsuccess = () => {
                    showStatus('LocalDB cleared', 'success');
                    resolve();
                };
                
                request.onerror = (event) => {
                    showStatus('Error clearing LocalDB: ' + event.target.error, 'error');
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
        
        // Show status message
        function showStatus(message, type) {
            statusDiv.textContent = message;
            statusDiv.className = 'status ' + (type || '');
        }
        
        // Event listeners
        fetchBtn.addEventListener('click', async () => {
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