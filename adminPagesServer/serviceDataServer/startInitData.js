let lastDataSyncTime = getDateTimeNow();

let itemTimeSync = getStorage("itemTimeSync");
let timeSync = 10000; // 10 วินาที
if (itemTimeSync) {
    timeSync = itemTimeSync.itemTimeSync * 1000;
}

async function loadDataFromServer(dataSource, lastSyncTime = "empty") {
    let nowDataSyncTime = getDateTimeNow();
    let statusType = "";
    if (lastSyncTime == "empty") {
        statusType = "updateExpire";
    }
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            url: `../serviceDataServer/${dataSource}s.php`,
            data: { lastSyncTime: lastSyncTime, statusType: statusType },
        })
            .done(function (resp) {
                if (resp.status) {
                    result = resp.message;
                    lastDataSyncTime = nowDataSyncTime;
                    resolve(result);
                }
                resolve(null);
            })
            .fail(function (error) {
                alert("Error get : " + JSON.stringify(error));
                reject(null);
            });
    });
}

async function updateSyncData(dataSource = []) {
    let result = await getTableStatus();
    if (result) {
        return await checkExpired(dataSource, result);
    }
    return [];
}

async function getTableStatus() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url: "../serviceDataServer/readTableStatus.php",
        })
            .done(function (resp) {
                result = resp.message;
                if (result) {
                    resolve(result);
                } else {
                    resolve(null);
                }
            })
            .fail(function (error) {
                // alert("Error get : " + JSON.stringify(error));
                reject(null);
            });
    });
}

async function checkExpired(dataSource, tableStatus) {
    let nowDataSyncTime = getDateTimeNow();
    let tableNameExpires = [];
    let urls = [];
    if (!(tableStatus.length && dataSource.length)) return [];
    try {
        dataSource.forEach((tableName) => {
            let expiredStatus = tableStatus.find(
                (element) =>
                    element.tableName === tableName &&
                    (element.insertTime >= lastDataSyncTime ||
                        element.updateTime >= lastDataSyncTime)
            );
            let insertExpiredStatus = tableStatus.find(
                (element) =>
                    element.tableName === tableName &&
                    element.insertTime >= lastDataSyncTime
            );
            let updateExpiredStatus = tableStatus.find(
                (element) =>
                    element.tableName === tableName &&
                    element.updateTime >= lastDataSyncTime
            );
            
            if (expiredStatus) {
                if (updateExpiredStatus) {
                    tableNameExpires.push({
                        tableName: tableName,
                        statusType: "updateExpire",
                        url: `../serviceDataServer/${tableName}s.php`,
                        dataFetch: {
                            statusType: "updateExpire",
                            lastSyncTime: lastDataSyncTime,
                        },
                        data: [],
                    });
                } else if (insertExpiredStatus) {
                    tableNameExpires.push({
                        tableName: tableName,
                        statusType: "insertExpire",
                        url: `../serviceDataServer/${tableName}s.php`,
                        dataFetch: {
                            // statusType: "insertExpire", //ทดสอบเฉพาะ updateExpire
                            statusType: "updateExpire",
                            lastSyncTime: lastDataSyncTime,
                        },
                        data: [],
                    });
                }
            }
        });
        if (tableNameExpires.length) {
            var arrayFetch = tableNameExpires.map(function (item) {
                return fetch(item.url, {
                    body: JSON.stringify(item.dataFetch),
                    method: "POST",
                });
            });
            const requests = await Promise.all(arrayFetch);

            const results = await Promise.all(requests.map((r) => r.json()));

            results.forEach((item, index) => {
                tableNameExpires[index].data = item.message;
            });
        }

        lastDataSyncTime = nowDataSyncTime;
        return tableNameExpires;
    } catch (error) {
        throw new Error(error);
    }
}
