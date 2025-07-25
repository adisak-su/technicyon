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

        .modal-backdrop {
            background-color: rgba(0, 0, 0, .0001) !important;
        }
    </style>
</head>

<body>
    <div class="bg">
    </div>
    <!-- Progress Modal -->
    <div class="modal fade" id="progressModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="progressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="progressModalLabel">กำลังโหลดข้อมูลจาก Server</h5>
                </div>
                <div class="modal-body">
                    <div id="progressBar"></div>
                    <!-- <div class="mb-3">
                        <div class="progress-label">ข้อมูลสินค้า</div>
                        <div class="progress">
                            <div id="products-progress" class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="progress-label">ข้อมูลลูกค้า</div>
                        <div class="progress">
                            <div id="customers-progress" class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="progress-label">ข้อมูลร้านค้า</div>
                        <div class="progress">
                            <div id="suppliers-progress" class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="progress-label">ข้อมูลทะเบียนรถ</div>
                        <div class="progress">
                            <div id="usercars-progress" class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="progress-label">ข้อมูลยี่ห้อ/รุ่น</div>
                        <div class="progress">
                            <div id="groupnames-progress" class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="progress-label">ข้อมูลประเภทสินค้า</div>
                        <div class="progress">
                            <div id="typenames-progress" class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="progress-label">ข้อมูลสี</div>
                        <div class="progress">
                            <div id="colornames-progress" class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div> -->
                    <div class="mb-3">
                        <div class="progress-label" style="font-size: 20px;">ข้อมูลทั้งหมด</div>
                        <div class="progress">
                            <div id="overall-progress" class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning boxx d-none" id="closeModalBtn">โหลดข้อมูลใหม่อีกครั้ง</button>
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
    <!-- <script src="../../plugins/jquery/jquery.slim.min.js"></script> -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

    <!-- <script src="app.js"></script> -->
    <script>
        // Database setup
        const dbVersion = 1;

        const dbName = "LocalDBTest";
        let storeNames = [{
            storeName: "products",
            storeNameThai: "ข้อมูลสินค้า",
            // keyPath: "productId",
            keyPath: "productNo",
            count: 0
        }, {
            storeName: "usercars",
            storeNameThai: "ข้อมูลทะเบียนรถ",
            keyPath: "usercarNo",
            count: 0
        }, {
            storeName: "customers",
            storeNameThai: "ข้อมูลลูกค้า",
            keyPath: "customerNo",
            count: 0
        }, {
            storeName: "suppliers",
            storeNameThai: "ข้อมูลร้านค้า",
            keyPath: "supplierNo",
            count: 0
        }, {
            storeName: "groupnames",
            storeNameThai: "ข้อมูลยี่ห้อ/รุ่นรถยนต์",
            keyPath: "groupNo",
            count: 0
            // keyPath: "groupname"
        }, {
            storeName: "typenames",
            storeNameThai: "ข้อมูลประเภทสินค้า",
            keyPath: "typeNo",
            count: 0
            // keyPath: "typename"
        }, {
            storeName: "colornames",
            storeNameThai: "ข้อมูลสีรถยนต์",
            keyPath: "colorNo",
            count: 0
            // keyPath: "typename"
        }, {
            storeName: "technicalnames",
            storeNameThai: "ข้อมูลช่างซ่อม",
            keyPath: "technicalNo",
            count: 0
            // keyPath: "typename"
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

                        if (!db.objectStoreNames.contains(store.storeName)) {
                            db.createObjectStore(store.storeName, {
                                keyPath: store.keyPath
                            });
                        }
                    });

                    if (db.objectStoreNames.contains(metaStore)) {
                        db.deleteObject(metaStore);
                    }
                    if (!db.objectStoreNames.contains(metaStore)) {
                        db.createObjectStore(metaStore, {
                            keyPath: "tableName"
                        });
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

        const reloadDB = async () => {
            if (db) await db.close();
            var req = indexedDB.deleteDatabase(dbName);
            req.onsuccess = () => {
                loadAllData();
            };
            req.onerror = () => {
                alert("onerror");
            };
            req.onblocked = () => {
                alert("onblocked");
            };
        }

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

                    let sumProgress = 0
                    storeNames.forEach((store) => {
                        sumProgress += parseInt(document.getElementById(store.storeName + '-progress').style.width) || 0;
                    });
                    // Update overall progress
                    // const productsProgress = document.getElementById('products-progress').style.width;
                    // const customersProgress = document.getElementById('customers-progress').style.width;

                    // const productsPercent = parseInt(productsProgress) || 0;
                    // const customersPercent = parseInt(customersProgress) || 0;
                    // const overallPercent = Math.floor((productsPercent + customersPercent) / 2);

                    const overallPercent = Math.floor(sumProgress / storeNames.length);
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
                saveLastSyncTime(storeName, lastSyncTime)
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
                        'Accept-Encoding': 'gzip, deflate, br',
                        'Custom-Header': 'HelloWorld',
                    },
                    body: JSON.stringify({
                        lastSyncTime: lastSyncTime
                    })
                })
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                let data = await response.json();
                // if (progressKey == "products" || progressKey == "usercars") {
                //     data = await response.json();
                // }

                await storeData(progressKey, data);
                let nowSyncTime = new Date().addHours(7).toISOString().replace("T", " ").substr(0, 19);
                await saveLastSyncTime(progressKey, nowSyncTime);

                // Complete progress
                document.getElementById(`${progressKey}-progress`).style.width = '100%';

                return data;
            } catch (error) {
                console.error(`Error fetching ${endpoint}:`, error);
                throw error;
            }
        };

        const updateData = async (endpoint, progressKey) => {
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
                        'Accept-Encoding': 'gzip, deflate, br',
                        'Custom-Header': 'HelloWorld',
                    },
                    body: JSON.stringify({
                        lastSyncTime: lastSyncTime
                    })
                })
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                let data = await response.json();
                // if (progressKey == "products" || progressKey == "usercars") {
                //     data = await response.json();
                // }

                await storeData(progressKey, data);
                let nowSyncTime = new Date().addHours(7).toISOString().replace("T", " ").substr(0, 19);
                await saveLastSyncTime(progressKey, nowSyncTime);

                // Complete progress
                document.getElementById(`${progressKey}-progress`).style.width = '100%';

                return data;
            } catch (error) {
                console.error(`Error fetching ${endpoint}:`, error);
                throw error;
            }
        };

        let getRowData = async (store) => {
            return new Promise((resolve, reject) => {
                // let store = storeNames[i];
                let transaction = db.transaction([store.storeName], "readonly");
                let objectStore = transaction.objectStore(store.storeName);
                let count = objectStore.count();
                count.onsuccess = function() {
                    resolve(count);
                };
            });
        }

        let checkTableIndexeddb = async () => {
            return new Promise((resolve, reject) => {
                let countRecordInTable = [];
                for (i = 0; i < storeNames.length; i++) {
                    let store = storeNames[i];
                    let transaction = db.transaction([store.storeName], "readonly");
                    let objectStore = transaction.objectStore(store.storeName);
                    let count = objectStore.count();
                    count.onsuccess = function() {
                        countRecordInTable.push({
                            storeName: store.storeName,
                            count: count.result
                        });

                        if (countRecordInTable.length == storeNames.length) {
                            resolve(countRecordInTable);
                        }
                    };
                }
            });
        }
        // Load all data with progress tracking
        const loadAllData = async () => {
            $('#progressModal').modal('show');
            // createProgressBar();

            try {
                await openDB();
                // let tableCount = await checkTableIndexeddb();
                // tableCount.forEach((item) => {
                //     let store = storeNames.find((elem) => elem.storeName === item.storeName);
                //     if (store) {
                //         store.count = item.count;
                //     }
                // });

                let dataSync = await syncOnLoad();
                if (dataSync.status) {
                    closeModal();
                    // alert(dataSync.status)
                    return;
                }

                // let urls = [];
                // storeNames.forEach((store) => {
                //     if (store.count == 0) {
                //         urls.push(fetchData(store.storeName + ".php", store.storeName));
                //     } else {
                //         urls.push(fetchData(store.storeName + ".php", store.storeName));
                //     }
                // })

                let urls = storeNames.map(store => fetchData(store.storeName + ".php", store.storeName));
                await Promise.all(urls);

                // Update overall progress to 100%
                document.getElementById('overall-progress').style.width = '100%';

                // Enable close button
                // document.getElementById('closeModalBtn').disabled = false;

                setTimeout(closeModal, 1000);

            } catch (error) {
                console.error('Error loading data:', error);
                alert('Error loading data. Please check console for details.');
                if (db) await db.close();
                // document.getElementById('closeModalBtn').disabled = false;
                // $('#closeModalBtn').addClass("d-none");
                $('#closeModalBtn').removeClass("d-none");

            }
        };

        async function saveLastSyncTime(tableName, lastSyncTime) {
            const tx = db.transaction(metaStore, "readwrite");
            const meta = tx.objectStore(metaStore);
            let object = {
                tableName: tableName,
                lastSyncTime: lastSyncTime
            };
            meta.put(object);
        }

        async function getLastSyncTime(tableName) {
            return new Promise((resolve, reject) => {
                const req = db.transaction(metaStore).objectStore(metaStore).get(tableName);
                // let result = req.result?.lastSyncTime.value;
                req.onsuccess = async () => {
                    if (req.result) {
                        resolve(req.result.lastSyncTime);
                    } else {
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
            // window.location.assign("../index.php");
            window.location.assign("../settings/index.php");
        }

        async function createProgressBar() {
            let html = "";
            storeNames.forEach((item) => {
                html += `
                    <div class="mb-3">
                        <div class="progress-label">${item.storeNameThai}</div>
                        <div class="progress">
                            <div id="${item.storeName}-progress" class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>
                    `;
            })
            document.getElementById('progressBar').innerHTML = html;
        }

        // createProgressBar();
        // Initialize the application when DOM is loaded
        document.addEventListener('DOMContentLoaded', async () => {
            // await indexedDB.deleteDatabase(dbName);
            // loadCompressionLibraries();

            await createProgressBar();
            loadAllData();

            // Close modal handler
            document.getElementById('closeModalBtn').addEventListener('click', () => {
                //$('#progressModal').modal('hide');
                // document.getElementById('closeModalBtn').disabled = true;
                // document.getElementById('closeModalBtn').classList.remove("d-none");
                $('#closeModalBtn').removeClass("d-none");

                reloadDB();

            });
        });

        //  update data from server to indexeddb
        async function syncOnLoad() {
            try {
                // await openDB();
                // 1. ดึงเวลาซิงค์ล่าสุดจาก IndexedDB
                const lastSyncRecord = await getLastSyncFromMeta();
                if (!lastSyncRecord?.length) {
                    return {
                        status: false
                    };
                }

                // 2. ดึงการเปลี่ยนแปลงจากเซิร์ฟเวอร์
                let changes = await getDataLastSync(lastSyncRecord);

                if (!changes || changes.length === 0) return {
                    status: true
                };
                // let tableNames = changes.map(item=>item.table_name);
                const tableNames = [...new Set(changes.map((item) => item.table))];

                let total = changes.length
                const updateProgressAll = (count) => {
                    const progress = Math.floor((count / total) * 100);
                    document.getElementById('overall-progress').style.width = `${progress}%`;
                };

                // 3. ประมวลผลการเปลี่ยนแปลง
                for (i = 0; i < changes.length; i++) {
                    item = changes[i];
                    const store = item.table;
                    switch (item.type) {
                        case "CREATE":
                            await createDataToDB(store, item.data);
                            break;

                        case "UPDATE":
                            await updateDataToDB(store, item.data, item.id);
                            break;

                        case "DELETE":
                            await deleteDataFromDB(store, item.id);
                            break;
                    }
                    updateProgressAll(i);
                }

                // 4. อัปเดตเวลาซิงค์ล่าสุด
                let newSyncTime = new Date()
                    .addHours(7)
                    .toISOString()
                    .replace("T", " ")
                    .substr(0, 19);
                // let newSyncTime = getDateTimeNow();

                // for (i = 0; i < changes.length; i++) {
                //     item = changes[i];
                //     let store = item.table;
                //     updateDataToDB("meta", {
                //         tableName: store,
                //         lastSyncTime: newSyncTime,
                //     });
                // }

                tableNames.forEach((item) => {
                    putDataToDB("meta", {
                        tableName: item,
                        lastSyncTime: newSyncTime,
                    });
                })

                return {
                    status: true,
                    tableNames: tableNames
                };
            } catch (error) {
                console.error("Sync failed:", error);
                throw new Error(error);
                // throw new Error("Parameter is not a number!");
            }
        }

        const getLastSyncFromMeta = () => {
            return new Promise((resolve, reject) => {
                const transaction = db.transaction("meta", "readonly");
                const store = transaction.objectStore("meta");

                const request = store.getAll();
                request.onsuccess = () => {
                    resolve(request.result);
                };

                request.onerror = (event) => {
                    console.error("Error getting products:", event.target.error);
                    reject(event.target.error);
                };
            });
        };

        async function getDataLastSync(lastSyncRecord) {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    url: "../js/syncData.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        lastSyncRecord: lastSyncRecord,
                    },
                    beforeSend: function() {},
                    success: function(data) {
                        resolve(data);
                    },
                    error: function(err) {
                        // sweetAlertError("เกิดข้อผิดพลาด : " + err.responseText, 0);
                        reject(null);
                    },
                });
            });
        }

        async function createDataToDB(store, data) {
            try {
                const results = await putDataToDB(store, data);
                return results;
            } catch (error) {
                console.error("Error put data:", error);
                throw new Error(error);
            }
        }

        async function updateDataToDB(store, data, key = null) {
            try {
                if (key) {
                    await deleteDataFromDB(store, key);
                }
                const results = await putDataToDB(store, data);
                // const results = await updateCursorDB(store, data, key);
                return results;
            } catch (error) {
                console.error("Error put data:", error);
                throw new Error(error);
            }
        }

        async function deleteDataFromDB(store, key) {
            try {
                const results = await deleteDataFrom(store, key);
                return results;
            } catch (error) {
                console.error("Error delete key:", error);
                throw new Error(error);
            }
        }

        const putDataToDB = (params, data) => {
            return new Promise((resolve, reject) => {
                const transaction = db.transaction([params], "readwrite");
                const store = transaction.objectStore(params);
                const request = store.put(data);

                request.onsuccess = () => {
                    resolve(true);
                };

                request.onerror = (event) => {
                    console.error("Error getting products:", event.target.error);
                    reject(event.target.error);
                };
            });
        };

        const deleteDataFrom = (params, key) => {
            return new Promise((resolve, reject) => {
                if (["groupnames", "typenames", "colornames"].includes(params)) {
                    key = key * 1;
                }
                const transaction = db.transaction([params], "readwrite");
                const store = transaction.objectStore(params);
                const request = store.delete(key);

                request.onsuccess = () => {
                    resolve(true);
                };

                request.onerror = (event) => {
                    console.error("Error delete key:", event.target.error);
                    reject(event.target.error);
                };
            });
        };
    </script>

</body>

</html>