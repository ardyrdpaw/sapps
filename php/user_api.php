<?php
include 'db_connect.php';
$action = $_GET['action'] ?? '';
header('Content-Type: application/json');

switch ($action) {
    case 'list':
        $users = [];
        $result = $conn->query('SELECT id, name, email, role FROM users');
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        echo json_encode(['data' => $users]);
        break;
    case 'get':
        $id = intval($_GET['id'] ?? 0);
        $result = $conn->query("SELECT id, name, email, role FROM users WHERE id=$id");
        $user = $result ? $result->fetch_assoc() : null;
        echo json_encode(['data' => $user]);
        break;
    case 'add':
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);
        $role = $conn->real_escape_string($_POST['role']);
        $conn->query("INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')");
        echo json_encode(['success' => true]);
        break;
    case 'edit':
        $id = intval($_POST['id']);
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $role = $conn->real_escape_string($_POST['role']);
        $set = "name='$name', email='$email', role='$role'";
        if (!empty($_POST['password'])) {
            $password = $conn->real_escape_string($_POST['password']);
            $set .= ", password='$password'";
        }
        $conn->query("UPDATE users SET $set WHERE id=$id");
        echo json_encode(['success' => true]);
        break;
    case 'delete':
        $id = intval($_POST['id']);
        $conn->query("DELETE FROM users WHERE id=$id");
        echo json_encode(['success' => true]);
        break;
    default:
        echo json_encode(['error' => 'Invalid action']);
}
?>