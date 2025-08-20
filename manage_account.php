<?php
include 'config.php';
include 'header.php';

if (!isset($_GET['id'])) {
    header("Location: accounts.php");
    exit();
}

$account_id = $_GET['id'];
$account = $conn->query("SELECT a.*, c.first_name, c.last_name 
                        FROM Accounts a 
                        JOIN Customers c ON a.customer_id = c.customer_id 
                        WHERE a.account_id = $account_id")->fetch_assoc();

if (!$account) {
    header("Location: accounts.php");
    exit();
}

// Get account transactions
$transactions = $conn->query("SELECT * FROM Transactions 
                             WHERE account_id = $account_id 
                             ORDER BY transaction_date DESC 
                             LIMIT 10");
?>

<div class="main-content">
    <h2>Manage Account: <?php echo $account['account_number']; ?></h2>
    
    <div class="account-info">
        <h3>Account Information</h3>
        <p><strong>Customer:</strong> <?php echo $account['first_name'] . ' ' . $account['last_name']; ?></p>
        <p><strong>Type:</strong> <?php echo $account['account_type']; ?></p>
        <p><strong>Balance:</strong> $<?php echo number_format($account['balance'], 2); ?></p>
        <p><strong>Interest Rate:</strong> <?php echo $account['interest_rate']; ?>%</p>
        <p><strong>Status:</strong> <?php echo $account['status']; ?></p>
    </div>

    <h3>Recent Transactions</h3>
    <?php if ($transactions->num_rows > 0): ?>
        <table>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Status</th>
            </tr>
            <?php while($transaction = $transactions->fetch_assoc()): ?>
            <tr>
                <td><?php echo $transaction['transaction_date']; ?></td>
                <td><?php echo $transaction['transaction_type']; ?></td>
                <td>$<?php echo number_format($transaction['amount'], 2); ?></td>
                <td><?php echo $transaction['description']; ?></td>
                <td><?php echo $transaction['status']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No transactions found for this account.</p>
    <?php endif; ?>

    <div style="margin-top: 20px;">
        <a href="transactions.php?account_id=<?php echo $account_id; ?>">
            <button>Make Transaction</button>
        </a>
        <a href="accounts.php" style="margin-left: 10px;">
            <button style="background: #6c757d;">Back to Accounts</button>
        </a>
    </div>
</div>

<?php include 'footer.php'; ?>