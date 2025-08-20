<?php
include 'config.php';

if (!isset($_GET['id'])) {
    header("Location: customers.php");
    exit();
}

$customer_id = $_GET['id'];
$customer = $conn->query("SELECT * FROM Customers WHERE customer_id = $customer_id")->fetch_assoc();

if (!$customer) {
    header("Location: customers.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    
    $sql = "UPDATE Customers SET 
            first_name = '$first_name',
            last_name = '$last_name', 
            email = '$email',
            phone = '$phone'
            WHERE customer_id = $customer_id";
    
    if ($conn->query($sql)) {
        header("Location: customers.php");
        exit();
    }
}

include 'header.php';
?>

<div class="main-content">
    <h2>Edit Customer</h2>
    
    <form method="POST">
        <div class="form-group">
            <label>First Name:</label>
            <input type="text" name="first_name" value="<?php echo $customer['first_name']; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Last Name:</label>
            <input type="text" name="last_name" value="<?php echo $customer['last_name']; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $customer['email']; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Phone:</label>
            <input type="text" name="phone" value="<?php echo $customer['phone']; ?>">
        </div>
        
        <button type="submit">Update Customer</button>
        <a href="customers.php">
            <button type="button" style="background: #6c757d; margin-left: 10px;">Cancel</button>
        </a>
    </form>
</div>

<?php include 'footer.php'; ?>