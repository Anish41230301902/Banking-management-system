<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $position = $_POST['position'];
    $department = $_POST['department'];
    $salary = $_POST['salary'];
    $manager_id = !empty($_POST['manager_id']) ? $_POST['manager_id'] : 'NULL';

    $sql = "INSERT INTO Employees (first_name, last_name, email, phone, position, department, salary, manager_id) 
            VALUES ('$first_name', '$last_name', '$email', '$phone', '$position', '$department', $salary, $manager_id)";

    if ($conn->query($sql)) {
        header("Location: employee.php?message=Employee added successfully");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>