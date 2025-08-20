<?php
include 'config.php';
include 'header.php';

// Get counts for dashboard
$customer_count = $conn->query("SELECT COUNT(*) as count FROM Customers")->fetch_assoc()['count'];
$account_count = $conn->query("SELECT COUNT(*) as count FROM Accounts")->fetch_assoc()['count'];
$transaction_count = $conn->query("SELECT COUNT(*) as count FROM Transactions")->fetch_assoc()['count'];
$total_balance = $conn->query("SELECT SUM(balance) as total FROM Accounts")->fetch_assoc()['total'];
?>

<div class="main-content">
    <h2>Dashboard</h2>
    
    <div class="dashboard-cards">
        <div class="card">
            <h3>Total Customers</h3>
            <p><?php echo $customer_count; ?></p>
        </div>
        <div class="card">
            <h3>Total Accounts</h3>
            <p><?php echo $account_count; ?></p>
        </div>
        <div class="card">
            <h3>Total Transactions</h3>
            <p><?php echo $transaction_count; ?></p>
        </div>
        <div class="card">
            <h3>Total Balance</h3>
            <p>$<?php echo number_format($total_balance, 2); ?></p>
        </div>
    </div>

    <h3>Recent Transactions</h3>
    <?php
    $recent_transactions = $conn->query("
        SELECT t.*, a.account_number, c.first_name, c.last_name 
        FROM Transactions t 
        JOIN Accounts a ON t.account_id = a.account_id 
        JOIN Customers c ON a.customer_id = c.customer_id 
        ORDER BY t.transaction_date DESC 
        LIMIT 5
    ");
    
    if ($recent_transactions->num_rows > 0): ?>
        <table>
            <tr>
                <th>Date</th>
                <th>Account</th>
                <th>Customer</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
            <?php while($transaction = $recent_transactions->fetch_assoc()): ?>
            <tr>
                <td><?php echo $transaction['transaction_date']; ?></td>
                <td><?php echo $transaction['account_number']; ?></td>
                <td><?php echo $transaction['first_name'] . ' ' . $transaction['last_name']; ?></td>
                <td><?php echo $transaction['transaction_type']; ?></td>
                <td>$<?php echo number_format($transaction['amount'], 2); ?></td>
                <td><?php echo $transaction['status']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No transactions found.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>