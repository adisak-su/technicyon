/*
    <!-- Flatpickr CSS-->
    <link rel="stylesheet" href="plugins/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="plugins/flatpickr/dist/themes/material_blue.css">


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/th.js"></script>

    // สร้าง
     const picker = initDateTimePicker({
      displaySelector: "display-datetime2",
      initialValue: null // หรือ null ถ้าไม่มีก็ไม่ต้องใส่
      //initialValue: "2025-06-27 15:30:35" // หรือ null ถ้าไม่มีก็ไม่ต้องใส่
    });

    // เรียกใช้ค่าที่ได้
    console.log(picker.getDate());        // Date object
    console.log(picker.getTimestamp());   // timestamp
    console.log(picker.getISOString());   // ISO string
    console.log(picker.getFormatted());   // '2025-06-27 15:30'

    // เปลี่ยนค่าใหม่จาก string ภายนอก:
    picker.setDateFromString("2025-12-01 08:00:00");
*/
function initDateTimePicker({ displaySelector, resetBtn, initialValue = null }) {
    let selectedDate = new Date();
    let calendarBtnSelector = `${displaySelector}_calendar-btn`;
    // let clearBtnSelector = `${displaySelector}_clear-btn`;
    let clearBtnSelector = `${resetBtn}`;
    let setValueBtnSelector = `${displaySelector}_set-btn`;
    let flatpickrSelector = `${displaySelector}_flatpickr-real`;

    initFlatPickr();

    function initFlatPickr() {
        let parentDiv = document.getElementById(displaySelector).parentElement;

        let htmlString1 = `
        <!-- ช่องจริงที่ Flatpickr ใช้ -->
        <div style="width:0px; height:0px;overflow:hidden;">
          <input type="text" id="${displaySelector}_flatpickr-real" />
        </div>

        <!-- ปุ่มเปิดปฏิทิน และล้างค่า -->
        <div class="input-group-append">
          <button class="btn btn-outline-secondary" type="button" id="${displaySelector}_calendar-btn">📅</button>
          <button class="btn btn-outline-danger" type="button" id="${displaySelector}_clear-btn">❌</button>
          <button class="btn btn-outline-danger" type="button" id="${displaySelector}_set-btn">set</button>
        </div>
        `;

        let htmlString = `
        <!-- ช่องจริงที่ Flatpickr ใช้ -->
        <div style="width:0px; height:0px;overflow:hidden;position: absolute; top:10px;">
          <input type="text" id="${displaySelector}_flatpickr-real" />
        </div>
        `;

        parentDiv.innerHTML += htmlString;
    }

    function parseLocalDate(str) {
        // format "2525-12-31 08:30:00"
        const parts = str.split(/[- :]/);
        return new Date(
            parseInt(parts[0]),
            parseInt(parts[1]) - 1,
            parseInt(parts[2]),
            parseInt(parts[3]),
            parseInt(parts[4]),
            parseInt(parts[5]) || 0
        );
    }

    function updateDisplay(date) {
        if (!date) {
            document.getElementById(displaySelector).value = "";
            return;
        }
        const dd = ("0" + date.getDate()).slice(-2);
        const mm = ("0" + (date.getMonth() + 1)).slice(-2);
        const yyyy = date.getFullYear() + 543;
        const hh = ("0" + date.getHours()).slice(-2);
        const mi = ("0" + date.getMinutes()).slice(-2);
        document.getElementById(
            displaySelector
        ).value = `${dd}/${mm}/${yyyy} ${hh}:${mi}`;
    }

    function formatDateForOutput(date) {
        const yyyy = date.getFullYear();
        const mm = ("0" + (date.getMonth() + 1)).slice(-2);
        const dd = ("0" + date.getDate()).slice(-2);
        const hh = ("0" + date.getHours()).slice(-2);
        const mi = ("0" + date.getMinutes()).slice(-2);
        return `${yyyy}-${mm}-${dd} ${hh}:${mi}`;
    }

    function initDateFromString(str) {
        // format "2525-12-31 08:30:00"
        const d = parseLocalDate(str);
        selectedDate = d;
        fp.setDate(d);
        updateDisplay(d);
    }

    const fp = flatpickr(`#${flatpickrSelector}`, {
        enableTime: true,
        time_24hr: true,
        dateFormat: "Y-m-d H:i",
        locale: "th",
        defaultDate: null,
        onChange: (selectedDates) => {
            selectedDate = selectedDates[0];
            updateDisplay(selectedDate);
        },
    });

    const openCalendar = () => fp.open();
    const setDataToCalendar = (str) => {
        initDateFromString("2025-12-30 08:00:00");
    };

    if (document.getElementById(displaySelector)) {
        document
            .getElementById(displaySelector)
            .addEventListener("click", openCalendar);
    }
    if (document.getElementById(calendarBtnSelector)) {
        document
            .getElementById(calendarBtnSelector)
            .addEventListener("click", openCalendar);
    }
    if (document.getElementById(setValueBtnSelector)) {
        document
            .getElementById(setValueBtnSelector)
            .addEventListener("click", setDataToCalendar);
    }
    if (document.getElementById(clearBtnSelector)) {
        document
            .getElementById(clearBtnSelector)
            .addEventListener("click", () => {
                selectedDate = new Date();
                fp.setDate(selectedDate);
                updateDisplay(selectedDate);
            });
    }

    if (initialValue) {
        const restored = parseLocalDate(initialValue);
        selectedDate = restored;
        fp.setDate(restored);
        updateDisplay(restored);
    } else {
        fp.setDate(selectedDate);
        updateDisplay(selectedDate);
    }

    return {
        getDate: () => selectedDate,
        getTimestamp: () => selectedDate.getTime(),
        getISOString: () => selectedDate.toISOString(),
        getFormatted: () => formatDateForOutput(selectedDate),
        setDateFromString: (str) => initDateFromString(str),
        setDateNow: () => {selectedDate = new Date();
                fp.setDate(selectedDate);
                updateDisplay(selectedDate);}
    };
}
