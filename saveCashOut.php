<?php
require_once "connection_db.php";

// Check for connection error
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data)) {

    $stmt = $db->prepare("INSERT INTO cash_out (job_no, description, date_cash_out, emp_id, amount) VALUES (?, ?, ?, ?, ?)");

    foreach ($data as $row) {
        $job_no = $row['job_no'];
        $description = $row['description'];
        $date_cash_out = $row['date_cash_out'];  // This should match the key from the frontend
        $emp_id = $row['emp_id'];  // Use emp_id instead of emp_name
        $amount = $row['amount'];

        // Bind parameters to prevent SQL injection
        $stmt->bind_param('sssid', $job_no, $description, $date_cash_out, $emp_id, $amount);
        $stmt->execute();
    }

    $stmt->close();
    $db->close();

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No data received']);
}
?>
