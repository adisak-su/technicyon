// ฟังก์ชันช่วยสำหรับวันที่
function getTodayDate() {
    const now = new Date();
    const yyyy = now.getFullYear();
    const mm = String(now.getMonth() + 1).padStart(2, "0");
    const dd = String(now.getDate()).padStart(2, "0");
    return `${yyyy}-${mm}-${dd}`;
}

function getCurrentTime() {
    const now = new Date();
    const hh = String(now.getHours()).padStart(2, "0");
    const mi = String(now.getMinutes()).padStart(2, "0");
    return `${hh}:${mi}`;
}

function getThaiDate(inputDate = null) {
    if (!inputDate) {
        inputDate = getTodayDate();
    }
    const [yyyy, mm, dd] = inputDate.split("-");
    const buddhistYear = parseInt(yyyy) + 543;
    return `${dd}/${mm}/${buddhistYear}`;
}
