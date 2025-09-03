<?php 
include('config.php');
$managers = $conn->query("SELECT employee_id, first_name, last_name FROM Employees WHERE manager_id IS NULL");
include('header.php');
?>

<div class="main-content">
    <h2>Add New Employee</h2>
    
    <form action="save_employee.php" method="POST" style="max-width: 600px;">
        <div class="form-group">
            <label>First Name:</label>
            <input type="text" name="first_name" required>
        </div>
        
        <div class="form-group">
            <label>Last Name:</label>
            <input type="text" name="last_name" required>
        </div>
        
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label>Phone:</label>
            <input type="text" name="phone">
        </div>
        
        <div class="form-group">
            <label>Position:</label>
            <input type="text" name="position" required>
        </div>
        
        <div class="form-group">
            <label>Department:</label>
            <select name="department" required>
                <option value="">Select Department</option>
                <option value="Retail Banking">Retail Banking</option>
                <option value="Operations">Operations</option>
                <option value="IT">IT</option>
                <option value="HR">HR</option>
                <option value="Finance">Finance</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Salary:</label>
            <input type="number" step="0.01" name="salary" required>
        </div>
        
        <div class="form-group">
            <label>Manager:</label>
            <select name="manager_id">
                <option value="">None</option>
                <?php while($m = $managers->fetch_assoc()): ?>
                    <option value="<?php echo $m['employee_id']; ?>">
                        <?php echo $m['first_name'] . ' ' . $m['last_name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <button type="submit">Add Employee</button>
        <a href="employee.php" style="margin-left: 10px;">
            <button type="button" style="background: #6c757d;">Cancel</button>
        </a>
    </form>
</div>

<?php include('footer.php'); ?>