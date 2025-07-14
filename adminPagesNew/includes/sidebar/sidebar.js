// utilities.js
function getCurrentPath() {
    const parentPath = "adminPagesNew";
    const url = new URL(window.location.href);
    let path = url.pathname
        .replace(/^\//, "") // ตัด / หน้าสุดท้าย
        .replace(/\/$/, ""); // ตัด / หลังสุด
    
    let paths = path.split("/");
    let index = paths.findIndex((element) => { return element === parentPath; });

    
    // alert((paths[index+1]||"") + "/" + (paths[index+2]||""));
    // let parent = paths[index+1]||"";
    // let page = paths[index+2]||"";
    let currentPage = (paths[index+1]||"") + "/" + (paths[index+2]||"");
    return currentPage;

    // return url.pathname
    //     .replace(/^\//, "") // ตัด / หน้าสุดท้าย
    //     .replace(/\/$/, "") // ตัด / หลังสุด
    //     .replace("adminPages/", ""); // ตัด / หลังสุด
}

// ฟังก์ชันหลักสำหรับตั้งค่าเมนู active
function setActiveMenu(path=null) {
    // ตั้งค่าหน้าปัจจุบันสำหรับการแสดงผล
    const currentPath = path || getCurrentPath();
    // document.getElementById("currentPage").textContent = "/" + path;
    document.getElementById("currentPage").textContent = currentPath;

    // ลบคลาส active ออกจากทุกเมนู
    document.querySelectorAll("#sidebar a").forEach((link) => {
        link.classList.remove("active");
    });

    // ปิดเมนูย่อยทั้งหมด
    document.querySelectorAll(".has-submenu").forEach((menu) => {
        menu.classList.remove("active");
    });
    document.querySelectorAll(".submenu").forEach((sub) => {
        sub.style.maxHeight = "0";
    });

    // ถ้าไม่ได้เลือกเมนู (ล้างสถานะ)
    if (!currentPath) return;

    // ค้นหาเมนูที่ตรงกับ path ปัจจุบัน
    let found = false;
    document.querySelectorAll("#sidebar a").forEach((link) => {
        const linkPath = link.getAttribute("href");
        // if (linkPath === "/" + currentPath || linkPath === currentPath) {
        if (linkPath.includes(currentPath) || linkPath === path) {
            link.classList.add("active");
            found = true;

            // เปิดเมนูหลักถ้าเป็นเมนูย่อย
            const submenu = link.closest(".submenu");
            if (submenu) {
                const parentMenu = submenu.closest(".has-submenu");
                if (parentMenu) {
                    parentMenu.classList.add("active");
                    submenu.style.maxHeight = submenu.scrollHeight + "px";
                    // parentMenu.querySelector("a")?.classList.add("active");
                }
            }
        }
    });

    // กรณีไม่เจอเมนูที่ตรงกัน (อาจเป็นเมนูหลัก)
    if (!found) {
        document.querySelectorAll("#sidebar a").forEach((link) => {
            const linkPath = link.getAttribute("href");
            // if (linkPath && currentPath.startsWith(linkPath.replace("/", ""))) {
            if (linkPath && linkPath.includes(currentPath)) {
                link.classList.add("active");
            }
        });
    }
}

// Sidebar toggle
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("show");
    document.getElementById("overlay").classList.toggle("show");
}

function closeSidebar() {
    document.getElementById("sidebar").classList.remove("show");
    document.getElementById("overlay").classList.remove("show");
}

// เปิดเมนูย่อยเมื่อคลิกที่เมนูหลัก
document.querySelectorAll(".has-submenu > a").forEach((item) => {
    item.addEventListener("click", function (e) {
        e.preventDefault();
        const parent = this.parentElement;
        const submenu = this.nextElementSibling;

        parent.classList.toggle("active");
        if (parent.classList.contains("active")) {
            submenu.style.maxHeight = submenu.scrollHeight + "px";
        } else {
            submenu.style.maxHeight = "0";
        }
    });
});

// ตั้งค่าเริ่มต้น - หน้าปรับยอดสต็อก
// setActiveMenu('stock/adjust');
setActiveMenu();
