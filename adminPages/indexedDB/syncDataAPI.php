<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <style>
        .progress-label {
            font-size: 14px;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <!-- Progress Modal -->
    <div class="modal fade" id="progressModal" tabindex="-1" role="dialog" aria-labelledby="progressModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="progressModalLabel">Loading Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <div class="progress-label">Products</div>
                        <div class="progress">
                            <div id="products-progress" class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="progress-label">Customers</div>
                        <div class="progress">
                            <div id="customers-progress" class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="progress-label">Usercars</div>
                        <div class="progress">
                            <div id="usercars-progress" class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="progress-label">Groupnames</div>
                        <div class="progress">
                            <div id="groupnames-progress" class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="progress-label">Typenames</div>
                        <div class="progress">
                            <div id="typenames-progress" class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="progress-label">Overall Progress</div>
                        <div class="progress">
                            <div id="overall-progress" class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary boxx" data-dismiss="modal" id="closeModalBtn" disabled>Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
    <script src="../../plugins/jquery/jquery.slim.min.js"></script>
    <script src="../../plugins/popper/umd/popper.min.js"></script>
    <script src="../../assets/js/adminlte.min.js"></script>

    -->
    <script src="../../plugins/jquery/jquery.slim.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- <script src="app.js"></script> -->
    <script>
        // Database setup
        const dbVersion = 1;

        const dbName = "LocalDBTest",
            storeNames = [{
                storeName: "products",
                keyPath: "productId"
            }, {
                storeName: "usercars",
                keyPath: "carId"
            }, {
                storeName: "customers",
                keyPath: "customerId"
            }, {
                storeName: "groupnames",
                keyPath: "groupname"
            }, {
                storeName: "typenames",
                keyPath: "typename"
            }];
        metaStore = "meta";
        let lastSyncTime = "empty";

        let db;
        let currentPage = 1;
        const itemsPerPage = 10;

        // Open or create IndexedDB
        const openDB = () => {
            return new Promise((resolve, reject) => {
                const request = indexedDB.open(dbName, dbVersion);

                request.onupgradeneeded = (event) => {
                    const db = event.target.result;

                    // Create store if it doesn't exist
                    storeNames.forEach((store) => {
                        if (!db.objectStoreNames.contains(store.storeName)) db.createObjectStore(store.storeName, {
                            keyPath: store.keyPath
                        });
                    });
                    if (!db.objectStoreNames.contains(metaStore)) db.createObjectStore(metaStore, {
                        keyPath: "tableName"
                    });
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
                const transaction = db.transaction([storeName], 'readwrite');
                const store = transaction.objectStore(storeName);

               

                
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
                    saveLastSyncTime(storeName,lastSyncTime)
                

                
            });
        };
        
        const storeDataOld = (storeName, data) => {
            return new Promise((resolve, reject) => {
                //const transaction = db.transaction([storeName], 'readwrite');
                const transaction = db.transaction([storeName], 'readwrite');
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
                    saveLastSyncTime(storeName,lastSyncTime)
                };

                clearRequest.onerror = (event) => {
                    console.error(`Error clearing ${storeName}:`, event.target.error);
                    reject(event.target.error);
                };
            });
        };
        
        Date.prototype.addHours = function(h) {
            this.setHours(this.getHours() + h);
            return this;
        }
        // Fetch data from API
        const fetchData = async (endpoint, progressKey) => {
            try {
                // Show initial progress
                document.getElementById(`${progressKey}-progress`).style.width = '0%';

                const lastSyncTime = await getLastSyncTime(progressKey);
                //const lastSyncTime = "empty";
                const response = await fetch(`syncFromApi/${endpoint}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer my-secret-token',
                        'Custom-Header': 'HelloWorld'
                    },
                    body: JSON.stringify({
                        lastSyncTime: lastSyncTime
                    })
                })
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                await storeData(progressKey, data);
                let nowSyncTime = new Date().addHours(7).toISOString().replace("T", " ").substr(0, 19);
                await saveLastSyncTime(progressKey,nowSyncTime);

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

                let urls = storeNames.map(store => fetchData(store.storeName + ".php", store.storeName));
                await Promise.all(urls);

                // Update overall progress to 100%
                document.getElementById('overall-progress').style.width = '100%';

                // Enable close button
                document.getElementById('closeModalBtn').disabled = false;
                setTimeout(closeModal, 5000);

            } catch (error) {
                console.error('Error loading data:', error);
                alert('Error loading data. Please check console for details.');
            }
        };

        async function saveLastSyncTime(tableName,lastSyncTime) {
            const tx = db.transaction(metaStore, "readwrite");
            const meta = tx.objectStore(metaStore);
            let object = {tableName:tableName,lastSyncTime:lastSyncTime};
            meta.put(object);
        }

        async function getLastSyncTime(tableName) {
            return new Promise((resolve, reject) => {
                const req = db.transaction(metaStore).objectStore(metaStore).get(tableName);
                // let result = req.result?.lastSyncTime.value;
                req.onsuccess = async () => {
                    if(req.result) {
                        resolve(req.result.lastSyncTime);
                    }
                    else {
                        resolve("empty");
                    }
                };
                req.onerror = async () => {
                    reject("empty");
                };
            });
        }

        function closeModal() {
            $('#progressModal').modal('hide');
            window.location.assign("../index.php");
        }

        // Initialize the application when DOM is loaded
        document.addEventListener('DOMContentLoaded', async () => {
            loadAllData();

            // Close modal handler
            document.getElementById('closeModalBtn').addEventListener('click', () => {
                $('#progressModal').modal('hide');
            });
        });
    </script>

</body>

</html>