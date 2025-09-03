<?php
include('config.php');

// Check if card ID is provided
if (!isset($_GET['id'])) {
    header("Location: cards.php");
    exit();
}

$card_id = $_GET['id'];

// Get card data
$card = $conn->query("SELECT * FROM Cards WHERE card_id = $card_id")->fetch_assoc();

if (!$card) {
    header("Location: cards.php");
    exit();
}

$customers = $conn->query("SELECT customer_id, first_name, last_name FROM Customers WHERE status='Active'");
$accounts = $conn->query("SELECT account_id, account_number FROM Accounts WHERE status='Active'");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'];
    $account_id = $_POST['account_id'];
    $card_number = $_POST['card_number'];
    $card_type = $_POST['card_type'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];
    $daily_limit = $_POST['daily_limit'];
    $status = $_POST['status'];

    $sql = "UPDATE Cards SET 
            customer_id = $customer_id,
            account_id = $account_id,
            card_number = '$card_number',
            card_type = '$card_type',
            expiry_date = '$expiry_date',
            cvv = '$cvv',
            daily_limit = $daily_limit,
            status = '$status'
            WHERE card_id = $card_id";

    if ($conn->query($sql)) {
        header("Location: cards.php?message=Card updated successfully");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}

include('header.php');
?>

<div class="main-content">
    <h2>Edit Card</h2>
    
    <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="" style="max-width: 600px;">
        <div class="form-group">
            <label>Customer:</label>
            <select name="customer_id" required>
                <option value="">Select Customer</option>
                <?php while($customer = $customers->fetch_assoc()): ?>
                <option value="<?php echo $customer['customer_id']; ?>" 
                    <?php echo $card['customer_id'] == $customer['customer_id'] ? 'selected' : ''; ?>>
                    <?php echo $customer['first_name'] . ' ' . $customer['last_name']; ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Account:</label>
            <select name="account_id" required>
                <option value="">Select Account</option>
                <?php while($account = $accounts->fetch_assoc()): ?>
                <option value="<?php echo $account['account_id']; ?>" 
                    <?php echo $card['account_id'] == $account['account_id'] ? 'selected' : ''; ?>>
                    <?php echo $account['account_number']; ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Card Number:</label>
            <input type="text" name="card_number" value="<?php echo $card['card_number']; ?>" pattern="[0-9]{16}" required>
        </div>
        
        <div class="form-group">
            <label>Card Type:</label>
            <select name="card_type" required>
                <option value="Debit" <?php echo $card['card_type'] == 'Debit' ? 'selected' : ''; ?>>Debit Card</option>
                <option value="Credit" <?php echo $card['card_type'] == 'Credit' ? 'selected' : ''; ?>>Credit Card</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Expiry Date:</label>
            <input type="date" name="expiry_date" value="<?php echo $card['expiry_date']; ?>" required>
        </div>
        
        <div class="form-group">
            <label>CVV:</label>
            <input type="text" name="cvv" value="<?php echo $card['cvv']; ?>" pattern="[0-9]{3}" required>
        </div>
        
        <div class="form-group">
            <label>Daily Limit:</label>
            <input type="number" step="0.01" name="daily_limit" value="<?php echo $card['daily_limit']; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Status:</label>
            <select name="status" required>
                <option value="Active" <?php echo $card['status'] == 'Active' ? 'selected' : ''; ?>>Active</option>
                <option value="Blocked" <?php echo $card['status'] == 'Blocked' ? 'selected' : ''; ?>>Blocked</option>
                <option value="Expired" <?php echo $card['status'] == 'Expired' ? 'selected' : ''; ?>>Expired</option>
                <option value="Lost" <?php echo $card['status'] == 'Lost' ? 'selected' : ''; ?>>Lost</option>
            </select>
        </div>
        
        <button type="submit">Update Card</button>
        <a href="cards.php">
            <button type="button" style="background: #6c757d; margin-left: 10px;">Cancel</button>
        </a>
    </form>
</div>

<?php include('footer.php'); ?>