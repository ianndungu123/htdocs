<?php
// Database configuration
$host = 'localhost';
$db = 'savings';
$user = 'root';
$pass = '';

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = array();
$response['success'] = false;

// Check if account ID is provided
if (isset($_POST['account-id'])) {
    $accountId = $conn->real_escape_string($_POST['account-id']);

    // Query to get the balance
    $sql = "SELECT balance FROM accounts WHERE account_id = '$accountId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response['success'] = true;
        $response['balance'] = $row['balance'];
    }
}

$conn->close();

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);
