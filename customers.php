<?php
include 'config.php';
include 'header.php';
?>

<div class="main-content">
    <h2>Customers</h2>
    <a href="add_customer.php" style="float: right; margin-bottom: 20px;">
        <button>Add New Customer</button>
    </a>
    
    <?php
    $customers = $conn->query("SELECT * FROM Customers ORDER BY customer_id DESC");
    
    if ($customers->num_rows > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php while($customer = $customers->fetch_assoc()): ?>
            <tr>
                <td><?php echo $customer['customer_id']; ?></td>
                <td><?php echo $customer['first_name'] . ' ' . $customer['last_name']; ?></td>
                <td><?php echo $customer['email']; ?></td>
                <td><?php echo $customer['phone']; ?></td>
                <td><?php echo $customer['address'] . ', ' . $customer['city']; ?></td>
                <td><?php echo $customer['status']; ?></td>
                <td>
                    <a href="edit_customer.php?id=<?php echo $customer['customer_id']; ?>">Edit</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No customers found.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>