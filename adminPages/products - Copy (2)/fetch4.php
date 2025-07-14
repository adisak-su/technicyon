<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management with Bootstrap</title>
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <style>
        /* Custom styles */
        .progress-bar {
            transition: width 0.3s ease;
        }
        .table-container {
            min-height: 400px;
        }
        .page-info {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col">
                <h1 class="mb-4">Product Management</h1>
                
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex flex-wrap mb-3">
                            <button id="fetchBtn" class="btn btn-primary mr-2 mb-2">
                                <i class="fas fa-sync-alt mr-1"></i> Fetch and Store Products
                            </button>
                            <button id="loadFromDBBtn" class="btn btn-secondary mr-2 mb-2">
                                <i class="fas fa-database mr-1"></i> Load from LocalDB
                            </button>
                            <button id="clearDBBtn" class="btn btn-danger mb-2">
                                <i class="fas fa-trash-alt mr-1"></i> Clear LocalDB
                            </button>
                        </div>
                        
                        <div class="table-responsive table-container">
                            <table class="table table-striped table-hover table-bordered">
                                <thead class="thead-dark">
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
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div id="pageInfo" class="page-info"></div>
                                <nav aria-label="Product pagination">
                                    <ul id="pagination" class="pagination mb-0">
                                        <!-- Pagination will be inserted here -->
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Modal -->
    <div class="modal fade" id="progressModal" tabindex="-1" role="dialog" aria-labelledby="progressModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="progressModalLabel">Processing Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="progressText" class="mb-2">Starting...</div>
                    <div class="progress">
                        <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%">0%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery, Popper.js, Bootstrap JS, and Font Awesome -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

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
        const fetchBtn = $('#fetchBtn');
        const loadFromDBBtn = $('#loadFromDBBtn');
        const clearDBBtn = $('#clearDBBtn');
        const tableBody = $('#productsTableBody');
        const modal = $('#progressModal');
        const progressBar = $('#progressBar');
        const progressText = $('#progressText');
        const pageInfoDiv = $('#pageInfo');
        const paginationUl = $('#pagination');
        
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
            progressBar.css('width', '0%').text('0%');
            progressText.text('Starting...');
            modal.modal('show');
        }
        
        // Update progress bar
        function updateProgress(percent, message) {
            progressBar.css('width', percent + '%').text(percent + '%');
            progressText.text(message);
            
            // Change color based on progress
            if (percent < 30) {
                progressBar.removeClass('bg-warning bg-success').addClass('bg-danger');
            } else if (percent < 70) {
                progressBar.removeClass('bg-danger bg-success').addClass('bg-warning');
            } else {
                progressBar.removeClass('bg-danger bg-warning').addClass('bg-success');
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
                setTimeout(() => modal.modal('hide'), 2000);
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
                                    modal.modal('hide');
                                    resolve();
                                }, 1000);
                            }
                        };
                        
                        request.onerror = (event) => {
                            updateProgress(0, 'Error storing product: ' + event.target.error);
                            setTimeout(() => modal.modal('hide'), 2000);
                            reject(event.target.error);
                        };
                    });
                };
                
                clearRequest.onerror = (event) => {
                    updateProgress(0, 'Error clearing store: ' + event.target.error);
                    setTimeout(() => modal.modal('hide'), 2000);
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
            tableBody.empty();
            
            if (allProducts.length === 0) {
                tableBody.append(
                    '<tr><td colspan="4" class="text-center py-4">No products found</td></tr>'
                );
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
                // Format price with 2 decimal places
                const formattedPrice = parseFloat(product.price).toFixed(2);
                
                // Format date
                const updatedDate = new Date(product.updatedAt);
                const formattedDate = updatedDate.toLocaleDateString() + ' ' + updatedDate.toLocaleTimeString();
                
                const row = $(
                    `<tr>
                        <td>${product.productId}</td>
                        <td>${product.name}</td>
                        <td>$${formattedPrice}</td>
                        <td>${formattedDate}</td>
                    </tr>`
                );
                
                tableBody.append(row);
            });
            
            updatePageInfo(startIndex + 1, endIndex, allProducts.length);
        }
        
        // Update pagination controls
        function updatePagination() {
            // Clear existing pagination
            paginationUl.empty();
            
            // Previous button
            const prevLi = $(
                `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>`
            );
            prevLi.find('a').click((e) => {
                e.preventDefault();
                if (currentPage > 1) {
                    currentPage--;
                    renderTable();
                    updatePagination();
                }
            });
            paginationUl.append(prevLi);
            
            // Page numbers
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, currentPage + 2);
            
            // Adjust if we're at the beginning or end
            if (currentPage <= 3) {
                endPage = Math.min(5, totalPages);
            }
            if (currentPage >= totalPages - 2) {
                startPage = Math.max(1, totalPages - 4);
            }
            
            // First page and ellipsis
            if (startPage > 1) {
                const firstLi = $(
                    `<li class="page-item ${currentPage === 1 ? 'active' : ''}">
                        <a class="page-link" href="#">1</a>
                    </li>`
                );
                firstLi.find('a').click((e) => {
                    e.preventDefault();
                    currentPage = 1;
                    renderTable();
                    updatePagination();
                });
                paginationUl.append(firstLi);
                
                if (startPage > 2) {
                    paginationUl.append(
                        '<li class="page-item disabled"><span class="page-link">...</span></li>'
                    );
                }
            }
            
            // Middle pages
            for (let i = startPage; i <= endPage; i++) {
                const pageLi = $(
                    `<li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="#">${i}</a>
                    </li>`
                );
                pageLi.find('a').click((e) => {
                    e.preventDefault();
                    currentPage = i;
                    renderTable();
                    updatePagination();
                });
                paginationUl.append(pageLi);
            }
            
            // Last page and ellipsis
            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    paginationUl.append(
                        '<li class="page-item disabled"><span class="page-link">...</span></li>'
                    );
                }
                
                const lastLi = $(
                    `<li class="page-item ${currentPage === totalPages ? 'active' : ''}">
                        <a class="page-link" href="#">${totalPages}</a>
                    </li>`
                );
                lastLi.find('a').click((e) => {
                    e.preventDefault();
                    currentPage = totalPages;
                    renderTable();
                    updatePagination();
                });
                paginationUl.append(lastLi);
            }
            
            // Next button
            const nextLi = $(
                `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>`
            );
            nextLi.find('a').click((e) => {
                e.preventDefault();
                if (currentPage < totalPages) {
                    currentPage++;
                    renderTable();
                    updatePagination();
                }
            });
            paginationUl.append(nextLi);
        }
        
        // Update page information text
        function updatePageInfo(start, end, total) {
            if (total === 0) {
                pageInfoDiv.text('Showing 0 of 0 products');
            } else {
                pageInfoDiv.text(`Showing ${start} to ${end} of ${total} products`);
            }
        }
        
        // Show error message
        function showError(message) {
            // Using Bootstrap's toast for error messages
            const toast = $(
                `<div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000" 
                    style="position: fixed; top: 20px; right: 20px; min-width: 300px;">
                    <div class="toast-header bg-danger text-white">
                        <strong class="mr-auto">Error</strong>
                        <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>`
            );
            
            $('body').append(toast);
            toast.toast('show');
            
            toast.on('hidden.bs.toast', function() {
                $(this).remove();
            });
        }
        
        // Event listeners
        fetchBtn.click(async () => {
            showProgressModal();
            try {
                const products = await fetchProducts();
                await storeProducts(products);
                displayProducts(products);
            } catch (error) {
                console.error('Error:', error);
            }
        });
        
        loadFromDBBtn.click(async () => {
            try {
                const products = await loadProductsFromDB();
                displayProducts(products);
            } catch (error) {
                console.error('Error:', error);
            }
        });
        
        clearDBBtn.click(async () => {
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