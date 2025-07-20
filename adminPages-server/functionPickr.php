<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <title>Flatpickr + พ.ศ. + โหลดวันเวลาเก่า</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 4 -->
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">  -->

  <link rel="stylesheet" href="../assets/css/adminlte.min.css">
  <!-- <link rel="stylesheet" href="plugins/toastr/toastr.min.css"> -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css?<?php echo time(); ?>">



  <!-- Flatpickr -->
  <link rel="stylesheet" href="../plugins/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="../plugins/flatpickr/dist/themes/material_blue.css">

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    /* ซ่อน input จริงแบบแนบเนียน */
    /*
    #flatpickr-real {
      position: absolute;
      z-index: -1;
      opacity: 0;
      width: 1px;
      height: 1px;
      pointer-events: none;
    }
  */
    .input-group .form-control {
      background-color: #fff;
      cursor: pointer;
    }
  </style>
</head>

<body class="p-4">
  <div class="container">
    <h4>📅 เลือกวันและเวลา (แสดง พ.ศ.)</h4>

    <div class="form-group">
      <label>วันเวลา (พ.ศ.):</label>
      <div class="input-group position-relative">
        <!-- ช่องแสดงผล -->
        <input type="text" class="form-control" id="display-datetime" readonly placeholder="เลือกวันเวลา" />
        <!-- ช่องจริงที่ Flatpickr ใช้ -->
        <input type="text" id="flatpickr-real" />

        <!-- ปุ่มเปิดปฏิทิน และล้างค่า -->
        <div class="input-group-append">
          <button class="btn btn-outline-secondary" type="button" id="calendar-btn">📅</button>
          <button class="btn btn-outline-danger" type="button" id="clear-btn">❌</button>
          <button class="btn btn-outline-danger" type="button" id="set-btn">set</button>
        </div>
      </div>
    </div>

    <button class="btn btn-success mt-2" onclick="submit()">✅ แสดงค่าที่เลือก</button>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/th.js"></script>

  <script>
    const picker = initDateTimePicker({
      flatpickrSelector: "#flatpickr-real",
      displaySelector: "#display-datetime",
      calendarBtnSelector: "#calendar-btn",
      clearBtnSelector: "#clear-btn",
      initialValue: null // หรือ null ถ้าไม่มีก็ไม่ต้องใส่

      //initialValue: "2025-06-27 15:30:35" // หรือ null ถ้าไม่มีก็ไม่ต้องใส่
    });

    document.querySelector("#set-btn").addEventListener("click", () => {
      picker.setDateFromString("2025-12-30 08:00:00");
    });

    // 📌 แสดงค่าเมื่อกด submit
    function submit() {
      if (!picker) {
        Swal.fire("กรุณาเลือกวันเวลา", "", "warning");
        return;
      }
      let output = picker.getFormatted();

      Swal.fire({
        title: "คุณเลือก",
        html: `
          <b>📅 Date object:</b> ${picker.getDate()}<br>
          <b>📅 Date Time:</b> ${output}<br>
          <b>⏱ Timestamp:</b> ${picker.getTimestamp()}<br>
          <b>🕒 ISO:</b> ${picker.getISOString()}
        `,
        icon: "success"
      });
    }
    /*
    // เรียกใช้ค่าที่ได้
    console.log(picker.getDate());        // Date object
    console.log(picker.getTimestamp());   // timestamp
    console.log(picker.getISOString());   // ISO string
    console.log(picker.getFormatted());   // '2025-06-27 15:30'

    // เปลี่ยนค่าใหม่จาก string ภายนอก:
    picker.setDateFromString("2025-12-01 08:00:00");
      */
    function initDateTimePicker({
      flatpickrSelector,
      displaySelector,
      calendarBtnSelector,
      clearBtnSelector,
      initialValue = null
    }) {
      let selectedDate = new Date();

      function parseLocalDate(str) {
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
          document.querySelector(displaySelector).value = '';
          return;
        }
        const dd = ('0' + date.getDate()).slice(-2);
        const mm = ('0' + (date.getMonth() + 1)).slice(-2);
        const yyyy = date.getFullYear() + 543;
        const hh = ('0' + date.getHours()).slice(-2);
        const mi = ('0' + date.getMinutes()).slice(-2);
        document.querySelector(displaySelector).value = `${dd}/${mm}/${yyyy} ${hh}:${mi}`;
      }

      function formatDateForOutput(date) {
        const yyyy = date.getFullYear();
        const mm = ('0' + (date.getMonth() + 1)).slice(-2);
        const dd = ('0' + date.getDate()).slice(-2);
        const hh = ('0' + date.getHours()).slice(-2);
        const mi = ('0' + date.getMinutes()).slice(-2);
        return `${yyyy}-${mm}-${dd} ${hh}:${mi}`;
      }

      const fp = flatpickr(flatpickrSelector, {
        enableTime: true,
        time_24hr: true,
        dateFormat: "Y-m-d H:i",
        locale: "th",
        defaultDate: null,
        onChange: (selectedDates) => {
          selectedDate = selectedDates[0];
          updateDisplay(selectedDate);
        }
      });

      const openCalendar = () => fp.open();

      document.querySelector(displaySelector).addEventListener("click", openCalendar);
      document.querySelector(calendarBtnSelector).addEventListener("click", openCalendar);

      document.querySelector(clearBtnSelector).addEventListener("click", () => {
        selectedDate = new Date();
        fp.setDate(selectedDate);
        updateDisplay(selectedDate);
      });

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
        setDateFromString: (str) => {
          const d = parseLocalDate(str);
          selectedDate = d;
          fp.setDate(d);
          updateDisplay(d);
        }
      };
    }
  </script>
</body>

</html>