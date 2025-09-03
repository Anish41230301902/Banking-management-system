<?php
include 'config.php';
include 'header.php';
?>

<div class="main-content">
    <h2>Loans Management</h2>
    <a href="add_loan.php" style="float: right; margin-bottom: 20px;">
        <button>Add New Loan</button>
    </a>
    
    <?php
    $loans = $conn->query("
        SELECT l.*, c.first_name, c.last_name, a.account_number
        FROM Loans l 
        JOIN Customers c ON l.customer_id = c.customer_id 
        JOIN Accounts a ON l.account_id = a.account_id
        ORDER BY l.loan_id DESC
    ");
    
    if ($loans->num_rows > 0): ?>
        <table>
            <tr>
                <th>Loan ID</th>
                <th>Customer</th>
                <th>Account</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Interest Rate</th>
                <th>Term</th>
                <th>Monthly Payment</th>
                <th>Remaining Balance</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php while($loan = $loans->fetch_assoc()): ?>
            <tr>
                <td><?php echo $loan['loan_id']; ?></td>
                <td><?php echo $loan['first_name'] . ' ' . $loan['last_name']; ?></td>
                <td><?php echo $loan['account_number']; ?></td>
                <td><?php echo $loan['loan_type']; ?></td>
                <td>$<?php echo number_format($loan['loan_amount'], 2); ?></td>
                <td><?php echo $loan['interest_rate']; ?>%</td>
                <td><?php echo $loan['term_months']; ?> months</td>
                <td>$<?php echo number_format($loan['monthly_payment'], 2); ?></td>
                <td>$<?php echo number_format($loan['remaining_balance'], 2); ?></td>
                <td>
                    <span class="status-badge status-<?php echo strtolower($loan['status']); ?>">
                        <?php echo $loan['status']; ?>
                    </span>
                </td>
                <td>
                    <a href="edit_loan.php?id=<?php echo $loan['loan_id']; ?>" class="action-btn">Edit</a>
                    <form action="delete_loan.php" method="POST" style="display:inline;">
                        <input type="hidden" name="loan_id" value="<?php echo $loan['loan_id']; ?>">
                        <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this loan?')">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No loans found.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>