<?php
include_once("connect.php");

// Hàm thực hiện cập nhật cơ sở dữ liệu
function databaseUpdate($conn, $stmt) {
    if ($stmt->execute()) {
        $response = array('status' => 'success', 'data' => null);
    } else {
        $response = array('status' => 'failed', 'message' => $stmt->error);
    }
    sendJsonResponse($response);
}

// Hàm gửi phản hồi JSON
function sendJsonResponse($sentArray) {
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}

// Kiểm tra nếu có POST data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['phone'], $_POST['id'])) {
        $phone = $_POST['phone'];
        $id = $_POST['id'];
        $stmt = $conn->prepare("UPDATE user SET phone = ? WHERE id = ?");
        $stmt->bind_param("si", $phone, $id);
        databaseUpdate($conn, $stmt);
        $stmt->close();
    } 
     if (isset($_POST['username'], $_POST['id'])) {
        $phone = $_POST['username'];
        $id = $_POST['id'];
        $stmt = $conn->prepare("UPDATE user SET username = ? WHERE id = ?");
        $stmt->bind_param("si", $username, $id);
        databaseUpdate($conn, $stmt);
        $stmt->close();
    } 

     if (isset($_POST['address'], $_POST['id'])) {
        $phone = $_POST['address'];
        $id = $_POST['id'];
        $stmt = $conn->prepare("UPDATE user SET address = ? WHERE id = ?");
        $stmt->bind_param("si", $address, $id);
        databaseUpdate($conn, $stmt);
        $stmt->close();
    } 
       if (isset($_POST['email'], $_POST['id'])) {
        $phone = $_POST['email'];
        $id = $_POST['id'];
        $stmt = $conn->prepare("UPDATE user SET email = ? WHERE id = ?");
        $stmt->bind_param("si", $email, $id);
        databaseUpdate($conn, $stmt);
        $stmt->close();
    } 
    if (isset($_POST['password'], $_POST['id'])) {
        $phone = $_POST['password'];
        $id = $_POST['id'];
        $stmt = $conn->prepare("UPDATE user SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $password, $id);
        databaseUpdate($conn, $stmt);
        $stmt->close();
    } 


    // Tương tự với các trường khác như password, username, và address
    // ...

    $conn->close();
}


 else {
    $response = array('status' => 'failed', 'message' => 'No POST data received');
    sendJsonResponse($response);
}

?>