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
                    <h5 class="modal-title" id="progressModalLabel">กำลังโหลดข้อมูลจาก Sever</h5>
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
    <script src="../../plugins/jquery/jquery.slim.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pako/2.0.4/pako.min.js"></script>

    <!-- <script src="app.js"></script> -->
    <script>
        // Database setup
        const dbVersion = 1;

        const dbName = "LocalDBTest",
            storeNames = [{
                storeName: "products",
                storeNameThai: "ข้อมูลสินค้า",
                keyPath: "productId"
            }, {
                storeName: "usercars",
                storeNameThai: "ข้อมูลทะเบียนรถ",
                keyPath: "carId"
            }, {
                storeName: "customers",
                storeNameThai: "ข้อมูลลูกค้า",
                keyPath: "customerId"
            }, {
                storeName: "suppliers",
                storeNameThai: "ข้อมูลร้านค้า",
                keyPath: "supplierId"
            }, {
                storeName: "groupnames",
                storeNameThai: "ข้อมูลยี่ห้อ/รุ่นรถยนต์",
                keyPath: "groupId"
                // keyPath: "groupname"
            }, {
                storeName: "typenames",
                storeNameThai: "ข้อมูลประเภทสินค้า",
                keyPath: "typeId"
                // keyPath: "typename"
            }, {
                storeName: "colornames",
                storeNameThai: "ข้อมูลสีรถยนต์",
                keyPath: "colorId"
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

        async function decompressGzipUniversal(compressedData) {
            // ตรวจสอบว่าเบราว์เซอร์รองรับ DecompressionStream หรือไม่
            if (typeof DecompressionStream !== 'undefined') {
                try {
                    return await decompressGzipWithNativeAPI(compressedData);
                } catch (nativeError) {
                    console.warn('Native decompression failed, falling back to pako');
                }
            }

            // ถ้าไม่รองรับหรือมีข้อผิดพลาด ให้ใช้ pako
            if (typeof pako === 'undefined') {
                await loadPakoLibrary();
            }

            return await decompressGzipWithPako(compressedData);
        }

        async function decompressGzipWithPako(compressedData) {
            try {
                // แปลง ArrayBuffer เป็น Uint8Array
                const compressedArray = new Uint8Array(compressedData);

                // แตกบีบอัดด้วย pako
                const decompressedArray = pako.inflate(compressedArray);

                // แปลงเป็น string
                const decoder = new TextDecoder('utf-8');
                return decoder.decode(decompressedArray);
            } catch (error) {
                console.error('Pako decompression failed:', error);
                throw error;
            }
        }

        // ตัวอย่างการใช้งาน:
        async function fetchCompressedData() {
            const response = await fetch('https://example.com/api/data.gz');
            const compressedData = await response.arrayBuffer();

            const jsonString = await decompressGzipWithPako(compressedData);
            const data = JSON.parse(jsonString);
            console.log('ข้อมูลที่แตกแล้ว:', data);
            return data;
        }

        async function loadPakoLibrary() {
            // โหลด pako แบบ lazy
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/pako/2.0.4/pako.min.js';
            document.head.appendChild(script);

            return new Promise((resolve) => {
                script.onload = resolve;
            });
        }

        async function decompressGzipWithNativeAPI(compressedData) {
            try {
                // สร้าง DecompressionStream
                const ds = new DecompressionStream('gzip');

                // สร้าง stream สำหรับแปลงข้อมูล
                const decompressedStream = new Response(compressedData).body.pipeThrough(ds);

                // แปลง stream เป็น text
                const decompressed = await new Response(decompressedStream).text();

                return decompressed;
            } catch (error) {
                console.error('Native decompression failed:', error);
                throw error;
            }
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
                let data = null;
                if (progressKey == "products" || progressKey == "usercars") {
                    // 2. ตรวจสอบประเภทการบีบอัด
                    // const contentEncoding = response.headers.get('Content-Encoding') || '';
                    // let responseData;

                    // // 3. แตกข้อมูลตามประเภทการบีบอัด
                    // if (contentEncoding.includes('gzip')) {
                    //     const compressed = await response.arrayBuffer();
                    //     responseData = await decompressGzip(compressed);
                    // } else if (contentEncoding.includes('br')) {
                    //     // Brotli decompression (หากใช้)
                    //     const compressed = await response.arrayBuffer();
                    //     responseData = await decompressBrotli(compressed);
                    // } else {
                    //     // ไม่บีบอัด
                    //     responseData = await response.text();
                    // }

                    // data = JSON.parse(responseData);

                    // // 4. แปลง JSON เป็น Object
                    // return JSON.parse(responseData);

                    const compressedData = await response.arrayBuffer();

                    const decompressedData = await decompressGzipWithNativeAPI(compressedData);
                    console.log('ข้อมูลที่แตกแล้ว:', decompressedData);

                    data = JSON.parse(decompressedData);

                } else {
                    data = await response.json();
                }

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

        let checkTableIndexeddb = async () => {
            let countRecordInTable = storeNames.map(store => {
                var transaction = db.transaction([store.storeName], "readonly");
                var objectStore = transaction.objectStore(store.storeName);
                var count = objectStore.count();

                count.onsuccess = function() {
                    return count.result;
                };
            });
            return countRecordInTable;
        }

        // Load all data with progress tracking
        const loadAllData = async () => {
            $('#progressModal').modal('show');
            // createProgressBar();

            try {
                await openDB();

                alert(checkTableIndexeddb());

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
            window.location.assign("../index.php");
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
            // loadAllData();
            $('#progressModal').modal('show');

            let result = await getData();
            alert(result.length)

            // Close modal handler
            document.getElementById('closeModalBtn').addEventListener('click', () => {
                //$('#progressModal').modal('hide');
                // document.getElementById('closeModalBtn').disabled = true;
                // document.getElementById('closeModalBtn').classList.remove("d-none");
                $('#closeModalBtn').removeClass("d-none");

                // reloadDB();

            });
        });

        // โหลดไลบรารีบีบอัดแบบ lazy
        async function loadCompressionLibraries() {
            if (typeof pako === 'undefined') {
                await import('https://cdnjs.cloudflare.com/ajax/libs/pako/2.0.4/pako.min.js');
            }

            if (typeof BrotliDecode === 'undefined') {
                await import('https://cdn.jsdelivr.net/npm/brotli-dec@2.0.2/brotli_dec.min.js');
            }
        }

        async function decompressGzipUniversal(compressedData) {
            // ตรวจสอบว่าเบราว์เซอร์รองรับ DecompressionStream หรือไม่
            if (typeof DecompressionStream !== 'undefined') {
                try {
                    return await decompressGzipWithNativeAPI(compressedData);
                } catch (nativeError) {
                    console.warn('Native decompression failed, falling back to pako');
                }
            }

            // ถ้าไม่รองรับหรือมีข้อผิดพลาด ให้ใช้ pako
            if (typeof pako === 'undefined') {
                await loadPakoLibrary();
            }

            return await decompressGzipWithPako(compressedData);
        }

        async function loadPakoLibrary() {
            // โหลด pako แบบ lazy
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/pako/2.0.4/pako.min.js';
            document.head.appendChild(script);

            return new Promise((resolve) => {
                script.onload = resolve;
            });
        }

        // ตัวอย่างการใช้งาน:
        async function _getData() {
            try {
                const response = await fetch('syncFromApi/products.php');

                // // ตรวจสอบว่าข้อมูลบีบอัดหรือไม่
                // const contentEncoding = response.headers.get('Content-Encoding');
                // const isCompressed = contentEncoding && contentEncoding.includes('gzip');

                // if (isCompressed) {
                //     const compressed = await response.arrayBuffer();
                //     const jsonString = await decompressGzipUniversal(compressed);
                //     return JSON.parse(jsonString);
                // } else {
                //     // กรณีไม่ได้บีบอัด
                //     return await response.json();
                // }
                return await response.json();
            } catch (error) {
                console.error('Failed to fetch and decompress data:', error);
                throw error;
            }
        }
        async function getData() {
            try {
                const response = await fetch('syncFromApi/products.php');

                // // ตรวจสอบว่าข้อมูลบีบอัดหรือไม่
                // const contentEncoding = response.headers.get('Content-Encoding');
                // const isCompressed = contentEncoding && contentEncoding.includes('gzip');

                // if (isCompressed) {
                //     const compressed = await response.arrayBuffer();
                //     const jsonString = await decompressGzipUniversal(compressed);
                //     return JSON.parse(jsonString);
                // } else {
                //     // กรณีไม่ได้บีบอัด
                //     return await response.json();
                // }
                return await response.json();
            } catch (error) {
                console.error('Failed to fetch and decompress data:', error);
                throw error;
            }
        }
        /*
        $(document).ready(async function() {
            // createProgressBar();
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
        */
    </script>

</body>

</html>