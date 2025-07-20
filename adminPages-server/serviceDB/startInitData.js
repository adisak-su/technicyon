let localTableStatus = [];
let lastDataSyncTime = getDateTimeNow();

async function loadDataFromServer(endpoint) {
    return await await ajaxFetchData(
        endpoint,
        "lastDataSyncTime",
        "statusType"
    );
}

async function ajaxFetchData(endpoint, lastSyncTime, statusType) {
    return new Promise(function (resolve, reject) {
        $.ajax({
            url: `../serviceDB/${endpoint}s.php`,
            url: `../serviceDB/endpoints.php`,
            type: "POST",
            data: {
                tableName: endpoint,
                lastSyncTime: lastSyncTime,
                statusType: statusType,
            },
            success: function (data) {
                if (data.status) {
                    resolve(data.datas);
                } else {
                    sweetAlertError("เกิดข้อผิดพลาด : " + data.message, 0);
                    resolve(null);
                }
            },
            error: function (error) {
                // let message = error?.responseJSON?.message ?? error.responseText;
                // sweetAlertError('เกิดข้อผิดพลาด : ' + message, 0);
                reject(error);
            },
        });
    });
}

async function startCheckDataExpired(dataSource) {
    let result = await getTableStatus();
    let dataExpires = [];
    if (result) {
        // setStorage("tableStatus", result);
        let dataSourceExpired = await checkExpired(dataSource, result);
        if (dataSourceExpired) {
            for (i = 0; i < dataSourceExpired.length; i++) {
                let tableExpire = dataSourceExpired[i];
                let dataExpire = await ajaxFetchData(
                    tableExpire.tableName,
                    lastDataSyncTime,
                    tableExpire.statusType
                );
                if (dataExpire) {
                    dataExpires.push({
                        tableName: tableExpire.tableName,
                        statusType: tableExpire.statusType,
                        data: dataExpire,
                    });
                }
            }
            lastDataSyncTime = getDateTimeNow();
        }
    }
    
    return dataExpires;
}

async function checkExpired(dataSource, tableStatus) {
    let tableExpires = [];
    dataSource.forEach((item) => {
        if (tableStatus.length) {
            let expiredStatus = tableStatus.find(
                (element) =>
                    element.tableName === item &&
                    (element.insertTime >= lastDataSyncTime ||
                        element.updateTime >= lastDataSyncTime)
            );

            let expiredStatusInsert = tableStatus.find(
                (element) =>
                    element.tableName === item &&
                    element.insertTime >= lastDataSyncTime
            );

            let expiredStatusUpdate = tableStatus.find(
                (element) =>
                    element.tableName === item &&
                    element.updateTime >= lastDataSyncTime
            );

            if (expiredStatusInsert || expiredStatusUpdate) {
                if (expiredStatusInsert && !expiredStatusUpdate) {
                    tableExpires.push({
                        tableName: item,
                        statusType: "insertExpire",
                    });
                } else {
                    tableExpires.push({
                        tableName: item,
                        statusType: "updateExpire",
                    });
                }
            }
        }
    });
    return tableExpires;
}

async function getTableStatus() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url: "../serviceDB/readTableStatus.php",
            success: function (data) {
                if (data.status) {
                    setStorage("tableStatus", data.message);
                    resolve(data.message);
                } else {
                    sweetAlertError("เกิดข้อผิดพลาด : " + data.message, 0);
                    resolve(null);
                }
            },
            error: function (error) {
                let message =
                    error?.responseJSON?.message ?? error.responseText;
                sweetAlertError("เกิดข้อผิดพลาด : " + message, 0);
                reject(error);
            },
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
