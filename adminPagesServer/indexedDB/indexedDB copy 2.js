const dbVersion = 1;

const dbName = "LocalDBTest",
    storeNames = [
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
    ];
metaStore = "meta";
let lastSyncTime = "empty";

let itemTimeSync = getStorage("itemTimeSync");
let timeSync = 10000; // 10 วินาที
if (itemTimeSync) {
    timeSync = itemTimeSync.itemTimeSync * 1000;
}

let db;
const openDB = () => {
    return new Promise((resolve, reject) => {
        const request = indexedDB.open(dbName, dbVersion);

        request.onupgradeneeded = (event) => {
            const db = event.target.result;

            // Create store if it doesn't exist
            storeNames.forEach((store) => {
                if (!db.objectStoreNames.contains(store.storeName))
                    db.createObjectStore(store.storeName, {
                        keyPath: store.keyPath,
                    });
            });
            if (!db.objectStoreNames.contains(metaStore))
                db.createObjectStore(metaStore, {
                    keyPath: "tableName",
                });
        };

        request.onsuccess = (event) => {
            db = event.target.result;
            resolve(db);
        };

        request.onerror = (event) => {
            console.error("IndexedDB error:", event.target.error);
            reject(event.target.error);
        };
    });
};

// const loadProducts = async () => {
//     try {
//         const products = await getProducts();
//     } catch (error) {
//         console.error('Error loading products:', error);
//     }
// };

// const getProducts = () => {
//     return new Promise((resolve, reject) => {
//         const transaction = db.transaction(['products'], 'readonly');
//         const store = transaction.objectStore('products');
//         const request = store.getAll();

//         request.onsuccess = () => {
//             resolve(request.result);
//         };

//         request.onerror = (event) => {
//             console.error('Error getting products:', event.target.error);
//             reject(event.target.error);
//         };
//     });
// };

const getLastSyncFromDB = (params, key = null) => {
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

const getDataFromDB = (params, key = null) => {
    return new Promise((resolve, reject) => {
        const transaction = db.transaction([params], "readonly");
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
};

/*
const getDataFromDBBYKey = (params) => {
    return new Promise((resolve, reject) => {
        const transaction = db.transaction([params], 'readonly');
        const store = transaction.objectStore(params);
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
*/

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
        // if (["groupnames", "typenames", "colornames"].includes(params)) {
        //     key = key * 1;
        // }
        key = key * 1;
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

const updateCursorDB = (params, value, key) => {
    return new Promise((resolve, reject) => {
        if (["groupnames", "typenames", "colornames"].includes(params)) {
            key = key * 1;
        }
        const transaction = db.transaction([params], "readwrite");
        const objectStore = transaction.objectStore(params);

        var cursorRequest = objectStore.openCursor(key); //Correctly define result as request

        cursorRequest.onsuccess = function (e) {
            //Correctly set onsuccess for request
            var objCursor = cursorRequest.result; //Get cursor from request
            var obj = objCursor.value; //Get value from existing cursor ref
            console.log(obj);
            var request = objCursor.update(value);
            request.onsuccess = () => {
                resolve(true);
            };

            request.onerror = (event) => {
                console.error("Error delete key:", event.target.error);
                reject(event.target.error);
            };
        };
        cursorRequest.onerror = (event) => {
            //Correctly set onerror for request
            console.log("DBM.activitati.edit -> error " + event); //Use "console" to log :)
            reject(event.target.error);
        };
    });
};

async function loadDataFromDB(store, sortColName = "") {
    try {
        const results = await getDataFromDB(store);
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

async function loadDataFromDBByKey(store, key) {
    try {
        const results = await getDataFromDB(store, key);
        return results;
    } catch (error) {
        console.error("Error loading products:", error);
        throw new Error(error);
    }
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
        // if (key) {
        //     await deleteDataFromDB(store, key);
        // }
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

async function deleteIndexedDB() {
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
            // const dbName = 'myDatabase';
            if (db) {
                db.close();
            }

            const request = indexedDB.deleteDatabase(dbName);

            request.onsuccess = function () {
                console.log("Database deleted successfully.");
                alert("Database deleted successfully.");
                window.location.assign("../../login.php");
            };

            request.onerror = function (event) {
                console.error("Error deleting database:", event.target.error);
                alert("Error deleting database:", event.target.error);
                throw new Error(error);
            };

            request.onblocked = function () {
                console.log(
                    "Deletion blocked; close all other tabs/windows using this database."
                );
                alert(
                    "Deletion blocked; close all other tabs/windows using this database."
                );
            };
        }
    });
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

function getDateTimeNow() {
    return new Date().addHours(7).toISOString().replace("T", " ").substr(0, 19);
}

//  update data from server to indexeddb
async function syncOnLoad() {
    try {
        let newSyncTime = getDateTimeNow();

        await openDB();
        // 1. ดึงเวลาซิงค์ล่าสุดจาก IndexedDB
        const lastSyncRecord = await getLastSyncFromDB();

        // 2. ดึงการเปลี่ยนแปลงจากเซิร์ฟเวอร์
        let changes = await getDataLastSync(lastSyncRecord);

        if (!changes || changes.length === 0) return { status: false };

        const tableNames = [...new Set(changes.map((item) => item.table))];

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
        }

        tableNames.forEach((item) => {
            putDataToDB("meta", {
                tableName: item,
                lastSyncTime: newSyncTime,
            });
        });

        return { status: true, tableNames: tableNames };
    } catch (error) {
        console.error("Sync failed:", error);
        throw new Error(error);
        // throw new Error("Parameter is not a number!");
    }
}

async function updateSyncData() {
    let statusChange = await syncOnLoad();
    if (statusChange.status) {
        return statusChange.tableNames;
    }
    return null;
}
async function _updateSyncData({ dataName }) {
    let statusChange = await syncOnLoad();
    if (statusChange.status) {
        if (statusChange.tableNames.find((item) => item == dataName)) {
            let dataSource = await loadDataFromDB(dataName);
            return dataSource;
            // createFilterDataAndRender();
        }
        return null;
    }
}
