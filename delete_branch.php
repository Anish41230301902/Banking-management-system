<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $branch_id = $_POST['branch_id'];
    
    $sql = "DELETE FROM Branches WHERE branch_id = $branch_id";
    
    if ($conn->query($sql)) {
        header("Location: branches.php?message=Branch deleted successfully");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>