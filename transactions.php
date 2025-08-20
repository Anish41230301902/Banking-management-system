<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $account_id = $_POST['account_id'];
    $transaction_type = $_POST['transaction_type'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $related_account_id = $_POST['related_account_id'] ?? null;
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Insert transaction record
        $sql = "INSERT INTO Transactions (account_id, transaction_type, amount, description, related_account_id) 
                VALUES ('$account_id', '$transaction_type', '$amount', '$description', " . 
                ($related_account_id ? "'$related_account_id'" : "NULL") . ")";
        
        if (!$conn->query($sql)) {
            throw new Exception("Error creating transaction: " . $conn->error);
        }
        
        // Update account balance
        if ($transaction_type == 'Deposit') {
            $update_sql = "UPDATE Accounts SET balance = balance + $amount WHERE account_id = $account_id";
        } else if ($transaction_type == 'Withdrawal') {
            $update_sql = "UPDATE Accounts SET balance = balance - $amount WHERE account_id = $account_id";
        } else if ($transaction_type == 'Transfer' && $related_account_id) {
            // Deduct from source account
            $update1_sql = "UPDATE Accounts SET balance = balance - $amount WHERE account_id = $account_id";
            // Add to destination account
            $update2_sql = "UPDATE Accounts SET balance = balance + $amount WHERE account_id = $related_account_id";
            
            if (!$conn->query($update1_sql) || !$conn->query($update2_sql)) {
                throw new Exception("Error updating account balances: " . $conn->error);
            }
        }
        
        if ($transaction_type != 'Transfer') {
            if (!$conn->query($update_sql)) {
                throw new Exception("Error updating account balance: " . $conn->error);
            }
        }
        
        $conn->commit();
        $_SESSION['message'] = "Transaction completed successfully!";
        $_SESSION['message_type'] = "success";
        header("Location: transactions.php");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['message'] = $e->getMessage();
        $_SESSION['message_type'] = "error";
    }
}

include 'header.php';

// Get accounts for dropdown
$accounts = $conn->query("SELECT account_id, account_number FROM Accounts WHERE status='Active'");
?>

<div class="main-content">
    <h2>Make Transaction</h2>
    
    <form method="POST" action="">
        <div class="form-group">
            <label>Account:</label>
            <select name="account_id" id="account_id" required>
                <option value="">Select Account</option>
                <?php while($account = $accounts->fetch_assoc()): ?>
                <option value="<?php echo $account['account_id']; ?>">
                    <?php echo $account['account_number']; ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Transaction Type:</label>
            <select name="transaction_type" id="transaction_type" required>
                <option value="Deposit">Deposit</option>
                <option value="Withdrawal">Withdrawal</option>
                <option value="Transfer">Transfer</option>
            </select>
        </div>
        
        <div class="form-group" id="related_account_group" style="display: none;">
            <label>Destination Account (for transfer):</label>
            <select name="related_account_id" id="related_account_id">
                <option value="">Select Destination Account</option>
                <?php 
                $accounts->data_seek(0); // Reset pointer
                while($account = $accounts->fetch_assoc()): ?>
                <option value="<?php echo $account['account_id']; ?>">
                    <?php echo $account['account_number']; ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Amount:</label>
            <input type="number" name="amount" step="0.01" required>
        </div>
        
        <div class="form-group">
            <label>Description:</label>
            <textarea name="description"></textarea>
        </div>
        
        <button type="submit">Process Transaction</button>
    </form>
</div>

<script>
document.getElementById('transaction_type').addEventListener('change', function() {
    var transferField = document.getElementById('related_account_group');
    if (this.value === 'Transfer') {
        transferField.style.display = 'block';
    } else {
        transferField.style.display = 'none';
    }
});
</script>

<?php include 'footer.php'; ?>