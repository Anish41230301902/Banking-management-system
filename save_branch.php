<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $branch_code = $_POST['branch_code'];
    $branch_name = $_POST['branch_name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip_code = $_POST['zip_code'];
    $phone = $_POST['phone'];
    $manager_id = !empty($_POST['manager_id']) ? $_POST['manager_id'] : 'NULL';
    $opening_date = $_POST['opening_date'];
    $status = $_POST['status'];

    $sql = "INSERT INTO Branches (branch_code, branch_name, address, city, state, zip_code, phone, manager_id, opening_date, status) 
            VALUES ('$branch_code', '$branch_name', '$address', '$city', '$state', '$zip_code', '$phone', $manager_id, '$opening_date', '$status')";

    if ($conn->query($sql)) {
        header("Location: branches.php?message=Branch added successfully");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>