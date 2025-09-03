<?php
include('config.php');

// Check if branch ID is provided
if (!isset($_GET['id'])) {
    header("Location: branches.php");
    exit();
}

$branch_id = $_GET['id'];

// Get branch data
$branch = $conn->query("SELECT * FROM Branches WHERE branch_id = $branch_id")->fetch_assoc();

if (!$branch) {
    header("Location: branches.php");
    exit();
}

$managers = $conn->query("SELECT employee_id, first_name, last_name FROM Employees WHERE position LIKE '%Manager%'");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $branch_code = $_POST['branch_code'];
    $branch_name = $_POST['branch_name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip_code = $_POST['zip_code'];
    $phone = $_POST['phone'];
    $manager_id = !empty($_POST['manager_id']) ? $_POST['manager_id'] : 'NULL';
    $opening_date = $_POST['opening_date'];
    $status = $_POST['status'];

    $sql = "UPDATE Branches SET 
            branch_code = '$branch_code',
            branch_name = '$branch_name',
            address = '$address',
            city = '$city',
            state = '$state',
            zip_code = '$zip_code',
            phone = '$phone',
            manager_id = $manager_id,
            opening_date = '$opening_date',
            status = '$status'
            WHERE branch_id = $branch_id";

    if ($conn->query($sql)) {
        header("Location: branches.php?message=Branch updated successfully");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}

include('header.php');
?>

<div class="main-content">
    <h2>Edit Branch</h2>
    
    <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="" style="max-width: 600px;">
        <div class="form-group">
            <label>Branch Code:</label>
            <input type="text" name="branch_code" value="<?php echo $branch['branch_code']; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Branch Name:</label>
            <input type="text" name="branch_name" value="<?php echo $branch['branch_name']; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Address:</label>
            <input type="text" name="address" value="<?php echo $branch['address']; ?>" required>
        </div>
        
        <div class="form-group">
            <label>City:</label>
            <input type="text" name="city" value="<?php echo $branch['city']; ?>" required>
        </div>
        
        <div class="form-group">
            <label>State:</label>
            <input type="text" name="state" value="<?php echo $branch['state']; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Zip Code:</label>
            <input type="text" name="zip_code" value="<?php echo $branch['zip_code']; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Phone:</label>
            <input type="text" name="phone" value="<?php echo $branch['phone']; ?>">
        </div>
        
        <div class="form-group">
            <label>Manager:</label>
            <select name="manager_id">
                <option value="">Select Manager (Optional)</option>
                <?php while($manager = $managers->fetch_assoc()): ?>
                    <option value="<?php echo $manager['employee_id']; ?>" 
                        <?php echo $branch['manager_id'] == $manager['employee_id'] ? 'selected' : ''; ?>>
                        <?php echo $manager['first_name'] . ' ' . $manager['last_name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Opening Date:</label>
            <input type="date" name="opening_date" value="<?php echo $branch['opening_date']; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Status:</label>
            <select name="status" required>
                <option value="Active" <?php echo $branch['status'] == 'Active' ? 'selected' : ''; ?>>Active</option>
                <option value="Closed" <?php echo $branch['status'] == 'Closed' ? 'selected' : ''; ?>>Closed</option>
                <option value="Temporary Closed" <?php echo $branch['status'] == 'Temporary Closed' ? 'selected' : ''; ?>>Temporary Closed</option>
            </select>
        </div>
        
        <button type="submit">Update Branch</button>
        <a href="branches.php">
            <button type="button" style="background: #6c757d; margin-left: 10px;">Cancel</button>
        </a>
    </form>
</div>

<?php include('footer.php'); ?>