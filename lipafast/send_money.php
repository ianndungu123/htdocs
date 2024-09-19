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
    $recipientId = $_POST['recipient-id'];
    $amount = $_POST['amount'];
    $pin = $_POST['pin'];

    // Validate input
    if (empty($recipientId) || empty($amount) || empty($pin)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit();
    }

    // Check PIN validity
    $stmt = $conn->prepare("SELECT id FROM users WHERE pin = ?");
    $stmt->bind_param("s", $pin);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userId = $result->fetch_assoc()['id'];

        // Deduct amount from sender's balance
        $stmt = $conn->prepare("UPDATE accounts SET balance = balance - ? WHERE user_id = ?");
        $stmt->bind_param("di", $amount, $userId);
        if ($stmt->execute()) {
            // Add amount to recipient's balance
            $stmt = $conn->prepare("UPDATE accounts SET balance = balance + ? WHERE account_id = ?");
            $stmt->bind_param("ds", $amount, $recipientId);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Money sent successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to send money.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to deduct amount from sender\'s account.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid PIN.']);
    }

    $stmt->close();
}

$conn->close();
?>
