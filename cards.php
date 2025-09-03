<?php
include 'config.php';
include 'header.php';
?>

<div class="main-content">
    <h2>Cards Management</h2>
    <a href="add_card.php" style="float: right; margin-bottom: 20px;">
        <button>Add New Card</button>
    </a>
    
    <?php
    $cards = $conn->query("
        SELECT c.*, cust.first_name, cust.last_name, a.account_number
        FROM Cards c 
        JOIN Customers cust ON c.customer_id = cust.customer_id 
        JOIN Accounts a ON c.account_id = a.account_id
        ORDER BY c.card_id DESC
    ");
    
    if ($cards->num_rows > 0): ?>
        <table>
            <tr>
                <th>Card ID</th>
                <th>Customer</th>
                <th>Account</th>
                <th>Card Number</th>
                <th>Card Type</th>
                <th>Expiry Date</th>
                <th>Daily Limit</th>
                <th>Issue Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php while($card = $cards->fetch_assoc()): ?>
            <tr>
                <td><?php echo $card['card_id']; ?></td>
                <td><?php echo $card['first_name'] . ' ' . $card['last_name']; ?></td>
                <td><?php echo $card['account_number']; ?></td>
                <td><?php echo $card['card_number']; ?></td>
                <td><?php echo $card['card_type']; ?></td>
                <td><?php echo $card['expiry_date']; ?></td>
                <td>$<?php echo number_format($card['daily_limit'], 2); ?></td>
                <td><?php echo $card['issue_date']; ?></td>
                <td>
                    <span class="status-badge status-<?php echo strtolower($card['status']); ?>">
                        <?php echo $card['status']; ?>
                    </span>
                </td>
                <td>
                    <a href="edit_card.php?id=<?php echo $card['card_id']; ?>" class="action-btn">Edit</a>
                    <form action="delete_card.php" method="POST" style="display:inline;">
                        <input type="hidden" name="card_id" value="<?php echo $card['card_id']; ?>">
                        <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this card?')">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No cards found.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>