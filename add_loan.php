<?php 
include('config.php');
$customers = $conn->query("SELECT customer_id, first_name, last_name FROM Customers");
$accounts = $conn->query("SELECT account_id, account_number FROM Accounts");
include('header.php');
?>

<div class="main-content">
    <h2>Add New Loan</h2>
    
    <form action="save_loan.php" method="POST" style="max-width: 600px;">
        <div class="form-group">
            <label>Customer:</label>
            <select name="customer_id" required>
                <option value="">Select Customer</option>
                <?php while($customer = $customers->fetch_assoc()): ?>
                <option value="<?php echo $customer['customer_id']; ?>">
                    <?php echo $customer['first_name'] . ' ' . $customer['last_name']; ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Account:</label>
            <select name="account_id" required>
                <option value="">Select Account</option>
                <?php while($account = $accounts->fetch_assoc()): ?>
                <option value="<?php echo $account['account_id']; ?>">
                    <?php echo $account['account_number']; ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Loan Type:</label>
            <select name="loan_type" required>
                <option value="">Select Loan Type</option>
                <option value="Personal">Personal</option>
                <option value="Home">Home</option>
                <option value="Car">Car</option>
                <option value="Education">Education</option>
                <option value="Business">Business</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Loan Amount:</label>
            <input type="number" step="0.01" name="loan_amount" required>
        </div>
        
        <div class="form-group">
            <label>Interest Rate (%):</label>
            <input type="number" step="0.001" name="interest_rate" required>
        </div>
        
        <div class="form-group">
            <label>Term (months):</label>
            <input type="number" name="term_months" required>
        </div>
        
        <div class="form-group">
            <label>Start Date:</label>
            <input type="date" name="start_date" required>
        </div>
        
        <div class="form-group">
            <label>Monthly Payment:</label>
            <input type="number" step="0.01" name="monthly_payment" required>
        </div>
        
        <button type="submit">Add Loan</button>
        <a href="loan.php" style="margin-left: 10px;">
            <button type="button" style="background: #6c757d;">Cancel</button>
        </a>
    </form>
</div>

<?php include('footer.php'); ?>