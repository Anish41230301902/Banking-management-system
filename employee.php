<?php
include 'config.php';
include 'header.php';
?>

<div class="main-content">
    <h2>Employee List</h2>
    <a href="add_employee.php" style="float: right; margin-bottom: 20px;">
        <button>Add New Employee</button>
    </a>
    
    <?php
    $employees = $conn->query("SELECT * FROM Employees ORDER BY employee_id");
    
    if ($employees->num_rows > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Position</th>
                <th>Department</th>
                <th>Salary</th>
                <th>Manager ID</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php while($employee = $employees->fetch_assoc()): ?>
            <tr>
                <td><?php echo $employee['employee_id']; ?></td>
                <td><?php echo $employee['first_name'] . ' ' . $employee['last_name']; ?></td>
                <td><?php echo $employee['email']; ?></td>
                <td><?php echo $employee['phone']; ?></td>
                <td><?php echo $employee['position']; ?></td>
                <td><?php echo $employee['department']; ?></td>
                <td>$<?php echo number_format($employee['salary'], 2); ?></td>
                <td><?php echo $employee['manager_id'] ? $employee['manager_id'] : 'None'; ?></td>
                <td>
                    <span class="status-badge status-<?php echo strtolower($employee['status']); ?>">
                        <?php echo $employee['status']; ?>
                    </span>
                </td>
                <td>
                    <a href="edit_employee.php?id=<?php echo $employee['employee_id']; ?>" class="action-btn">Edit</a>
                    <form action="delete_employee.php" method="POST" style="display:inline;">
                        <input type="hidden" name="employee_id" value="<?php echo $employee['employee_id']; ?>">
                        <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this employee?')">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No employees found.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>