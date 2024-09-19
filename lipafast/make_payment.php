<?php
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
    $tillNo = $_POST['till-no'];
    $accountNo = $_POST['account-no'];
    $paybill = $_POST['paybill'];
    $amount = $_POST['amount'];
    $pin = $_POST['pin'];

    // Check PIN validity
    $stmt = $conn->prepare("SELECT id FROM users WHERE pin = ?");
    $stmt->bind_param("s", $pin);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userId = $result->fetch_assoc()['id'];

        // Deduct amount from user's balance
        $stmt = $conn->prepare("UPDATE accounts SET balance = balance - ? WHERE user_id = ?");
        $stmt->bind_param("di", $amount, $userId);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Payment made successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to make payment.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid PIN.']);
    }

    $stmt->close();
}

$conn->close();
?>
