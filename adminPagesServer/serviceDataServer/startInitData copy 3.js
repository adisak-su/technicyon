let lastDataSyncTime = getDateTimeNow();

let itemTimeSync = getStorage("itemTimeSync");
let timeSync = 10000; // 10 วินาที
if (itemTimeSync) {
    timeSync = itemTimeSync.itemTimeSync * 1000;
}

function getDateTimeNow() {
    return new Date().addHours(7).toISOString().replace("T", " ").substr(0, 19);
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
                    // setStorage("tableStatus", result);

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

async function startCheckDataExpired(dataSource = []) {
    let result = await getTableStatus();
    if (result) {
        setStorage("tableStatus", result);
        return await checkExpired(dataSource, result);
    }
    return [];
}

async function _checkExpired(dataSource, tableStatus) {
    let nowDataSyncTime = getDateTimeNow();
    let tableExpires = [];
    let tableNameExpires = [];
    let urls = [];
    try {
        dataSource.forEach((item) => {
            if (tableStatus) {
                let expiredStatus = tableStatus.find(
                    (element) =>
                        element.tableName === item &&
                        (element.insertTime >= lastDataSyncTime ||
                            element.updateTime >= lastDataSyncTime)
                );
                if (expiredStatus) {
                    tableNameExpires.push({
                        tableName: item,
                        statusType: "updateExpire",
                        data: [],
                    });
                    urls.push(`../serviceDataServer/${item}.php`);
                }
            }
        });
        if (tableNameExpires.length) {
            console.table(urls);
            var arrayFetch = urls.map(function (url) {
                return fetch(url, { method: "POST" });
            });
            // console.table(arrayFetch);
            const requests = await Promise.all(arrayFetch);

            const results = await Promise.all(requests.map((r) => r.json()));
            tableNameExpires.forEach((item, index) => {
                item.data = results[index].message;
            });
        }

        lastDataSyncTime = nowDataSyncTime;
        return tableNameExpires;
    } catch (error) {
        throw new Error(error);
    }
}

function delay(ms) {
    return new Promise((resolve) => setTimeout(resolve, ms));
}

async function postWithRetryParallel(
    taskId,
    url,
    data,
    maxRetries = 2,
    delayMs = 1000
) {
    console.log("⏳ ส่งคำขอ...");

    for (let attempt = 1; attempt <= maxRetries + 1; attempt++) {
        try {
            const res = await axios.post(url, data, {
                headers: { "Content-Type": "application/json" },
            });
            console.log("✅ สำเร็จ", "text-success");
            return { status: "success", url, data: res.data };
        } catch (err) {
            if (attempt > maxRetries) {
                console.log(
                    `❌ ล้มเหลว (${err.response?.status || err.message})`,
                    "text-danger"
                );
                return { status: "error", url, error: err };
            }
            console.log(`🔁 พยายามใหม่ (รอบ ${attempt})...`, "text-warning");
            await delay(delayMs);
        }
    }
}

async function checkExpired(dataSource, tableStatus) {
    let nowDataSyncTime = getDateTimeNow();
    let tableNameExpires = [];
    let urls = [];
    try {
        dataSource.forEach((item) => {
            if (tableStatus) {
                let expiredStatus = tableStatus.find(
                    (element) =>
                        element.tableName === item &&
                        (element.insertTime >= lastDataSyncTime ||
                            element.updateTime >= lastDataSyncTime)
                );
                let insertExpiredStatus = tableStatus.find(
                    (element) =>
                        element.tableName === item &&
                        element.insertTime >= lastDataSyncTime
                );
                let updateExpiredStatus = tableStatus.find(
                    (element) =>
                        element.tableName === item &&
                        element.updateTime >= lastDataSyncTime
                );

                let statusType = "";

                if (expiredStatus) {
                    if (updateExpiredStatus) {
                        tableNameExpires.push({
                            tableName: item,
                            statusType: "updateExpire",
                            data: [],
                        });
                        statusType = "updateExpire";
                    } else if (insertExpiredStatus) {
                        tableNameExpires.push({
                            tableName: item,
                            statusType: "insertExpire",
                            data: [],
                        });
                        statusType = "insertExpire";
                    }
                    urls.push({
                        url: `../serviceDataServer/${item}s.php`,
                        data: {
                            statusType: statusType,
                            lastSyncTime: lastDataSyncTime,
                        },
                    });
                }
            }
        });
        if (tableNameExpires.length) {
            const promises = urls.map((req, i) =>
                postWithRetryParallel(i, req.url, req.data).then((result) => {
                    return result;
                })
            );

            const results = await Promise.allSettled(promises);

            results.forEach((item, index) => {
                tableNameExpires[index].data = item.value.data.message;
            });

            // tableNameExpires.forEach((item, index) => {
            //     tableNameExpires[index].data =
            //         results[index].value.data.message;
            // });
            // console.table(results);
            // console.table(tableNameExpires);
        }
        lastDataSyncTime = nowDataSyncTime;
        return tableNameExpires;
    } catch (error) {
        throw new Error(error);
    }
}

function _checkExpiredOld(localTableStatus) {
    let tableNameExpires = [];
    localTableStatus.forEach((item) => {
        let expiredStatus = localTableStatus.find(
            (element) =>
                element.tableName === item.tableName &&
                (element.insertTime >= lastDataSyncTime ||
                    element.updateTime >= lastDataSyncTime)
        );
        let insertExpiredStatus = localTableStatus.find(
            (element) =>
                element.tableName === item.tableName &&
                element.insertTime >= lastDataSyncTime
        );
        let updateExpiredStatus = localTableStatus.find(
            (element) =>
                element.tableName === item.tableName &&
                element.updateTime >= lastDataSyncTime
        );

        if (expiredStatus) {
            if (updateExpiredStatus) {
                tableNameExpires.push({
                    tableName: item.tableName,
                    statusType: "updateExpire",
                    url: `../serviceDataServer/${item.tableName}s.php`,
                    dataFetch: {
                        statusType: "updateExpire",
                        lastSyncTime: lastDataSyncTime,
                    },
                    data: [],
                });
                statusType = "updateExpire";
            } else if (insertExpiredStatus) {
                tableNameExpires.push({
                    tableName: item.tableName,
                    statusType: "insertExpire",
                    url: `../serviceDataServer/${item.tableName}s.php`,
                    dataFetch: {
                        statusType: "insertExpire",
                        lastSyncTime: lastDataSyncTime,
                    },
                    data: [],
                });
                statusType = "insertExpire";
            }
        }
    });

    return tableNameExpires;
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

async function getDataTableExpired() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url: "../serviceDataServer/readTableStatus.php",
        })
            .done(function (resp) {
                result = resp.message;
                let nowDataSyncTime = getDateTimeNow();

                if (result) {
                    // console.log("results TableStatus");
                    // console.table(result);
                    let tableNameExpire = _checkExpiredOld(result);
                    if (tableNameExpire.length) {
                        // console.log("tableNameExpire");
                        // console.table(tableNameExpire);

                        const fetchNames = async () => {
                            try {
                                var arrayFetch = tableNameExpire.map(function (
                                    item
                                ) {
                                    return fetch(item.url, {
                                        body: JSON.stringify(item.dataFetch),
                                        method: "POST",
                                    });
                                });
                                const requests = await Promise.all(arrayFetch);

                                const results = await Promise.all(
                                    requests.map((r) => r.json())
                                );
                                // console.log("results Fetch");
                                // console.table(results);

                                results.forEach((item, index) => {
                                    tableNameExpire[index].data = item.message;
                                });

                                // console.log("results tableNameExpire");
                                // console.table(tableNameExpire);

                                lastDataSyncTime = nowDataSyncTime;
                                return tableNameExpire;
                            } catch {
                                return [];
                            }
                        };
                        resolve(fetchNames());
                    }
                }
                resolve([]);
            })
            .fail(function (error) {
                alert("Error get : " + JSON.stringify(error));
                reject(false);
            });
    });
}
