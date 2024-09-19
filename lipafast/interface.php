<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "innterface";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accountId = $_POST['account-id'];
    $pin = $_POST['pin'];

    // Validate the PIN (for simplicity, assuming a single PIN for all accounts)
    $validPin = '1234'; // Replace with actual PIN validation logic

    if ($pin === $validPin) {
        $sql = "SELECT balance FROM accounts WHERE account_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $accountId);
        $stmt->execute();
        $stmt->bind_result($balance);
        $stmt->fetch();

        if ($balance !== null) {
            echo json_encode(['success' => true, 'balance' => $balance]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Account not found']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid PIN']);
    }
}

$conn->close();
?>
