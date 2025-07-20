function setupAutocompleteOnFocus({
    inputId,
    suggestionsId,
    dataList,
    codeId,
    arrayShowValue,
    arrayFindValue,
    sizeFind = 0,
    sortField = null,
    callbackFunction = null,
}) {
    const input = document.getElementById(inputId);
    const suggestionsBox = document.getElementById(suggestionsId);

    let currentFocus = -1;

    input.addEventListener("focus", function () {
        // Create a new 'change' event
        this.select();
        var event = new Event("input");
        let value = this?.value ?? "";
        if (!value || value.length == 0) {
            this.value = "";
        }
        // Dispatch it.
        input.dispatchEvent(event);
        return;
    });

    input.addEventListener("input", function () {
        const value = this.value.toLowerCase();
        suggestionsBox.classList.remove("d-none");
        suggestionsBox.innerHTML = "";
        currentFocus = -1;
        if (callbackFunction) {
            callbackFunction(null);
        }
        let matches = dataList;
        if (value && value.length >= sizeFind) {
            matches = [];
            arrayFindValue.forEach((findItem) => {
                let tmp = dataList.filter((item) =>
                    item[findItem].toLowerCase().includes(value)
                );
                matches.push(...tmp);
            });
            matches = Array.from(new Set(matches));
        }
        if (sortField) {
            matches.sort(function (a, b) {
                return a[sortField].localeCompare(b[sortField]);
            });
        }

        if (matches.length) {
            suggestionsBox.classList.add("suggestions-active");
        } else {
            suggestionsBox.classList.remove("suggestions-active");
        }

        matches.forEach((item) => {
            const div = document.createElement("div");
            let strShowValue = "";
            if (arrayShowValue.length) {
                strShowValue += item[arrayShowValue[0]];
            }
            arrayShowValue.forEach((show, index) => {
                if (index !== 0) {
                    strShowValue += " : " + item[show];
                }
            });
            div.textContent = strShowValue;
            div.classList.add("suggestion-item");
            div.addEventListener("click", () => {
                input.value = `${item[codeId]}`;
                if (input.onchange) {
                    input.onchange();
                }
                
                if (callbackFunction) {
                    callbackFunction(item);
                }
                suggestionsBox.classList.add("d-none");
                //suggestionsBox.innerHTML = "";
            });
            suggestionsBox.appendChild(div);
        });
    });

    input.addEventListener("keydown", function (e) {
        const items = suggestionsBox.querySelectorAll(".suggestion-item");

        if (e.key === "ArrowDown") {
            currentFocus++;
            if (currentFocus >= items.length) currentFocus = 0;
            setActive(items);
            e.preventDefault();
        } else if (e.key === "ArrowUp") {
            currentFocus--;
            if (currentFocus < 0) currentFocus = items.length - 1;
            setActive(items);
            e.preventDefault();
        } else if (e.key === "Enter") {
            if (currentFocus > -1 && items[currentFocus]) {
                items[currentFocus].click();
            }
            e.preventDefault();
        }
    });

    function setActive(items) {
        if (!items.length) return;
        items.forEach((item) => item.classList.remove("active"));
        items[currentFocus]?.classList.add("active");
        items[currentFocus]?.scrollIntoView({
            block: "nearest",
        });
    }

    document.addEventListener("click", async (e) => {
        if (
            !e.target.closest(`#${inputId}`) &&
            !suggestionsBox.classList.contains("d-none")
        ) {
            // if (suggestionsBox.hasClass('d-none')) {
            //     console.log('Element has the class.');
            // }
            if (callbackFunction) {
                let value = input?.value ?? "";
                if (value && value.length > 0) {
                    let result = dataList.find(
                        (item) =>
                            item[codeId].toLowerCase() == value.toLowerCase()
                    );
                    if (result) {
                        callbackFunction(result);
                    }
                }
            }
            suggestionsBox.classList.add("d-none");
            // suggestionsBox.innerHTML = "";
            // suggestionsBox.classList.remove("suggestions-active");
        }
    });
}

function setupAutocomplete(
    inputId,
    suggestionsId,
    dataList,
    codeId,
    arrayShowValue,
    arrayFindValue,
    callbackFunction = null
) {
    const input = document.getElementById(inputId);
    const suggestionsBox = document.getElementById(suggestionsId);

    let currentFocus = -1;

    input.addEventListener("input", function () {
        const value = this.value.toLowerCase();
        suggestionsBox.innerHTML = "";
        currentFocus = -1;
        if (callbackFunction) {
            callbackFunction(null);
        }

        if (!value || value.length < 1) return;

        // let matches = dataList;

        let matches = [];

        // arrayFindValue.forEach((findItem) => {
        //     matches = dataList.filter((item) =>
        //         item[findItem].toLowerCase().includes(value)
        //     );
        // });

        arrayFindValue.forEach((findItem) => {
            let tmp = dataList.filter((item) =>
                item[findItem].toLowerCase().includes(value)
            );
            matches.push(...tmp);
        });

        matches = Array.from(new Set(matches));

        if (matches.length) {
            suggestionsBox.classList.add("suggestions-active");
        } else {
            suggestionsBox.classList.remove("suggestions-active");
        }

        matches.forEach((item) => {
            const div = document.createElement("div");
            let strShowValue = "";
            if (arrayShowValue.length) {
                strShowValue += item[arrayShowValue[0]];
            }
            arrayShowValue.forEach((show, index) => {
                if (index !== 0) {
                    strShowValue += " : " + item[show];
                }
            });
            div.textContent = strShowValue;
            div.classList.add("suggestion-item");
            div.addEventListener("click", () => {
                input.value = `${item[codeId]}`;
                if (callbackFunction) {
                    callbackFunction(item);
                }
                suggestionsBox.innerHTML = "";
            });
            suggestionsBox.appendChild(div);
        });
    });

    input.addEventListener("keydown", function (e) {
        const items = suggestionsBox.querySelectorAll(".suggestion-item");

        if (e.key === "ArrowDown") {
            currentFocus++;
            if (currentFocus >= items.length) currentFocus = 0;
            setActive(items);
            e.preventDefault();
        } else if (e.key === "ArrowUp") {
            currentFocus--;
            if (currentFocus < 0) currentFocus = items.length - 1;
            setActive(items);
            e.preventDefault();
        } else if (e.key === "Enter") {
            if (currentFocus > -1 && items[currentFocus]) {
                items[currentFocus].click();
            }
            e.preventDefault();
        }
    });

    function setActive(items) {
        if (!items.length) return;
        items.forEach((item) => item.classList.remove("active"));
        items[currentFocus]?.classList.add("active");
        items[currentFocus]?.scrollIntoView({
            block: "nearest",
        });
    }

    document.addEventListener("click", (e) => {
        if (!e.target.closest(`#${inputId}`)) {
            suggestionsBox.innerHTML = "";
            suggestionsBox.classList.remove("suggestions-active");
        }
    });
}

function setupAutocompleteProducts(
    inputId,
    suggestionsId,
    dataList,
    codeId,
    arrayShowValue,
    arrayFindValue,
    callbackFunction
) {
    const input = document.getElementById(inputId);
    const suggestionsBox = document.getElementById(suggestionsId);

    let currentFocus = -1;

    input.addEventListener("input", function () {
        const value = this.value.toLowerCase();
        suggestionsBox.innerHTML = "";
        currentFocus = -1;
        if (callbackFunction) {
            callbackFunction(null);
        }

        if (!value || value.length < 3) return;

        let tmpMatches = [];

        let matches = [];

        arrayFindValue.forEach((findItem) => {
            let tmp = dataList.filter((item) =>
                item[findItem].toLowerCase().includes(value)
            );
            matches.push(...tmp);
        });

        matches = Array.from(new Set(matches));
        matches.sort(function (a, b) {
            return a.name.localeCompare(b.name);
        });
        if (matches.length) {
            suggestionsBox.classList.add("suggestions-active");
        } else {
            suggestionsBox.classList.remove("suggestions-active");
        }

        matches.forEach((item) => {
            const div = document.createElement("div");
            let strShowValue = "";
            if (arrayShowValue.length) {
                strShowValue += item[arrayShowValue[0]];
            }
            arrayShowValue.forEach((show, index) => {
                if (index !== 0) {
                    strShowValue += " : " + item[show];
                }
            });
            div.textContent = strShowValue;
            div.classList.add("suggestion-item");
            div.addEventListener("click", () => {
                input.value = `${item[codeId]}`;
                if (callbackFunction) {
                    callbackFunction(item);
                }
                suggestionsBox.innerHTML = "";
            });
            suggestionsBox.appendChild(div);
        });
    });

    input.addEventListener("keydown", function (e) {
        const items = suggestionsBox.querySelectorAll(".suggestion-item");

        if (e.key === "ArrowDown") {
            currentFocus++;
            if (currentFocus >= items.length) currentFocus = 0;
            setActive(items);
            e.preventDefault();
        } else if (e.key === "ArrowUp") {
            currentFocus--;
            if (currentFocus < 0) currentFocus = items.length - 1;
            setActive(items);
            e.preventDefault();
        } else if (e.key === "Enter") {
            if (currentFocus > -1 && items[currentFocus]) {
                items[currentFocus].click();
            }
            e.preventDefault();
        }
    });

    function setActive(items) {
        if (!items.length) return;
        items.forEach((item) => item.classList.remove("active"));
        items[currentFocus]?.classList.add("active");
        items[currentFocus]?.scrollIntoView({
            block: "nearest",
        });
    }

    document.addEventListener("click", (e) => {
        if (!e.target.closest(`#${inputId}`)) {
            suggestionsBox.innerHTML = "";
            suggestionsBox.classList.remove("suggestions-active");
        }
    });
}
