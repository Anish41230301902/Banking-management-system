<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = $_POST['customer_id'];
    $account_number = $_POST['account_number'];
    $account_type = $_POST['account_type'];
    $balance = $_POST['balance'];
    $interest_rate = $_POST['interest_rate'];
    $minimum_balance = $_POST['minimum_balance'];
    
    $sql = "INSERT INTO Accounts (customer_id, account_number, account_type, balance, interest_rate, minimum_balance) 
            VALUES ('$customer_id', '$account_number', '$account_type', '$balance', '$interest_rate', '$minimum_balance')";
    
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Account created successfully!";
        $_SESSION['message_type'] = "success";
        header("Location: accounts.php");
        exit();
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
        $_SESSION['message_type'] = "error";
    }
}

include 'header.php';

// Get customers for dropdown
$customers = $conn->query("SELECT customer_id, first_name, last_name FROM Customers WHERE status='Active'");
?>

<div class="main-content">
    <h2>Create New Account</h2>
    
    <form method="POST" action="">
        <div class="form-group">
            <label>Customer:</label>
            <select name="customer_id" required>
                <option value="">Select Customer</option>
                <?php while($customer = $customers->fetch_assoc()): ?>
                <option value="<?php echo $customer['customer_id']; ?>">
                    <?php echo $customer['first_name'] . ' ' . $customer['last_name']; ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Account Number:</label>
            <input type="text" name="account_number" required>
        </div>
        
        <div class="form-group">
            <label>Account Type:</label>
            <select name="account_type" required>
                <option value="Savings">Savings</option>
                <option value="Checking">Checking</option>
                <option value="Fixed Deposit">Fixed Deposit</option>
                <option value="Business">Business</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Initial Balance:</label>
            <input type="number" name="balance" step="0.01" required>
        </div>
        
        <div class="form-group">
            <label>Interest Rate (%):</label>
            <input type="number" name="interest_rate" step="0.001" required>
        </div>
        
        <div class="form-group">
            <label>Minimum Balance:</label>
            <input type="number" name="minimum_balance" step="0.01" required>
        </div>
        
        <button type="submit">Create Account</button>
    </form>
</div>

<?php include 'footer.php'; ?>