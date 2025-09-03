<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $card_id = $_POST['card_id'];
    
    $sql = "DELETE FROM Cards WHERE card_id = $card_id";
    
    if ($conn->query($sql)) {
        header("Location: cards.php?message=Card deleted successfully");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>