<?php
include 'db_connect.php';
$cat_items = [];
$result = $conn->query('SELECT id, name, status FROM cat_items');
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $cat_items[] = $row;
    }
}
echo json_encode(['data' => $cat_items]);
?>