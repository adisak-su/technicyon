let localTableStatus = [];
// let localTableStatus = getStorage("tableStatus");

async function loadDataFromServer(dataSource = []) {
    
}

async function startCheckDataExpired(dataSource = [], lastDataSyncTime) {
    let result = await getTableStatus();
    if (result) {
        setStorage("tableStatus", result);
        return await checkExpired(dataSource, result, lastDataSyncTime);
    }
    return [];
}

async function checkExpired(dataSource, tableStatus, lastDataSyncTime) {
    let tableExpires = [];
    dataSource.forEach((item) => {
        if (tableStatus) {
            // console.log(localTableStatus);
            // let insertTime = findInsertTime(tableStatus, item.tableName, lastDataSyncTime);
            // let updateTime = findUpdateTime(tableStatus, item.tableName, lastDataSyncTime);
            // let expiredStatus = findUpdateTime(tableStatus, item.tableName, lastDataSyncTime);
            let expiredStatus = tableStatus.findIndex(
                (element) => element.tableName === item && (element.insertTime <= lastDataSyncTime || element.updateTime <= lastDataSyncTime) 
            );
            if(expiredStatus) {
                tableExpires.push(element);
            }
            // alert(insertTime + " : " + element.insertTime)
            // if (insertTime || updateTime) {
            //     if (
            //         insertTime != element.insertTime ||
            //         updateTime != element.updateTime
            //     ) {
            //         return true;
            //     }
            // }
        //     return false;
        // } else {
        //     return true;
        }
        
    });
    return tableExpires
}

function _checkExpired(element) {
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

function findInsertTime(tableStatus, tableName, lastDataSyncTime) {
    let index = tableStatus.findIndex(
        (element) => element.tableName === tableName
    );
    if (index != -1) {
        return tableStatus[index].insertTime;
    }
    return null;
}

function findUpdateTime(tableStatus, tableName, lastDataSyncTime) {
    let index = tableStatus.findIndex(
        (element) => element.tableName === tableName
    );
    if (index != -1) {
        return tableStatus[index].updateTime;
    }
    return null;
}

async function getTableStatus() {
    // localTableStatus = getStorage("tableStatus");
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url: "../serviceDB/readTableStatus.php",
        })
            .done(function (resp) {
                let tableNameExpire = [];
                let urls = [];
                result = resp.message;

                if (result) {
                    setStorage("tableStatus", result);
                    resolve(result);
                } else {
                    resolve(null);
                }
            })
            .fail(function (error) {
                alert("Error get : " + JSON.stringify(error));
                reject(null);
            });
    });
}

async function _getTableStatus() {
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
                        let expired = checkExpired(element);
                        if (expired) {
                            if (tableName === "autowords") {
                                tableNameExpire.push(tableName);
                                urls.push("service/getAutoWord.php");
                            } else if (
                                !(
                                    tableName == "sales" ||
                                    tableName == "test_sales"
                                )
                            ) {
                                tableNameExpire.push(tableName);
                                urls.push(
                                    "service/readTable.php?status=1&tableName=" +
                                        tableName
                                );
                            }
                        }
                    });
                    if (tableNameExpire) {
                        const fetchNames = async () => {
                            try {
                                // var arrayFetch = urls.map(function (url) {
                                //     return fetch(url);
                                // });
                                // const requests = await Promise.all(arrayFetch);

                                // const results = await Promise.all(
                                //     requests.map((r) => r.json())
                                // );
                                // tableNameExpire.forEach((tableName, index) => {
                                //     setStorage(
                                //         tableName,
                                //         JSON.parse(results[index].message)
                                //     );
                                // });
                                return true;
                            } catch {
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
