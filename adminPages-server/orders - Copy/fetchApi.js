let 
    storeNamesLocal = [
        {
            storeName: "products",
            keyPath: "productId",
        },
        {
            storeName: "customers",
            keyPath: "customerId",
        },
        {
            storeName: "suppliers",
            keyPath: "supplierId",
        },
        {
            storeName: "groupnames",
            keyPath: "groupId",
        },
        {
            storeName: "typenames",
            keyPath: "typeId",
        },
    ];

Date.prototype.addHours = function (h) {
    this.setHours(this.getHours() + h);
    return this;
};

function setDataToLocalVar(storeName, dataStore) {
    if (storeName == "products") {
        products = dataStore;
    } else if (storeName == "groupnames") {
        groupNames = dataStore;
    } else if (storeName == "typenames") {
        typeNames = dataStore;
    } else if (storeName == "suppliers") {
        suppliers = dataStore;
    } else if (storeName == "customers") {
        customers = dataStore;
    }
}

// Fetch data from API
const fetchDataApi = async (endpoint, progressKey) => {
    try {
        // Show initial progress
        document.getElementById(`${progressKey}-progress`).style.width = "0%";

        // const lastSyncTime = await getLastSyncTime(progressKey);
        const lastSyncTime = "empty";
        const response = await fetch(`services/${endpoint}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Authorization: "Bearer my-secret-token",
                "Custom-Header": "HelloWorld",
            },
            body: JSON.stringify({
                lastSyncTime: lastSyncTime,
            }),
        });
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        setDataToLocalVar(endpoint, data);

        // await storeData(progressKey, data);
        // let nowSyncTime = new Date().addHours(7).toISOString().replace("T", " ").substr(0, 19);
        // await saveLastSyncTime(progressKey, nowSyncTime);

        // Complete progress
        document.getElementById(`${progressKey}-progress`).style.width = "100%";

        return data;
    } catch (error) {
        console.error(`Error fetching ${endpoint}:`, error);
        throw error;
    }
};

// Load all data with progress tracking
const loadAllData = async () => {
    $("#progressModal").modal("show");

    try {
        // await openDB();

        let urls = storeNamesLocal.map((store) =>
            fetchDataApi(store.storeName + ".php", store.storeName)
        );
        await Promise.all(urls);

        // Update overall progress to 100%
        document.getElementById("overall-progress").style.width = "100%";

        // Enable close button
        // document.getElementById('closeModalBtn').disabled = false;
        setTimeout(closeModal, 1000);
    } catch (error) {
        console.error("Error loading data:", error);
        alert("Error loading data. Please check console for details.");
        // if (db) await db.close();
        $("#closeModalBtn").removeClass("d-none");
    }
};

async function saveLastSyncTime(tableName, lastSyncTime) {
    const tx = db.transaction(metaStore, "readwrite");
    const meta = tx.objectStore(metaStore);
    let object = {
        tableName: tableName,
        lastSyncTime: lastSyncTime,
    };
    meta.put(object);
}

async function getLastSyncTime(tableName) {
    return "empty";
    // return new Promise((resolve, reject) => {
    //     const req = db.transaction(metaStore).objectStore(metaStore).get(tableName);
    //     // let result = req.result?.lastSyncTime.value;
    //     req.onsuccess = async () => {
    //         if (req.result) {
    //             resolve(req.result.lastSyncTime);
    //         } else {
    //             resolve("empty");
    //         }
    //     };
    //     req.onerror = async () => {
    //         reject("empty");
    //     };
    // });
}

function closeModal() {
    $("#progressModal").modal("hide");
    // window.location.assign("../index.php");
}
/*
        // Initialize the application when DOM is loaded
        document.addEventListener('DOMContentLoaded', async () => {
            loadAllData();
            // Close modal handler
            document.getElementById('closeModalBtn').addEventListener('click', () => {
                $('#closeModalBtn').removeClass("d-none");

            });
        });
        */
