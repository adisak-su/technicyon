let localTableStatus = [];
let listProducts = [];
let listCustomers = [];
let db;

initDB();

async function initDB() {
    /*
              db = await idb.openDb('booksDb', 1, db => {
                db.createObjectStore('books', {keyPath: 'name'});
              });
            */
    db = await idb.openDb("TechnicyonDB", 1, (db) => {
        db.createObjectStore("product", {
            keyPath: "productid",
        });
        db.createObjectStore("customer", {
            keyPath: "customerid",
        });
        db.createObjectStore("usercar", {
            keyPath: "idcar",
        });
        db.createObjectStore("groupname", {
            keyPath: "groupname",
        });
        db.createObjectStore("typename", {
            keyPath: "typename",
        });
    });

    // await list();
}

async function searchDataInDB(params, productid) {
    let tx = db.transaction(params);
    let productStore = tx.objectStore(params);
    let result = await productStore.get(productid);
    return result;
}

async function searchProducts(productID, productName) {
    let products = listProducts.filter(
        (item) =>
            item.productid.includes(productID) ||
            item.name.includes(productName)
    );
    if (products) {
        alert(JSON.stringify(products));
    }
}

async function readDataFromDB(params) {
    let tx = db.transaction(params);
    let dataStore = tx.objectStore(params);
    return await dataStore.getAll();
}

async function clearBooks() {
    let tx = db.transaction("products", "readwrite");
    await tx.objectStore("products").clear();
    // await list();
}

async function saveProductsToDB(products) {
    let tx = db.transaction("products", "readwrite");
    await tx.objectStore("products").clear();
    products.forEach((item) => {
        try {
            tx.objectStore("products").add(item);
        } catch (err) {
            if (err.productid == "ConstraintError") {
                alert("Such product exists already");
                // await addProduct();
            } else {
                throw err;
            }
        }
    });
}

async function _saveDataToDB2(params, items) {
    let tx = db.transaction(params, "readwrite");
    // await tx.objectStore(params).clear();
    try {
        items.forEach((item) => {
            tx.objectStore(params).add(item);
        });
    } catch (err) {
        alert(err.message());
    }
}

async function saveDataToDB2(params, items) {
    let tx = db.transaction(params, "readwrite");
    items.forEach((item) => {
        try {
            tx.objectStore(params).add(item);
        } catch (err) {
            alert(err.message());
            // return;
            throw err;
            // if (err.productid == "ConstraintError") {
            //     alert("Such product exists already");
            //     // await addProduct();
            // } else {
            //     throw err;
            // }
        }
    });
}

async function saveDataToDB(params, items) {
    let tx = db.transaction(params, "readwrite");
    await tx.objectStore(params).clear();

    items.forEach((item) => {
        try {
            tx.objectStore(params).add(item);
        } catch (err) {
            alert(err.message());
            // return;
            throw err;
            // if (err.productid == "ConstraintError") {
            //     alert("Such product exists already");
            //     // await addProduct();
            // } else {
            //     throw err;
            // }
        }
    });
}

async function startCheckDataExpired() {
    let result = await getTableStatus();
}

function checkExpired(element) {
    if (localTableStatus) {
        // console.log(localTableStatus);
        let insertTime = findInsertTime(localTableStatus, element.tableName);
        let updateTime = findUpdateTime(localTableStatus, element.tableName);
        // alert(insertTime + " : " + element.insertTime)
        if (
            insertTime != element.insertTime ||
            updateTime != element.updateTime
        ) {
            return true;
        }
        return false;
    } else {
        return true;
    }
}

function findInsertTime(tableStatus, tableName) {
    let index = tableStatus.findIndex(
        (element) => element.tableName === tableName
    );
    if (index != -1) {
        return tableStatus[index].insertTime;
    }
    return "";
}

function findUpdateTime(tableStatus, tableName) {
    let index = tableStatus.findIndex(
        (element) => element.tableName === tableName
    );
    if (index != -1) {
        return tableStatus[index].updateTime;
    }
    return "";
}

async function getTableStatus() {
    localTableStatus = getStorage("tableStatus");
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url: "service/readTableStatus.php",
        })
            .done(function (resp) {
                let tableNameExpire = [];
                let urls = [];
                result = JSON.parse(resp.message);
                versionConfigServerData = resp.versionData;
                versionStatusConfigServerData = resp.statusData;

                if (result) {
                    setStorage("tableStatus", result);
                    let lastIndex = result.length - 1;
                    result.forEach((element, index) => {
                        tableName = element.tableName;
                        //alert(tableName);
                        let expired = checkExpired(element);
                        if (expired) {
                            // tableNameExpire.push(tableName);
                            // urls.push(
                            //     "service/readTable.php?status=1&tableName=" + tableName
                            // );
                            switch (tableName) {
                                case "groupname":
                                    tableNameExpire.push(tableName);
                                    urls.push("service/getGroupName.php");
                                    break;
                                case "typename":
                                    tableNameExpire.push(tableName);
                                    urls.push("service/getTypeName.php");
                                    break;
                                case "usercar":
                                    tableNameExpire.push(tableName);
                                    urls.push("service/getUserCar.php");
                                    break;
                                case "usercar":
                                    tableNameExpire.push(tableName);
                                    urls.push("service/getUserCar.php");
                                    break;
                                case "product":
                                    tableNameExpire.push(tableName);
                                    urls.push("service/getProduct.php");
                                    // tableNameExpire.push(tableName + "1");
                                    // urls.push("service/getProduct.php");
                                    // tableNameExpire.push(tableName + "2");
                                    // urls.push("service/getProduct2.php");
                                    break;
                            }
                            // if (tableName === "usercar") {
                            //     tableNameExpire.push(tableName);
                            //     urls.push("service/getUserCar.php");
                            // } else if (tableName === "product") {
                            //     tableNameExpire.push(tableName);
                            //     urls.push("service/getProduct.php");
                            // }
                            // else if (
                            //     !(
                            //         tableName == "sales" ||
                            //         tableName == "test_sales"
                            //     )
                            // ) {
                            //     tableNameExpire.push(tableName);
                            //     urls.push(
                            //         "service/readTable.php?status=1&tableName=" +
                            //             tableName
                            //     );
                            // }
                        }
                    });
                    if (tableNameExpire) {
                        const fetchNames = async () => {
                            try {
                                var arrayFetch = urls.map(function (url) {
                                    return fetch(url);
                                });
                                const requests = await Promise.all(arrayFetch);

                                const results = await Promise.all(
                                    requests.map((r) => r.json())
                                );
                                tableNameExpire.forEach((tableName, index) => {
                                    let resultItems = results[index].message;
                                    // switch (tableName) {
                                    //     case "usercar":
                                    //         saveDataToDB(
                                    //             tableName,
                                    //             resultItems
                                    //         );
                                    //         break;
                                    //     case "product1":
                                    //         saveDataToDB(
                                    //             tableName,
                                    //             resultItems
                                    //         );
                                    //         break;
                                    //     case "product2":
                                    //         saveDataToDB2(
                                    //             tableName,
                                    //             resultItems
                                    //         );
                                    //         break;
                                    // }
                                    saveDataToDB(tableName, resultItems);
                                    // if(tableName == "product") {
                                    //     listProducts = resultItems;
                                    // }
                                    // else if(tableName == "customer") {
                                    //     listCustomers = resultItems;
                                    // }

                                    // saveProductsToDB(
                                    //     JSON.parse(results[index].message)
                                    // );
                                    // setStorage(
                                    //     tableName,
                                    //     JSON.parse(results[index].message)
                                    // );
                                });
                                return true;
                            } catch (err) {
                                console.log(err);
                                return false;
                            }
                        };
                        resolve(fetchNames());
                    } else {
                        resolve(true);
                    }
                }
            })
            .fail(function (error) {
                alert("Error get : " + JSON.stringify(error));
                reject(false);
            });
    });
}
