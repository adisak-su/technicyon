function renderPagination(current, total) {
    const pagination = document.getElementById("pagination");
    pagination.innerHTML = "";

    const addPage = (page, label = page, active = false, disabled = false) => {
        const li = document.createElement("li");
        li.className = `page-item${active ? " active" : ""}${
            disabled ? " disabled" : ""
        }`;
        const a = document.createElement("a");
        a.className = "page-link";
        a.href = "#";
        a.textContent = label;
        a.onclick = (e) => {
            e.preventDefault();
            if (!disabled && page) {
                currentPage = page;
                renderTable();
            }
        };
        li.appendChild(a);
        pagination.appendChild(li);
    };

    addPage(current - 1, "«", false, current === 1);
    for (let i = 1; i <= total; i++) {
        if (i === 1 || i === total || Math.abs(i - current) <= 2) {
            addPage(i, i, current === i);
        } else if (i === 2) {
            //addPage(null, '...');
            addPage(parseInt(current / 2), "...");
        } else if (i === total - 1) {
            //addPage(null, '...');
            addPage(total - parseInt((total - current) / 2), "...");
        }
        /*else if (i === 2 || i === total - 1) {
                     addPage(null, '...');
                   }*/
    }
    addPage(current + 1, "»", false, current === total);
}
