async function loadAndSetDataFromDB({dataSource, inputId, suggestionsId}) {
    let dataStore = await loadDataFromDB(dataSource);
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
