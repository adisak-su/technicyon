const dbVersion = 1;
// const dbName = "TechinicyonLocalDB";
const dbName = "LocalDBTest";
class DBManager {
    constructor(dbName) {
        this.dbName = dbName;
        this.dbVersion = 1;
        this.db = null;
        this.storeNames = [
            {
                storeName: "products",
                keyPath: "productNo",
            },
            {
                storeName: "usercars",
                keyPath: "usercarNo",
            },
            {
                storeName: "customers",
                keyPath: "customerNo",
            },
            {
                storeName: "suppliers",
                keyPath: "supplierNo",
            },
            {
                storeName: "groupnames",
                keyPath: "groupNo",
            },
            {
                storeName: "typenames",
                keyPath: "typeNo",
            },
            {
                storeName: "colornames",
                keyPath: "colorNo",
            },
            {
                storeName: "technicalnames",
                keyPath: "technicalNo",
            },
        ];
        this.metaStore = "meta";
        this.lastSyncTime = "empty";
    }

    async openDB() {
        return new Promise((resolve, reject) => {
            const request = indexedDB.open(this.dbName, this.dbVersion);

            request.onupgradeneeded = (event) => {
                const db = event.target.result;

                // Create store if it doesn't exist
                this.storeNames.forEach((store) => {
                    if (!db.objectStoreNames.contains(store.storeName))
                        db.createObjectStore(store.storeName, {
                            keyPath: store.keyPath,
                        });
                });
                if (!db.objectStoreNames.contains(this.metaStore))
                    db.createObjectStore(this.metaStore, {
                        keyPath: "tableName",
                    });
            };

            request.onsuccess = (event) => {
                this.db = event.target.result;
                resolve(this.db);
            };

            request.onerror = (event) => {
                console.error("IndexedDB open error : ", event.target.error);
                reject(event.target.error);
            };
        });
    }

    async closeDB() {
        if (this.db) {
            this.db.close();
            this.db = null;
        }
    }

    async deleteDB() {
        loaderScreen("show");
        await this.closeDB();
        return new Promise((resolve, reject) => {
            const request = indexedDB.deleteDatabase(this.dbName);
            // request.onsuccess = resolve;
            request.onsuccess = () => {
                window.location.assign("../../login.php");
            };
            request.onerror = reject;
            request.onblocked = () => {
                setTimeout(
                    () => this.deleteDB().then(resolve).catch(reject),
                    500
                );
            };
        });
    }

    // const getLastSyncFromDB = (params, key = null) => {
    async getLastSyncFromDB(params, key = null) {
        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction("meta", "readonly");
            const store = transaction.objectStore("meta");

            const request = store.getAll();
            request.onsuccess = () => {
                resolve(request.result);
            };

            request.onerror = (event) => {
                console.error("Error getLastSyncFromDB : ", event.target.error);
                reject(event.target.error);
            };
        });
    }

    async getDataFromDB(params) {
        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction([params], "readonly");
            const store = transaction.objectStore(params);
            const request = store.getAll();

            request.onsuccess = () => {
                resolve(request.result);
            };

            request.onerror = (event) => {
                console.error("Error getting products:", event.target.error);
                reject(event.target.error);
            };
        });
    }

    async putDataToDB(params, data) {
        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction([params], "readwrite");
            const store = transaction.objectStore(params);
            const request = store.put(data);

            request.onsuccess = () => {
                resolve(true);
            };

            request.onerror = (event) => {
                console.error("Error putDataToDB : ", event.target.error);
                reject(event.target.error);
            };
        });
    }

    async deleteDataFrom(params, key) {
        return new Promise((resolve, reject) => {
            // if (["groupnames", "typenames", "colornames"].includes(params)) {
            //     key = key * 1;
            // }
            key = key * 1;
            const transaction = this.db.transaction([params], "readwrite");
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
    }

    async loadDataFromDB(store, sortColName = "") {
        try {
            const results = await this.getDataFromDB(store);
            if (sortColName !== "") {
                results.sort((a, b) =>
                    a[sortColName].localeCompare(b[sortColName])
                );
            }
            return results;
        } catch (error) {
            console.error("Error loading products:", error);
            throw new Error(error);
        }
    }

    async createDataToDB(store, data) {
        try {
            const results = await this.putDataToDB(store, data);
            return results;
        } catch (error) {
            console.error("Error createDataToDB data:", error);
            throw new Error(error);
        }
    }

    async updateDataToDB(store, data) {
        try {
            const results = await this.putDataToDB(store, data);
            return results;
        } catch (error) {
            console.error("Error updateDataToDB data:", error);
            throw new Error(error);
        }
    }

    async deleteDataFromDB(store, key) {
        try {
            const results = await this.deleteDataFrom(store, key);
            return results;
        } catch (error) {
            console.error("Error deleteDataFromDB key:", error);
            throw new Error(error);
        }
    }

    async _processChangeData(arrayData, tableNames, newSyncTime) {
        try {
            let i = 0;
            for (i = 0; i < arrayData.length; i++) {
                let item = arrayData[i];
                const store = item.table;
                switch (item.type) {
                    case "CREATE":
                        await this.createDataToDB(store, item.data);
                        break;

                    case "UPDATE":
                        await this.updateDataToDB(store, item.data, item.id);
                        break;

                    case "DELETE":
                        await this.deleteDataFromDB(store, item.id);
                        break;
                }
            }
            tableNames.forEach((item) => {
                this.putDataToDB("meta", {
                    tableName: item,
                    lastSyncTime: newSyncTime,
                });
            });
        } catch (error) {
            console.error("Error deleteDataFromDB key:", error);
            throw new Error(error);
        }
    }

    async updateStoreTransaction(storeName, datas) {
        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction([storeName], "readwrite");
            const store = transaction.objectStore(storeName);
            let request = null;
            datas.forEach((item) => {
                switch (item.type) {
                    case "CREATE":
                        request = store.put(item.data);
                        break;

                    case "UPDATE":
                        request = store.put(item.data);
                        break;

                    case "DELETE":
                        request = store.delete(item.id);
                        break;
                }
            });
            request.onsuccess = () => {
                resolve(true);
            };

            request.onerror = (event) => {
                console.error("Error putDataToDB : ", event.target.error);
                reject(event.target.error);
            };
        });
    }

    async processChangeData(arrayData = [], tableNames = [], newSyncTime) {
        try {
            let i = 0;
            let arrDataTable = [];
            tableNames.forEach((store) => {
                arrDataTable.push({
                    storeName: store,
                    datas: arrayData.filter((item) => item.table === store),
                });
            });
            console.table(arrDataTable);
            arrDataTable.forEach((item) => {
                this.updateStoreTransaction(item.storeName, item.datas);
            })
            // for (i = 0; i < arrayData.length; i++) {
            //     let item = arrayData[i];
            //     const store = item.table;
            //     switch (item.type) {
            //         case "CREATE":
            //             await this.createDataToDB(store, item.data);
            //             break;

            //         case "UPDATE":
            //             await this.updateDataToDB(store, item.data, item.id);
            //             break;

            //         case "DELETE":
            //             await this.deleteDataFromDB(store, item.id);
            //             break;
            //     }
            // }
            tableNames.forEach((item) => {
                this.putDataToDB("meta", {
                    tableName: item,
                    lastSyncTime: newSyncTime,
                });
            });
        } catch (error) {
            console.error("Error deleteDataFromDB key:", error);
            throw new Error(error);
        }
    }
}

const dbManager = new DBManager(dbName);

let itemTimeSync = getStorage("itemTimeSync");
let timeSync = 10000; // 10 วินาที
if (itemTimeSync) {
    timeSync = itemTimeSync.itemTimeSync * 1000;
}

async function getDataLastSync(lastSyncRecord) {
    return new Promise(function (resolve, reject) {
        $.ajax({
            url: "../js/syncData.php",
            type: "POST",
            dataType: "json",
            data: {
                lastSyncRecord: lastSyncRecord,
            },
            beforeSend: function () {},
            success: function (data) {
                resolve(data);
            },
            error: function (err) {
                // sweetAlertError("เกิดข้อผิดพลาด : " + err.responseText, 0);
                reject(err);
            },
        });
    });
}

async function syncOnLoad() {
    try {
        let newSyncTime = getDateTimeNow();
        console.log("start Sync time : " + getDateTimeNow());

        await dbManager.openDB();
        // 1. ดึงเวลาซิงค์ล่าสุดจาก IndexedDB
        const lastSyncRecord = await dbManager.getLastSyncFromDB();

        // 2. ดึงการเปลี่ยนแปลงจากเซิร์ฟเวอร์
        let changes = await getDataLastSync(lastSyncRecord);

        if (!changes || changes.length === 0) return { status: false };

        console.log("start indexDB time : " + getDateTimeNow());
        const tableNames = [...new Set(changes.map((item) => item.table))];

        // 3. ประมวลผลการเปลี่ยนแปลง
        await dbManager.processChangeData(changes, tableNames, newSyncTime);

        // for (i = 0; i < changes.length; i++) {
        //     item = changes[i];
        //     const store = item.table;
        //     switch (item.type) {
        //         case "CREATE":
        //             await createDataToDB(store, item.data);
        //             break;

        //         case "UPDATE":
        //             await updateDataToDB(store, item.data, item.id);
        //             break;

        //         case "DELETE":
        //             await deleteDataFromDB(store, item.id);
        //             break;
        //     }
        // }

        // tableNames.forEach((item) => {
        //     putDataToDB("meta", {
        //         tableName: item,
        //         lastSyncTime: newSyncTime,
        //     });
        // });
        console.log("stop indexDB time : " + getDateTimeNow());
        return { status: true, tableNames: tableNames };
    } catch (error) {
        console.error("Sync failed:", error);
        throw new Error(error);
        // throw new Error("Parameter is not a number!");
    }
}

async function updateSyncData() {
    try {
        let statusChange = await syncOnLoad();
        if (statusChange.status) {
            return statusChange.tableNames;
        }
        return null;
    } catch (error) {
        console.error("Sync failed:", error);
        return null;
        throw new Error(error);
        // throw new Error("Parameter is not a number!");
    }
}

async function loadDataFromDB(store, sortColName = "") {
    try {
        const results = await dbManager.getDataFromDB(store);
        if (sortColName !== "") {
            results.sort((a, b) =>
                a[sortColName].localeCompare(b[sortColName])
            );
        }
        return results;
    } catch (error) {
        console.error("Error loading products:", error);
        throw new Error(error);
    }
}

async function deleteIndexedDB(element) {
    Swal.fire({
        html: "คุณแน่ใจหรือไม่...ที่จะลบข้อมูลที่เก็บในเครื่อง?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#8a8a8a",
        confirmButtonText: "ใช่! ลบเลย",
        cancelButtonText: "ไม่! ยกเลิก",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            element.classList.add("d-none");
            dbManager.deleteDB();
        }
    });
}
