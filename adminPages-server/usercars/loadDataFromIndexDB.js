async function loadDataUsercar() {
    let dataStore = await loadDataFromDB("usercars");
    return dataStore;
}

async function loadAndSetDataFromDB(sourceName,inputId, suggestionsId) {
    let dataStore = await loadDataFromDB(sourceName);
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

async function loadAndSetDataGroup(inputId, suggestionsId) {
    let dataStore = await loadDataFromDB("groupnames");
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

async function loadAndSetDataColor(inputId,suggestionsId) {
    let dataStore = await getColor();
    setupAutocompleteOnFocus({
        inputId: inputId,
        suggestionsId: suggestionsId,//"colorSuggestions",
        dataList: dataStore,
        codeId: "colorname",
        arrayShowValue: ["colorname"],
        arrayFindValue: ["colorname"],
        // callbackFunction: changeFilter,
        //sortField: "groupname"
    });
    return dataStore;
}

async function _getColor() {
    return new Promise(function (resolve, reject) {
        $.ajax({
            url: "services/getColor.php",
            type: "GET",
            dataType: "json",
            beforeSend: function () {},
            success: function (data) {
                if (data.status) {
                    resolve(data.message); // Resolve promise and when success
                } else {
                    sweetAlertError("เกิดข้อผิดพลาด : ", 3000);
                    resolve(null);
                }
            },
            error: function (err) {
                sweetAlertError("เกิดข้อผิดพลาด : " + err.responseText, 0);
                reject(err); // Reject the promise and go to catch()
            },
        });
    });
}
