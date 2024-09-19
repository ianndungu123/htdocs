<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "savings_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accountId = $_POST['account-no'];
    $tillNo = $_POST['till-no'];
    $paybill = $_POST['paybill'];
    $amount = $_POST['amount'];
    $pin = $_POST['pin'];
    $validPin = '1234'; // Replace with actual PIN validation logic

    if ($pin === $validPin) {
        $sql = "UPDATE accounts SET balance = balance - ? WHERE account_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $amount, $accountId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Payment successful']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Payment failed']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid PIN']);
    }
}

$conn->close();
?>
