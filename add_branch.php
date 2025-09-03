<?php 
include('config.php');
// Fixed the SQL query to properly find managers
$managers = $conn->query("SELECT employee_id, first_name, last_name FROM Employees WHERE position = 'Manager' OR position LIKE '%Manager%'");
include('header.php');
?>

<div class="main-content">
    <h2>Add New Branch</h2>
    
    <form action="save_branch.php" method="POST" style="max-width: 600px;">
        <div class="form-group">
            <label>Branch Code:</label>
            <input type="text" name="branch_code" required>
        </div>
        
        <div class="form-group">
            <label>Branch Name:</label>
            <input type="text" name="branch_name" required>
        </div>
        
        <div class="form-group">
            <label>Address:</label>
            <input type="text" name="address" required>
        </div>
        
        <div class="form-group">
            <label>City:</label>
            <input type="text" name="city" required>
        </div>
        
        <div class="form-group">
            <label>State:</label>
            <input type="text" name="state" required>
        </div>
        
        <div class="form-group">
            <label>Zip Code:</label>
            <input type="text" name="zip_code" required>
        </div>
        
        <div class="form-group">
            <label>Phone:</label>
            <input type="text" name="phone">
        </div>
        
        <div class="form-group">
            <label>Manager:</label>
            <select name="manager_id">
                <option value="">Select Manager (Optional)</option>
                <?php 
                if ($managers && $managers->num_rows > 0) {
                    while($manager = $managers->fetch_assoc()): 
                ?>
                    <option value="<?php echo $manager['employee_id']; ?>">
                        <?php echo htmlspecialchars($manager['first_name'] . ' ' . $manager['last_name']); ?>
                    </option>
                <?php 
                    endwhile;
                } else {
                    echo '<option value="">No managers available</option>';
                }
                ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Opening Date:</label>
            <input type="date" name="opening_date" required>
        </div>
        
        <div class="form-group">
            <label>Status:</label>
            <select name="status" required>
                <option value="Active">Active</option>
                <option value="Closed">Closed</option>
                <option value="Temporary Closed">Temporary Closed</option>
            </select>
        </div>
        
        <button type="submit">Add Branch</button>
        <a href="branches.php" style="margin-left: 10px;">
            <button type="button" style="background: #6c757d;">Cancel</button>
        </a>
    </form>
</div>

<?php include 'footer.php'; ?>