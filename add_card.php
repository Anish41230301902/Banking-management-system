<?php 
include('config.php');
$customers = $conn->query("SELECT customer_id, first_name, last_name FROM Customers WHERE status='Active'");
// Fixed query to include account_type
$accounts = $conn->query("SELECT account_id, customer_id, account_number, account_type FROM Accounts WHERE status='Active'");
include('header.php');
?>

<div class="main-content">
    <h2>Add New Card</h2>
    
    <form action="save_card.php" method="POST" style="max-width: 600px;">
        <div class="form-group">
            <label>Customer:</label>
            <select name="customer_id" id="customer_id" required onchange="updateAccounts()">
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
            <select name="account_id" id="account_id" required>
                <option value="">Select Account</option>
                <?php while($account = $accounts->fetch_assoc()): ?>
                <option value="<?php echo $account['account_id']; ?>" data-customer="<?php echo $account['customer_id']; ?>">
                    <?php echo $account['account_number'] . ' - ' . $account['account_type']; ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Card Number:</label>
            <input type="text" name="card_number" pattern="[0-9]{16}" title="16-digit card number" required>
        </div>
        
        <div class="form-group">
            <label>Card Type:</label>
            <select name="card_type" required>
                <option value="">Select Card Type</option>
                <option value="Debit">Debit Card</option>
                <option value="Credit">Credit Card</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Expiry Date:</label>
            <input type="date" name="expiry_date" required>
        </div>
        
        <div class="form-group">
            <label>CVV:</label>
            <input type="text" name="cvv" pattern="[0-9]{3}" title="3-digit CVV" required>
        </div>
        
        <div class="form-group">
            <label>Daily Limit:</label>
            <input type="number" step="0.01" name="daily_limit" value="5000.00" required>
        </div>
        
        <div class="form-group">
            <label>Status:</label>
            <select name="status" required>
                <option value="Active">Active</option>
                <option value="Blocked">Blocked</option>
                <option value="Expired">Expired</option>
                <option value="Lost">Lost</option>
            </select>
        </div>
        
        <button type="submit">Add Card</button>
        <a href="cards.php" style="margin-left: 10px;">
            <button type="button" style="background: #6c757d;">Cancel</button>
        </a>
    </form>
</div>

<script>
function updateAccounts() {
    const customerId = document.getElementById('customer_id').value;
    const accountSelect = document.getElementById('account_id');
    const options = accountSelect.options;
    
    // First show all options
    for (let i = 0; i < options.length; i++) {
        options[i].style.display = '';
    }
    
    // If a customer is selected, hide non-matching accounts
    if (customerId) {
        for (let i = 0; i < options.length; i++) {
            const option = options[i];
            if (option.value === "") continue;
            
            const customerData = option.getAttribute('data-customer');
            if (customerData !== customerId) {
                option.style.display = 'none';
            }
        }
    }
    
    // Reset selection
    accountSelect.value = "";
}
</script>

<?php include 'footer.php'; ?>