<?php
include 'config.php';
include 'header.php';
?>

<div class="main-content">
    <h2>Accounts</h2>
    <a href="add_account.php" style="float: right; margin-bottom: 20px;">
        <button>Add New Account</button>
    </a>
    
    <?php
    $accounts = $conn->query("
        SELECT a.*, c.first_name, c.last_name 
        FROM Accounts a 
        JOIN Customers c ON a.customer_id = c.customer_id 
        ORDER BY a.account_id DESC
    ");
    
    if ($accounts->num_rows > 0): ?>
        <table>
            <tr>
                <th>Account Number</th>
                <th>Customer</th>
                <th>Type</th>
                <th>Balance</th>
                <th>Interest Rate</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php while($account = $accounts->fetch_assoc()): ?>
            <tr>
                <td><?php echo $account['account_number']; ?></td>
                <td><?php echo $account['first_name'] . ' ' . $account['last_name']; ?></td>
                <td><?php echo $account['account_type']; ?></td>
                <td>$<?php echo number_format($account['balance'], 2); ?></td>
                <td><?php echo $account['interest_rate']; ?>%</td>
                <td><?php echo $account['status']; ?></td>
                <td>
                    <a href="manage_account.php?id=<?php echo $account['account_id']; ?>">Manage</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No accounts found.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>