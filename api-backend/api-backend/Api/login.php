<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

require_once("connect.php");
session_start();

// Lấy dữ liệu POST thô từ dòng nhập
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

// Làm sạch và xác thực đầu vào cho email và mật khẩu.
$email = filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL);
$password = $data['password'] ?? ''; // Giả định bạn sẽ băm và xác minh, không cần làm sạch.

// Kiểm tra các trường trống sau khi làm sạch.
if (empty($email) || empty($password)) {
    sendJsonResponse(array('status' => 'failed', 'message' => 'Missing email or password.'));
    exit();
}

// Sử dụng câu lệnh chuẩn bị để tránh SQL Injection.
$stmt = $conn->prepare("SELECT id, username, password FROM user WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    sendJsonResponse(array('status' => 'failed', 'message' => 'User not found.'));
} else {
    $row = $result->fetch_assoc();

    // Xác minh mật khẩu.
    if (password_verify($password, $row['password'])) {
        // Đăng nhập thành công, lưu trữ thông tin người dùng trong phiên làm việc.
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $email;

        sendJsonResponse(array('status' => 'success', 'message' => 'Login successful.'));
    } else {
        sendJsonResponse(array('status' => 'failed', 'message' => 'Incorrect password.'));
    }
}

$stmt->close();
$conn->close();

// Hàm tiện ích để gửi phản hồi JSON.
function sendJsonResponse($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit();
}
?>
