const dbVersion = 1;

const dbName = "LocalDBTest",
    storeNames = [
        {
            storeName: "products",
            keyPath: "productId",
        },
        {
            storeName: "usercars",
            keyPath: "carId",
        },
        {
            storeName: "customers",
            keyPath: "customerId",
        },
        {
                storeName: "suppliers",
                keyPath: "supplierId"
        },
        {
            storeName: "groupnames",
            keyPath: "groupId",
        },
        {
            storeName: "typenames",
            keyPath: "typeId",
        },
        {
            storeName: "colornames",
            keyPath: "colorId",
        },
    ];
metaStore = "meta";
let lastSyncTime = "empty";

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
        if(["groupnames","typenames","colornames"].includes(params)) {
            key = key*1;
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

async function loadDataFromDB(store) {
    try {
        const results = await getDataFromDB(store);
        return results;
    } catch (error) {
        console.error("Error loading products:", error);
    }
}

async function loadDataFromDBByKey(store, key) {
    try {
        const results = await getDataFromDB(store, key);
        return results;
    } catch (error) {
        console.error("Error loading products:", error);
    }
}

async function updateDataToDB(store, data) {
    try {
        const results = await putDataToDB(store, data);
        return results;
    } catch (error) {
        console.error("Error put data:", error);
    }
}

async function deleteDataFromDB(store, key) {
    try {
        const results = await deleteDataFrom(store, key);
        return results;
    } catch (error) {
        console.error("Error delete key:", error);
    }
}

/*
function getData() {
  // open a read/write db transaction, ready for retrieving the data
  const transaction = db.transaction(["toDoList"], "readwrite");

  // report on the success of the transaction completing, when everything is done
  transaction.oncomplete = (event) => {
    note.appendChild(document.createElement("li")).textContent =
      "Transaction completed.";
  };

  transaction.onerror = (event) => {
    note.appendChild(document.createElement("li")).textContent =
      `Transaction not opened due to error: ${transaction.error}`;
  };

  // create an object store on the transaction
  const objectStore = transaction.objectStore("toDoList");

  // Make a request to get a record by key from the object store
  const objectStoreRequest = objectStore.get("Walk dog");

  objectStoreRequest.onsuccess = (event) => {
    // report the success of our request
    note.appendChild(document.createElement("li")).textContent =
      "Request successful.";

    const myRecord = objectStoreRequest.result;
  };
}
*/

async function deleteIndexedDB() {
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
        await openDB();
        // 1. ดึงเวลาซิงค์ล่าสุดจาก IndexedDB
        const lastSyncRecord = await getLastSyncFromDB();

        // 2. ดึงการเปลี่ยนแปลงจากเซิร์ฟเวอร์
        let changes = await getDataLastSync(lastSyncRecord);

        if (!changes || changes.length === 0) return {status:false};
        // let tableNames = changes.map(item=>item.table_name);
        const tableNames = [...new Set(changes.map(item => item.table))];

        // 3. ประมวลผลการเปลี่ยนแปลง
        for (i = 0; i < changes.length; i++) {
            item = changes[i];
            const store = item.table;
            switch (item.type) {
                case "CREATE":
                case "UPDATE":
                    await updateDataToDB(store, item.data);
                    break;

                case "DELETE":
                    await deleteDataFromDB(store, item.id);
                    break;
            }
        }

        // 4. อัปเดตเวลาซิงค์ล่าสุด
        // let newSyncTime = new Date()
        //     .addHours(7)
        //     .toISOString()
        //     .replace("T", " ")
        //     .substr(0, 19);
        let newSyncTime = getDateTimeNow();

        for (i = 0; i < changes.length; i++) {
            item = changes[i];
            let store = item.table;
            updateDataToDB("meta", {
                tableName: store,
                lastSyncTime: newSyncTime,
            });
        }

        // updateDataToDB("meta", {
        //     tableName: "suppliers",
        //     lastSyncTime: newSyncTime,
        // });
        return {status:true,tableNames:tableNames};
    } catch (error) {
        console.error("Sync failed:", error);
        throw new Error(error);
        // throw new Error("Parameter is not a number!");
    }
}

async function _loadAndSetDataFromDB({ dataSource, inputId, suggestionsId }) {
    let dataStore = await loadDataFromDB(dataSource);
    // groupNames = dataStore;
    setupAutocompleteOnFocus({
        inputId: inputId,
        suggestionsId: suggestionsId, //"groupNameSuggestions",
        dataList: dataStore,
        codeId: "groupname",
        arrayShowValue: ["groupname"],
        arrayFindValue: ["groupname"],
        // callbackFunction: changeFilter,
        //sortField: "groupname"
    });
    return dataStore;
}

async function _loadAndSetDataFromDB({ dataSource, inputId, suggestionsId }) {
    let dataStore = await loadDataFromDB(dataSource);
    // groupNames = dataStore;
    setupAutocompleteOnFocus({
        inputId: inputId,
        suggestionsId: suggestionsId, //"groupNameSuggestions",
        dataList: dataStore,
        codeId: "groupname",
        arrayShowValue: ["groupname"],
        arrayFindValue: ["groupname"],
        // callbackFunction: changeFilter,
        //sortField: "groupname"
    });
    return dataStore;
}

async function _loadAndSetDataColor(inputId, suggestionsId) {
    let dataStore = await getColor();
    setupAutocompleteOnFocus({
        inputId: inputId,
        suggestionsId: suggestionsId, //"colorSuggestions",
        dataList: dataStore,
        codeId: "colorname",
        arrayShowValue: ["colorname"],
        arrayFindValue: ["colorname"],
        // callbackFunction: changeFilter,
        //sortField: "groupname"
    });
    return dataStore;
}

async function updateSyncData({dataName}) {
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
