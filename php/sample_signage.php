<?php
include 'db_connect.php';
$signage_items = [];
$result = $conn->query('SELECT id, location, message FROM signage_items');
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $signage_items[] = $row;
    }
}
echo json_encode(['data' => $signage_items]);
?>