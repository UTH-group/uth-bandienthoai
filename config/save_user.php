<?php
require_once("./connect.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Phương thức yêu cầu không hợp lệ']);
    exit;
}

if (!isset($_COOKIE['username'])) {
    echo json_encode(['success' => false, 'error' => 'Vui lòng đăng nhập để thực hiện thao tác này']);
    exit;
}

$username = $_COOKIE['username'];
$fname = $_POST['fName'] ?? null;
$lname = $_POST['lName'] ?? null;
$phone = $_POST['phone'] ?? null;
$email = $_POST['email'] ?? null;
$gender = $_POST['gender'] ?? null;
$birthday = $_POST['birthday'] ?? null;
$pob_id = $_POST['pob'] ?? null;
$oldPassword = $_POST['oldPassword'] ?? null;
$newPassword = $_POST['newPassword'] ?? null;

// Validate required fields
if (!$fname || !$lname || !$phone || !$email || !$gender || !$birthday || !$pob_id) {
    echo json_encode(['success' => false, 'error' => 'Vui lòng điền đầy đủ thông tin']);
    exit;
}

try {
    // Get user_id
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    if (!$stmt) {
        throw new Exception("Database error: " . $conn->error);
    }
    
    $stmt->bind_param("s", $username);
    if (!$stmt->execute()) {
        throw new Exception("Error executing query: " . $stmt->error);
    }
    
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("Không tìm thấy thông tin người dùng");
    }
    
    $user = $result->fetch_assoc();
    $user_id = $user['user_id'];
    $stmt->close();

    // Start transaction
    $conn->begin_transaction();

    // Update user information
    $stmt = $conn->prepare("UPDATE users 
        SET first_name = ?, last_name = ?, phone = ?, email = ?, gender = ?, birthday = ?, pob = ? 
        WHERE user_id = ?");
    if (!$stmt) {
        throw new Exception("Database error: " . $conn->error);
    }
    
    $stmt->bind_param("ssssssii", $fname, $lname, $phone, $email, $gender, $birthday, $pob_id, $user_id);
    if (!$stmt->execute()) {
        throw new Exception("Không thể cập nhật thông tin người dùng: " . $stmt->error);
    }
    $stmt->close();

    // Update password if requested
    if ($oldPassword && $newPassword) {
        $stmt = $conn->prepare("SELECT password_hash FROM users WHERE user_id = ?");
        if (!$stmt) {
            throw new Exception("Database error: " . $conn->error);
        }
        
        $stmt->bind_param("i", $user_id);
        if (!$stmt->execute()) {
            throw new Exception("Error verifying password: " . $stmt->error);
        }
        
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $hashedPassword = $user['password_hash'];
        $stmt->close();

        if (!password_verify($oldPassword, $hashedPassword)) {
            throw new Exception("Mật khẩu cũ không chính xác");
        }

        $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE user_id = ?");
        if (!$stmt) {
            throw new Exception("Database error: " . $conn->error);
        }
        
        $stmt->bind_param("si", $newHashedPassword, $user_id);
        if (!$stmt->execute()) {
            throw new Exception("Không thể cập nhật mật khẩu: " . $stmt->error);
        }
        $stmt->close();
    }

    // Commit transaction
    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Cập nhật thông tin thành công']);

} catch (Exception $e) {
    if ($conn->connect_error) {
        error_log("Database connection failed: " . $conn->connect_error);
    }
    
    if (isset($conn) && $conn->errno) {
        error_log("Database error: " . $conn->error);
    }
    
    error_log("Error in save_user.php: " . $e->getMessage());
    
    if ($conn) {
        $conn->rollback();
    }
    
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>
