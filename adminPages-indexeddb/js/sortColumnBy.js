function sortColumnBy(colName, element) {
    let index = sortColumn.findIndex((item) => item.colName === colName);
    if (index >= 0) {
        let sortType = sortColumn[index].state;
        sortColumn = sortColumn.map((item) => {
            return {
                colName: item.colName,
                state: "ASC",
            };
        });

        // clear การจัดเรียง
        let parent = element.parentElement;
        for (child of parent.children) {
            let icon = child.querySelector("#icon");
            if (icon) {
                icon.innerHTML = "";
            }
        }

        if (sortType === "ASC") {
            sortColumn[index].state = "DESC";
            let icon = element.querySelector("#icon");
            if (icon) {
                icon.innerHTML = '<i class="fa-solid fa-arrow-down-a-z"></i>';
            }
            filtered.sort((a, b) => a[colName].localeCompare(b[colName]));
            currentPage = 1;
            renderTable();
        } else {
            sortColumn[index].state = "ASC";
            let icon = element.querySelector("#icon");
            if (icon) {
                icon.innerHTML = '<i class="fa-solid fa-arrow-up-z-a"></i>';
            }
            filtered.sort((a, b) => b[colName].localeCompare(a[colName]));
            currentPage = 1;
            renderTable();
        }
    }
}
