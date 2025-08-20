<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banking Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Banking Management System</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Dashboard</a></li>
                    <li><a href="customers.php">Customers</a></li>
                    <li><a href="accounts.php">Accounts</a></li>
                    <li><a href="transactions.php">Transactions</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert <?php echo $_SESSION['message_type']; ?>">
                <?php 
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
                ?>
            </div>
        <?php endif; ?>