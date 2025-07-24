let localTableStatus = [];
// let localTableStatus = getStorage("tableStatus");

async function startCheckDataExpired() {
    let result = await getTableStatus();
}

function checkExpired(element) {
    if (localTableStatus) {
        // console.log(localTableStatus);
        let insertTime = findInsertTime(localTableStatus, element.tableName);
        let updateTime = findUpdateTime(localTableStatus, element.tableName);
        // alert(insertTime + " : " + element.insertTime)
        if (insertTime != element.insertTime || updateTime != element.updateTime) {
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
                versionStatusConfigServerData = resp.statusData
                
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
                            if (tableName === "autowords") {
                                tableNameExpire.push(tableName);
                                urls.push(
                                    "service/getAutoWord.php"
                                );
                            }
                            else if (!(tableName == "sales" || tableName == "test_sales")) {
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
                                var arrayFetch = urls.map(function (url) {
                                    return fetch(url);
                                });
                                const requests = await Promise.all(arrayFetch);
                                // var reques = [];
                                // urls.forEach((url)=>{
                                //     reques.push(fetch(url));
                                // });
                                // const reque = await Promise.all(reques);

                                // const requests = await Promise.all([
                                //     fetch("readTable.php?status=1&tableName=products"),
                                // ]);

                                const results = await Promise.all(
                                    requests.map((r) => r.json())
                                );
                                tableNameExpire.forEach((tableName, index) => {
                                    setStorage(
                                        tableName,
                                        JSON.parse(results[index].message)
                                    );
                                });
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
