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
            keyPath: "groupname",
        },
        {
            storeName: "typenames",
            keyPath: "typename",
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

const getDataFromDB = (params) => {
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

async function loadDataFromDB(params) {
    try {
        const results = await getDataFromDB(params);
        return results;
    } catch (error) {
        console.error('Error loading products:', error);
    }
}
