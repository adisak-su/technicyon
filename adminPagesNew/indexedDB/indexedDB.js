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
            storeName: "groupnames",
            keyPath: "groupId",
            // keyPath: "groupname",
        },
        {
            storeName: "typenames",
            keyPath: "typeId",
            // keyPath: "typename",
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

const getDataFromDB = (params,key=null) => {
    return new Promise((resolve, reject) => {
        const transaction = db.transaction([params], 'readonly');
        const store = transaction.objectStore(params);
        /*
        let request = null;
        if(key) {
            request = store.get(key);
        }
        else {
            request = store.getAll();
        }
        */
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

const putDataToDB = (params,data) => {
    return new Promise((resolve, reject) => {
        const transaction = db.transaction([params], 'readwrite');
        const store = transaction.objectStore(params);
        const request = store.put(data);
        
        request.onsuccess = () => {
            resolve(true);
        };
        
        request.onerror = (event) => {
            console.error('Error getting products:', event.target.error);
            reject(event.target.error);
        };
    });
};

const deleteDataFrom = (params,key) => {
    return new Promise((resolve, reject) => {
        const transaction = db.transaction([params], 'readwrite');
        const store = transaction.objectStore(params);
        const request = store.delete(key);
        
        request.onsuccess = () => {
            resolve(true);
        };
        
        request.onerror = (event) => {
            console.error('Error delete key:', event.target.error);
            reject(event.target.error);
        };
    });
};

async function loadDataFromDB(store) {
    try {
        const results = await getDataFromDB(store);
        return results;
    } catch (error) {
        console.error('Error loading products:', error);
    }
}

async function loadDataFromDBByKey(store,key) {
    try {
        const results = await getDataFromDB(store,key);
        return results;
    } catch (error) {
        console.error('Error loading products:', error);
    }
}

async function updateDataToDB(store,data) {
    try {
        const results = await putDataToDB(store,data);
        return results;
    } catch (error) {
        console.error('Error put data:', error);
    }
}

async function deleteDataFromDB(store,key) {
    try {
        const results = await deleteDataFrom(store,key);
        return results;
    } catch (error) {
        console.error('Error delete key:', error);
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
     if(db) {
         db.close();
     }
     
     const request = indexedDB.deleteDatabase(dbName);

     request.onsuccess = function() {
       console.log('Database deleted successfully.');
       alert('Database deleted successfully.');
       window.location.assign("../../login.php");
     };

     request.onerror = function(event) {
       console.error('Error deleting database:', event.target.error);
       alert('Error deleting database:', event.target.error);
     };

     request.onblocked = function() {
       console.log('Deletion blocked; close all other tabs/windows using this database.');
       alert('Deletion blocked; close all other tabs/windows using this database.');
     };

}
