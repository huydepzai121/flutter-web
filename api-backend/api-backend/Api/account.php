<?php

include_once("connect.php");

// Collect POST data
$email = $_POST['email'] ?? '';
$username = $_POST['username'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';

// Prepare and bind
$stmt = $conn->prepare("SELECT * FROM user WHERE email = ? AND username = ? AND phone = ? AND address = ?");
$stmt->bind_param("ssss", $email, $username, $phone, $address);

// Execute and collect results
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response = ['status' => 'success', 'data' => $row];
    } else {
        $response = ['status' => 'failed', 'message' => 'No matching user found.'];
    }
} else {
    $response = ['status' => 'error', 'message' => 'Query failed to execute.'];
}

sendJsonResponse($response);

// Close connections
$stmt->close();
$conn->close();

// Send JSON Response Function
function sendJsonResponse($sentArray)
{
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    echo json_encode($sentArray);
}

?>
