<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loan_id = $_POST['loan_id'];
    
    $sql = "DELETE FROM Loans WHERE loan_id = $loan_id";
    
    if ($conn->query($sql)) {
        header("Location: loan.php?message=Loan deleted successfully");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>