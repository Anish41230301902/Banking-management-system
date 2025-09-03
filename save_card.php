<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'];
    $account_id = $_POST['account_id'];
    $card_number = $_POST['card_number'];
    $card_type = $_POST['card_type'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];
    $daily_limit = $_POST['daily_limit'];
    $status = $_POST['status'];

    $sql = "INSERT INTO Cards (customer_id, account_id, card_number, card_type, expiry_date, cvv, daily_limit, status) 
            VALUES ($customer_id, $account_id, '$card_number', '$card_type', '$expiry_date', '$cvv', $daily_limit, '$status')";

    if ($conn->query($sql)) {
        header("Location: cards.php?message=Card added successfully");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>