<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ระบบจัดการสินค้า (Offline-First)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container text-center my-5">
        <div id="statusBar" class="bg-secondary text-white py-2 text-center position-relative">
            <span id="statusIcon">🔄</span> <span id="statusText">กำลังโหลดข้อมูล...</span>
            <!-- <div class="progress position-absolute bottom-0 start-0 w-100" style="width: 80vw;height: 4px;">
            <div id="syncProgressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
        </div>
        <div id="syncMessage" class="small text-white mt-1"></div> -->
            <div id="progressIndexedDB"></div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/idb@3.0.2/build/idb.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const dbName = "LocalDBTest",
            storeNames = [{
                storeName: "products",
                keyPath: "productid"
            }, {
                storeName: "usercars",
                keyPath: "idcar"
            }, {
                storeName: "customers",
                keyPath: "customerid"
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

        let allProducts = [],
            currentPage = 1,
            pageSize = 5;


        function openIndexedDB() {
            return new Promise((resolve, reject) => {
                const req = indexedDB.open(dbName, 1);
                req.onupgradeneeded = e => {
                    const db = e.target.result;
                    storeNames.forEach((store) => {
                        if (!db.objectStoreNames.contains(store.storeName)) db.createObjectStore(store.storeName, {
                            keyPath: store.keyPath
                        });
                    });
                    // if (!db.objectStoreNames.contains(storeName)) db.createObjectStore(storeName, {
                    //     keyPath: "id"
                    // });
                    if (!db.objectStoreNames.contains(metaStore)) db.createObjectStore(metaStore, {
                        keyPath: "key"
                    });
                };
                req.onsuccess = e => resolve(e.target.result);
                req.onerror = e => reject(e.target.error);
            });
        }
        async function syncStoreFromAPI(storeName) {
            const start = Date.now();
            let html = `<div id="syncName_${storeName}">
                        <div class="text-white mt-1">ข้อมูล : ${storeName}</div>
                        <span id="statusIcon">🔄</span> <span id="statusText_${storeName}">กำลังโหลดข้อมูล...</span>
                        <div class="progress start-0 w-100" style="width: 80vw;height: 8px;">
                            <div id="syncProgressBar_${storeName}" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div id="syncMessage_${storeName}" class="small text-white mt-1"></div>
                        </div>`;
            $("#progressIndexedDB").html($("#progressIndexedDB").html() + html);
            // const res = await fetch(`syncFromApi/${storeName}.php`);
            let lastSyncTime = await getLastSyncTime();
            const res = await fetch(`syncFromApi/${storeName}.php`, {
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
            const products = await res.json();

            const tx = db.transaction([storeName, metaStore], "readwrite");
            const store = tx.objectStore(storeName);

            let count = 0;
            for (const p of products) {
                store.put(p);
                count++;
                const percent = 5 + (count / products.length) * 60;
                setSyncProgress("syncProgressBar_" + storeName, "syncMessage_" + storeName, percent, `โหลด ${count}/${products.length} รายการ | ${estimateTime(start)}`, "bg-info");
            }
            tx.oncomplete = () => {
                setSyncProgress("syncProgressBar_" + storeName, "statusText_" + storeName, 100, "โหลดข้อมูลเสร็จ", "bg-info");
                $("#statusText_" + storeName).html("โหลดข้อมูลเสร็จ");
            };
        }
        async function syncFromAPI() {
            if (!navigator.onLine) return;
            try {
                setSyncProgress("syncProgressBar", "syncMessage", 5, "เริ่มโหลดข้อมูลจากเซิร์ฟเวอร์...", "bg-info");
                db = await openIndexedDB();

                lastSyncTime = getLastSyncTime();

                await storeNames.forEach((store) => {
                    storeName = store.storeName;
                    syncStoreFromAPI(storeName);
                });

                const tx = db.transaction(metaStore, "readwrite");
                const meta = tx.objectStore(metaStore);
                // const now = convertTZ(new Date(), "Asia/Jakarta") // current date-time in jakarta.
                // const now = new Date().toLocaleString();
                // const now = new Date().toISOString();
                const now =  new Date().addHours(7).toISOString();
                // new Date().addHours(7)
                alert(now);

                await saveLastSyncTime(now);
                // meta.put({
                //     key: "lastSyncTime",
                //     value: now
                // });
                // meta.put({
                //     key: "lastApiSyncTime",
                //     value: now
                // });
                // tx.oncomplete = () => {
                //     // setSyncProgress("syncProgressBar", "syncMessage", 70, "โหลดข้อมูลเสร็จ", "bg-info");
                //     // setTimeout(() => setSyncProgress("syncProgressBar", "syncMessage", 0, ""), 800);
                // };

            } catch (err) {
                await saveLastSyncTime(lastSyncTime);
                alert(err);
                console.error("API Sync Error:", err);
                setSyncProgress("syncProgressBar", "syncMessage", 100, "โหลดข้อมูลล้มเหลว", "bg-danger");
            }
        }

        Date.prototype.addHours = function(h) {
            this.setHours(this.getHours() + h);
            return this;
        }
        // alert(new Date().addHours(7));

        function convertTZ(date, tzString) {
            return new Date((typeof date === "string" ? new Date(date) : date).toLocaleString("en-US", {
                timeZone: tzString
            }));
        }

        async function saveLastSyncTime(lastSyncTime) {
            const tx = db.transaction(metaStore, "readwrite");
            const meta = tx.objectStore(metaStore);
            const now = new Date().toISOString();
            // convertTZ(date, "Asia/Jakarta") // current date-time in jakarta.

            // d.toLocaleString('en-US', { timeZone: 'America/New_York' })
            meta.put({
                key: "lastSyncTime",
                value: lastSyncTime
            });
            meta.put({
                key: "lastApiSyncTime",
                value: lastSyncTime
            });
        }



        function setSyncProgress(syncProgressBar, syncMessage, percent, message = "", color = "bg-info") {
            try {
                const bar = document.getElementById(syncProgressBar);
                const msg = document.getElementById(syncMessage);
                bar.className = `progress-bar ${color}`;
                bar.style.width = percent + "%";
                msg.innerText = message;
            } catch (err) {
                // console.log(syncProgressBar);
                console.error(syncProgressBar);
                // alert(syncProgressBar);
            }
        }

        function estimateTime(startTime) {
            const elapsed = (Date.now() - startTime) / 1000;
            return `${elapsed.toFixed(1)} วินาที`;
        }

        async function getLastSyncTime() {
            return new Promise((resolve, reject) => {
                const req = db.transaction(metaStore).objectStore(metaStore).get("lastSyncTime");

                req.onsuccess = e => resolve(req.result?.value);
                req.onerror = e => reject("empty");
            });
            // const db = await openIndexedDB();
            // const req = await db.transaction(metaStore).objectStore(metaStore).get("lastSyncTime");
            // const val = req.result?.value;
            // return val ? val : "empty";
            // return await req.onsuccess = async () => {
            //     const val = req.result?.value;
            //     return val ? val : "empty";
            // };

            // req.onsuccess = () => {
            //     const val = req.result?.value;
            //     return val ? val : "empty";
            //     // document.getElementById("lastSyncTime").innerText = val ? `ซิงค์ล่าสุด: ${new Date(val).toLocaleString()}` : "ยังไม่เคยซิงค์ข้อมูล";
            // };
        }

        async function loadProducts(storeName) {
            // const db = await openIndexedDB();
            const tx = db.transaction(storeName, "readonly");
            const req = tx.objectStore(storeName).getAll();
            req.onsuccess = () => {
                allProducts = req.result;
                return allProducts;
                // filterAndRender();
            };
        }

        window.onload = () => {
            // updateOnlineStatus();
            syncFromAPI();
            // displayLastSyncTime();

            // setInterval(() => {
            //     updateOnlineStatus();
            //     syncFromAPI();
            //     syncPending();
            // }, 60000);
        };
    </script>
</body>

</html>