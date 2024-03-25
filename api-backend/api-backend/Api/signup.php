<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

require_once("connect.php"); 
session_start();

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'];
$email = $data['email'];
$password = $data['password'];

$stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result_check_email = $stmt->get_result();

if ($result_check_email->num_rows > 0) {
   http_response_code(409); // Conflict
    echo json_encode(array("status" => "failed", "message" => "Email already exists"));
    exit(); 
} else {
    // Email chưa tồn tại
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); 
    $stmt = $conn->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);
    
    if ($stmt->execute()) {
        // Chèn dữ liệu thành công
        echo json_encode(array("status" => "success", "message" => "User registered successfully"));
    } else {
        // Lỗi khi chèn dữ liệu
        echo json_encode(array("status" => "failed", "message" => "Failed to register user"));
    }
}

$conn->close();
?>


