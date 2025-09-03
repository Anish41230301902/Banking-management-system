<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'];
    $account_id = $_POST['account_id'];
    $loan_type = $_POST['loan_type'];
    $loan_amount = $_POST['loan_amount'];
    $interest_rate = $_POST['interest_rate'];
    $term_months = $_POST['term_months'];
    $start_date = $_POST['start_date'];
    $monthly_payment = $_POST['monthly_payment'];

    // Calculate end date
    $end_date = date('Y-m-d', strtotime($start_date . " + $term_months months"));

    $sql = "INSERT INTO Loans (customer_id, account_id, loan_type, loan_amount, interest_rate, term_months, start_date, end_date, monthly_payment, remaining_balance, status) 
            VALUES ($customer_id, $account_id, '$loan_type', $loan_amount, $interest_rate, $term_months, '$start_date', '$end_date', $monthly_payment, $loan_amount, 'Active')";

    if ($conn->query($sql)) {
        header("Location: loan.php?message=Loan added successfully");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>