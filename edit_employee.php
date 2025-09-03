<?php
include('config.php');

// Check if employee ID is provided
if (!isset($_GET['id'])) {
    header("Location: employee.php");
    exit();
}

$employee_id = $_GET['id'];

// Get employee data
$employee = $conn->query("SELECT * FROM Employees WHERE employee_id = $employee_id")->fetch_assoc();

if (!$employee) {
    header("Location: employee.php");
    exit();
}

// Get managers for dropdown (excluding current employee)
$managers = $conn->query("SELECT employee_id, first_name, last_name FROM Employees WHERE manager_id IS NULL AND employee_id != $employee_id");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $position = $_POST['position'];
    $department = $_POST['department'];
    $salary = $_POST['salary'];
    $manager_id = !empty($_POST['manager_id']) ? $_POST['manager_id'] : 'NULL';
    $status = $_POST['status'];

    // Update query
    $sql = "UPDATE Employees SET 
            first_name = '$first_name',
            last_name = '$last_name', 
            email = '$email',
            phone = '$phone',
            position = '$position',
            department = '$department',
            salary = $salary,
            manager_id = $manager_id,
            status = '$status'
            WHERE employee_id = $employee_id";

    if ($conn->query($sql)) {
        header("Location: employee.php?message=Employee updated successfully");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}

include('header.php');
?>

<div class="main-content">
    <h2>Edit Employee</h2>
    
    <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="" style="max-width: 600px;">
        <div class="form-group">
            <label>First Name:</label>
            <input type="text" name="first_name" value="<?php echo $employee['first_name']; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Last Name:</label>
            <input type="text" name="last_name" value="<?php echo $employee['last_name']; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $employee['email']; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Phone:</label>
            <input type="text" name="phone" value="<?php echo $employee['phone']; ?>">
        </div>
        
        <div class="form-group">
            <label>Position:</label>
            <input type="text" name="position" value="<?php echo $employee['position']; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Department:</label>
            <select name="department" required>
                <option value="Retail Banking" <?php echo $employee['department'] == 'Retail Banking' ? 'selected' : ''; ?>>Retail Banking</option>
                <option value="Operations" <?php echo $employee['department'] == 'Operations' ? 'selected' : ''; ?>>Operations</option>
                <option value="IT" <?php echo $employee['department'] == 'IT' ? 'selected' : ''; ?>>IT</option>
                <option value="HR" <?php echo $employee['department'] == 'HR' ? 'selected' : ''; ?>>HR</option>
                <option value="Finance" <?php echo $employee['department'] == 'Finance' ? 'selected' : ''; ?>>Finance</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Salary:</label>
            <input type="number" step="0.01" name="salary" value="<?php echo $employee['salary']; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Manager:</label>
            <select name="manager_id">
                <option value="">None</option>
                <?php while($m = $managers->fetch_assoc()): ?>
                    <option value="<?php echo $m['employee_id']; ?>" 
                        <?php echo $employee['manager_id'] == $m['employee_id'] ? 'selected' : ''; ?>>
                        <?php echo $m['first_name'] . ' ' . $m['last_name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Status:</label>
            <select name="status" required>
                <option value="Active" <?php echo $employee['status'] == 'Active' ? 'selected' : ''; ?>>Active</option>
                <option value="Inactive" <?php echo $employee['status'] == 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                <option value="Terminated" <?php echo $employee['status'] == 'Terminated' ? 'selected' : ''; ?>>Terminated</option>
            </select>
        </div>
        
        <button type="submit">Update Employee</button>
        <a href="employee.php">
            <button type="button" style="background: #6c757d; margin-left: 10px;">Cancel</button>
        </a>
    </form>
</div>

<?php include('footer.php'); ?>