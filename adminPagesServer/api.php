<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>Parallel API with Progress</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap v4 -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body { padding: 20px; }
    .text-monospace { font-family: monospace; font-size: 0.9rem; }
  </style>
</head>
<body>

  <div class="container">
    <h4 class="mb-3">🚀 ทดสอบเรียก API แบบขนาน พร้อม Progress</h4>

    <div class="progress mb-3">
      <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated"
           role="progressbar" style="width: 0%">0%</div>
    </div>

    <button id="startBtn" class="btn btn-primary mb-3">เริ่มส่ง API (Parallel)</button>

    <ul id="taskStatus" class="list-group"></ul>
  </div>

  <!-- Axios -->
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

  <script>
    function delay(ms) {
      return new Promise(resolve => setTimeout(resolve, ms));
    }

    async function postWithRetryParallel(taskId, url, data, maxRetries = 2, delayMs = 1000) {
      const statusEl = document.getElementById(`task-${taskId}`);
      const log = (msg, className = 'text-muted') => {
        statusEl.innerHTML = `<strong class="text-monospace">${url}</strong><br><small class="${className}">${msg}</small>`;
      };

      log("⏳ ส่งคำขอ...");

      for (let attempt = 1; attempt <= maxRetries + 1; attempt++) {
        try {
          const res = await axios.post(url, data, {
            headers: { 'Content-Type': 'application/json' }
          });
          log("✅ สำเร็จ " + res?.data?.datas?.length, "text-success");
          return { status: 'success', url, data: res.data };
        } catch (err) {
          if (attempt > maxRetries) {
            log(`❌ ล้มเหลว (${err.response?.status || err.message})`, "text-danger");
            return { status: 'error', url, error: err };
          }
          log(`🔁 พยายามใหม่ (รอบ ${attempt})...`, "text-warning");
          await delay(delayMs);
        }
      }
    }

    function updateMainProgress(done, total) {
      const percent = Math.round((done / total) * 100);
      const bar = document.getElementById("progressBar");
      bar.style.width = percent + "%";
      bar.innerText = percent + "%";
    }

    document.getElementById("startBtn").addEventListener("click", async () => {
      const taskStatus = document.getElementById("taskStatus");
      taskStatus.innerHTML = "";

      const requests = [
        { url: "serviceDB/colornames.php", data: { statusType: "Test 1",lastSyncTime:"2025" } },
        { url: "https://jsonplaceholder.typicode.com/posts", data: { title: "Test 2" } },
        { url: "https://jsonplaceholder.typicode.com/posts", data: { title: "Test 3" } },
        { url: "https://invalid.example.com/404", data: { title: "Fail me" } }
      ];

      // สร้างรายการ UI
      requests.forEach((req, i) => {
        const li = document.createElement("li");
        li.id = `task-${i}`;
        li.className = "list-group-item py-2";
        li.innerText = "รอเริ่ม...";
        taskStatus.appendChild(li);
      });

      let completed = 0;
      const total = requests.length;
      updateMainProgress(completed, total);

      const promises = requests.map((req, i) =>
        postWithRetryParallel(i, req.url, req.data).then(result => {
          completed++;
          updateMainProgress(completed, total);
          return result;
        })
      );

      const results = await Promise.allSettled(promises);
      console.table(results)
      console.log("ผลลัพธ์ทั้งหมด:", results);
    });
  </script>
</body>
</html>
