<?php
include 'config.php';
include 'header.php';
?>

<div class="main-content">
    <h2>Transactions</h2>
    <a href="make_transaction.php" style="float: right; margin-bottom: 20px;">
        <button>New Transaction</button>
    </a>
    
    <?php
    $transactions = $conn->query("
        SELECT t.*, a.account_number, c.first_name, c.last_name 
        FROM Transactions t 
        JOIN Accounts a ON t.account_id = a.account_id 
        JOIN Customers c ON a.customer_id = c.customer_id 
        ORDER BY t.transaction_date DESC
    ");
    
    if ($transactions->num_rows > 0): ?>
        <table>
            <tr>
                <th>Date</th>
                <th>Account</th>
                <th>Customer</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Status</th>
            </tr>
            <?php while($transaction = $transactions->fetch_assoc()): ?>
            <tr>
                <td><?php echo $transaction['transaction_date']; ?></td>
                <td><?php echo $transaction['account_number']; ?></td>
                <td><?php echo $transaction['first_name'] . ' ' . $transaction['last_name']; ?></td>
                <td><?php echo $transaction['transaction_type']; ?></td>
                <td>$<?php echo number_format($transaction['amount'], 2); ?></td>
                <td><?php echo $transaction['description']; ?></td>
                <td><?php echo $transaction['status']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No transactions found.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>