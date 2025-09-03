<?php
include 'config.php';
include 'header.php';
?>

<div class="main-content">
    <h2>Branches Management</h2>
    <a href="add_branch.php" style="float: right; margin-bottom: 20px;">
        <button>Add New Branch</button>
    </a>
    
    <?php
    $branches = $conn->query("
        SELECT b.*, e.first_name, e.last_name 
        FROM Branches b 
        LEFT JOIN Employees e ON b.manager_id = e.employee_id 
        ORDER BY b.branch_id DESC
    ");
    
    if ($branches->num_rows > 0): ?>
        <table>
            <tr>
                <th>Branch ID</th>
                <th>Branch Code</th>
                <th>Branch Name</th>
                <th>Address</th>
                <th>City</th>
                <th>State</th>
                <th>Phone</th>
                <th>Manager</th>
                <th>Opening Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php while($branch = $branches->fetch_assoc()): ?>
            <tr>
                <td><?php echo $branch['branch_id']; ?></td>
                <td><?php echo $branch['branch_code']; ?></td>
                <td><?php echo $branch['branch_name']; ?></td>
                <td><?php echo $branch['address']; ?></td>
                <td><?php echo $branch['city']; ?></td>
                <td><?php echo $branch['state']; ?></td>
                <td><?php echo $branch['phone']; ?></td>
                <td>
                    <?php if ($branch['manager_id']): ?>
                        <?php echo $branch['first_name'] . ' ' . $branch['last_name']; ?>
                    <?php else: ?>
                        Not Assigned
                    <?php endif; ?>
                </td>
                <td><?php echo $branch['opening_date']; ?></td>
                <td>
                    <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $branch['status'])); ?>">
                        <?php echo $branch['status']; ?>
                    </span>
                </td>
                <td>
                    <a href="edit_branch.php?id=<?php echo $branch['branch_id']; ?>" class="action-btn">Edit</a>
                    <form action="delete_branch.php" method="POST" style="display:inline;">
                        <input type="hidden" name="branch_id" value="<?php echo $branch['branch_id']; ?>">
                        <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this branch?')">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No branches found.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>