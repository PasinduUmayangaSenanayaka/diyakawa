<?php


include 'connection_db.php'; // Include your database connection file

if (isset($_GET['date'])) {
    $date = $_GET['date'];

    // Query to get the data from the currency_value table
    $query = "SELECT currency_value.id, currency_value.currency, currency_value.exchange_rate, currency_value.amount, currency.currencyName FROM currency_value JOIN currency ON currency.id = currency_value.currency WHERE currency_value.date = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('s', $date); // 's' for string type (date)
    $stmt->execute();
    $result = $stmt->get_result();

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data); // Return the data as JSON
}
?>
