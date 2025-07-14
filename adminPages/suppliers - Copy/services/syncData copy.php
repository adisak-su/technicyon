<?php
require_once("../../../service/connect.php");
header('Content-Type: application/json');
$DB = new Database();
$conn = $DB->connect();
// $conn->beginTransaction();

// $lastSync = $_POST['lastSyncRecord'] ?? '1970-01-01 00:00:00';
$lastSync = $_POST['lastSyncRecord'] ?? [];
// $stmt = $conn->prepare("
//     SELECT * FROM data_changes 
//     WHERE changed_at > :last_sync 
//     ORDER BY changed_at ASC
// ");
// $stmt->execute([
//     ':last_sync' => $lastSync,
// ]);


// $userId = $_GET['user_id']; // จาก session หรือ token

// ดึงการเปลี่ยนแปลงที่เกี่ยวข้องกับผู้ใช้
// $stmt = $pdo->prepare("
//     SELECT * FROM data_changes 
//     WHERE changed_at > :last_sync 
//     AND (changed_by != :user_id OR action = 'DELETE')
//     ORDER BY changed_at ASC
// ");
// $stmt->execute([
//     ':last_sync' => $lastSync,
//     ':user_id' => $userId
// ]);

$lastSync = $_POST['lastSyncRecord'];


$table_name = "suppliers";
$last_sync = '1970-01-01 00:00:00';
$where = "";
foreach ($lastSync as $item) {
    $tableName = $item["tableName"];
    $lastSyncTime = $item["lastSyncTime"];

    $where .= " (table_name='$tableName' AND changed_at > '$lastSyncTime') OR";
}
$where = substr($where,0,strlen($where)-2);
// $sql = "SELECT * FROM data_changes WHERE table_name=:table_name AND changed_at > :last_sync  ORDER BY changed_at ASC";

$sql = "SELECT * FROM data_changes WHERE $where ORDER BY changed_at ASC";

// $stmt = $conn->prepare("
//     SELECT * FROM data_changes 
//     WHERE changed_at > :last_sync 
//     ORDER BY changed_at ASC
// ");
$stmt = $conn->prepare($sql);
// $stmt->execute([
//     ':table_name' => $table_name,
//     ':last_sync' => $last_sync,
// ]);
$stmt->execute();

$changes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// แปลงข้อมูลให้เหมาะสม
$result = [];
// foreach ($changes as $change) {
//     $result[] = [
//         'type' => $change['action'],
//         'table' => $change['table_name'],
//         'id' => $change['record_id'],
//         'data' => ($change['action'] === 'DELETE') 
//             ? json_decode($change['data_before'], true) 
//             : json_decode($change['data_after'], true),
//         'changed_at' => $change['changed_at']
//     ];
// }

foreach ($changes as $change) {
    $result[] = [
        'type' => $change['action'],
        'table' => $change['table_name'],
        'id' => $change['record_id'],
        'data' => json_decode($change['data_after'], true),
        'changed_at' => $change['changed_at']
    ];
}

// echo json_encode(['changes' => $result]);
echo json_encode($result);
// echo json_encode($lastSync);
?>