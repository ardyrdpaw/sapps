<?php
include 'db_connect.php';
session_start();
$action = $_GET['action'] ?? '';
header('Content-Type: application/json');

$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

switch ($action) {
    case 'list':
        // only admins can list all users
        if (!$isAdmin) { http_response_code(403); echo json_encode(['error' => 'Forbidden']); break; }
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
        // allow admin or the user themselves
        if (!$isAdmin && (!isset($_SESSION['user_id']) || intval($_SESSION['user_id']) !== $id)) {
            http_response_code(403); echo json_encode(['error' => 'Forbidden']); break;
        }
        $result = $conn->query("SELECT id, name, email, role FROM users WHERE id=$id");
        $user = $result ? $result->fetch_assoc() : null;
        echo json_encode(['data' => $user]);
        break;
    case 'add':
        if (!$isAdmin) { http_response_code(403); echo json_encode(['error' => 'Forbidden']); break; }
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);
        $role = $conn->real_escape_string($_POST['role']);
        $conn->query("INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')");
        echo json_encode(['success' => true]);
        break;
    case 'edit':
        $id = intval($_POST['id']);
        // only admin or the user themselves can edit (users can edit their own name/email/password but not role)
        if (!$isAdmin && (!isset($_SESSION['user_id']) || intval($_SESSION['user_id']) !== $id)) { http_response_code(403); echo json_encode(['error' => 'Forbidden']); break; }
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $set = "name='$name', email='$email'";
        if ($isAdmin) {
            $role = $conn->real_escape_string($_POST['role']);
            $set .= ", role='$role'";
        }
        if (!empty($_POST['password'])) {
            $password = $conn->real_escape_string($_POST['password']);
            $set .= ", password='$password'";
        }
        $conn->query("UPDATE users SET $set WHERE id=$id");
        echo json_encode(['success' => true]);
        break;
    case 'delete':
        if (!$isAdmin) { http_response_code(403); echo json_encode(['error' => 'Forbidden']); break; }
        $id = intval($_POST['id']);
        $conn->query("DELETE FROM users WHERE id=$id");
        echo json_encode(['success' => true]);
        break;
    default:
        echo json_encode(['error' => 'Invalid action']);
}
?>