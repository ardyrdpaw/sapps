<?php
include 'db_connect.php';
session_start();
$action = $_GET['action'] ?? '';
header('Content-Type: application/json');

// simple admin check
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
// protect write operations
if (in_array($action, ['add','edit','delete']) && !$isAdmin) {
    http_response_code(403);
    echo json_encode(['error' => 'Forbidden']);
    exit;
}

switch ($action) {
    case 'list':
        $rows = [];
        $res = $conn->query("SELECT id, menu_key, label, sort_order FROM menus ORDER BY sort_order ASC, label ASC");
        if ($res) {
            while ($r = $res->fetch_assoc()) $rows[] = $r;
        }
        echo json_encode(['data' => $rows]);
        break;
    case 'add':
        $key = $conn->real_escape_string($_POST['menu_key'] ?? '');
        $label = $conn->real_escape_string($_POST['label'] ?? '');
        $sort = intval($_POST['sort_order'] ?? 0);
        if (!$key || !$label) { echo json_encode(['error' => 'Invalid input']); break; }
        $stmt = $conn->prepare("INSERT INTO menus (menu_key, label, sort_order) VALUES (?, ?, ?)");
        $stmt->bind_param('ssi', $key, $label, $sort);
        if ($stmt->execute()) echo json_encode(['success' => true]); else echo json_encode(['error' => $conn->error]);
        break;
    case 'edit':
        $id = intval($_POST['id'] ?? 0);
        $label = $conn->real_escape_string($_POST['label'] ?? '');
        $sort = intval($_POST['sort_order'] ?? 0);
        if ($id <= 0 || !$label) { echo json_encode(['error' => 'Invalid input']); break; }
        $stmt = $conn->prepare("UPDATE menus SET label=?, sort_order=? WHERE id=?");
        $stmt->bind_param('sii', $label, $sort, $id);
        if ($stmt->execute()) echo json_encode(['success' => true]); else echo json_encode(['error' => $conn->error]);
        break;
    case 'delete':
        $id = intval($_POST['id'] ?? 0);
        if ($id <= 0) { echo json_encode(['error' => 'Invalid id']); break; }
        // Optionally remove related user_access rows that reference menu_key
        // We'll fetch the menu_key first to clean access
        $res = $conn->query("SELECT menu_key FROM menus WHERE id=".intval($id));
        $menu_key = null;
        if ($res && $row = $res->fetch_assoc()) $menu_key = $row['menu_key'];
        $stmt = $conn->prepare("DELETE FROM menus WHERE id=?");
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            if ($menu_key) $conn->query("DELETE FROM user_access WHERE menu_key='".$conn->real_escape_string($menu_key)."'");
            echo json_encode(['success' => true]);
        } else echo json_encode(['error' => $conn->error]);
        break;
    default:
        echo json_encode(['error' => 'Invalid action']);
}
