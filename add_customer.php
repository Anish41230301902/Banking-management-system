<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date_of_birth = $_POST['date_of_birth'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip_code = $_POST['zip_code'];
    
    $sql = "INSERT INTO Customers (first_name, last_name, email, phone, date_of_birth, address, city, state, zip_code) 
            VALUES ('$first_name', '$last_name', '$email', '$phone', '$date_of_birth', '$address', '$city', '$state', '$zip_code')";
    
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Customer added successfully!";
        $_SESSION['message_type'] = "success";
        header("Location: customers.php");
        exit();
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
        $_SESSION['message_type'] = "error";
    }
}

include 'header.php';
?>

<div class="main-content">
    <h2>Add New Customer</h2>
    
    <form method="POST" action="">
        <div class="form-group">
            <label>First Name:</label>
            <input type="text" name="first_name" required>
        </div>
        
        <div class="form-group">
            <label>Last Name:</label>
            <input type="text" name="last_name" required>
        </div>
        
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label>Phone:</label>
            <input type="text" name="phone">
        </div>
        
        <div class="form-group">
            <label>Date of Birth:</label>
            <input type="date" name="date_of_birth" required>
        </div>
        
        <div class="form-group">
            <label>Address:</label>
            <input type="text" name="address">
        </div>
        
        <div class="form-group">
            <label>City:</label>
            <input type="text" name="city">
        </div>
        
        <div class="form-group">
            <label>State:</label>
            <input type="text" name="state">
        </div>
        
        <div class="form-group">
            <label>Zip Code:</label>
            <input type="text" name="zip_code">
        </div>
        
        <button type="submit">Add Customer</button>
    </form>
</div>

<?php include 'footer.php'; ?>