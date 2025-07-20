<?php
require_once("../../../service/connect.php");
header('Content-Type: application/json');
$DB = new Database();
$conn = $DB->connect();
$lastSync = $_POST['lastSyncRecord'] ?? [];

// ดึงข้อมูลการเปลี่ยนแปลง
$lastSync = $_POST['lastSyncRecord'];
$where = "";
foreach ($lastSync as $item) {
    $tableName = $item["tableName"];
    $lastSyncTime = $item["lastSyncTime"];

    $where .= " (table_name='$tableName' AND changed_at > '$lastSyncTime') OR";
}
$where = substr($where,0,strlen($where)-2);
$sql = "SELECT * FROM data_changes WHERE $where ORDER BY changed_at ASC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$changes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// แปลงข้อมูลให้เหมาะสม
$result = [];
foreach ($changes as $change) {
    $result[] = [
        'type' => $change['action'],
        'table' => $change['table_name'],
        'id' => $change['record_id'],
        'data' => json_decode($change['data_after'], true),
        'changed_at' => $change['changed_at']
    ];
}

echo json_encode($result);
?>