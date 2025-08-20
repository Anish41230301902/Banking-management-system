-- Create Database
CREATE DATABASE BankingManagementSystem;
USE BankingManagementSystem;

-- 1. Customers Table
CREATE TABLE Customers (
    customer_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    date_of_birth DATE NOT NULL,
    address VARCHAR(255),
    city VARCHAR(50),
    state VARCHAR(50),
    zip_code VARCHAR(20),
    date_joined DATE DEFAULT CURRENT_DATE,
    status ENUM('Active', 'Inactive', 'Suspended') DEFAULT 'Active',
    CONSTRAINT chk_email_format CHECK (email LIKE '%@%.%')
);

-- 2. Accounts Table
CREATE TABLE Accounts (
    account_id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT NOT NULL,
    account_number VARCHAR(20) UNIQUE NOT NULL,
    account_type ENUM('Savings', 'Checking', 'Fixed Deposit', 'Business') NOT NULL,
    balance DECIMAL(15,2) DEFAULT 0.00,
    opening_date DATE DEFAULT CURRENT_DATE,
    status ENUM('Active', 'Closed', 'Dormant', 'Frozen') DEFAULT 'Active',
    interest_rate DECIMAL(5,3) DEFAULT 0.0,
    minimum_balance DECIMAL(10,2) DEFAULT 0.00,
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id) ON DELETE CASCADE,
    CONSTRAINT chk_positive_balance CHECK (balance >= 0)
);

-- 3. Transactions Table
CREATE TABLE Transactions (
    transaction_id INT PRIMARY KEY AUTO_INCREMENT,
    account_id INT NOT NULL,
    transaction_type ENUM('Deposit', 'Withdrawal', 'Transfer', 'Interest', 'Fee') NOT NULL,
    amount DECIMAL(15,2) NOT NULL,
    transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    description VARCHAR(255),
    related_account_id INT NULL,
    status ENUM('Completed', 'Pending', 'Failed', 'Reversed') DEFAULT 'Completed',
    FOREIGN KEY (account_id) REFERENCES Accounts(account_id) ON DELETE CASCADE,
    FOREIGN KEY (related_account_id) REFERENCES Accounts(account_id) ON DELETE SET NULL,
    CONSTRAINT chk_positive_amount CHECK (amount > 0)
);

-- 4. Employees Table
CREATE TABLE Employees (
    employee_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    position VARCHAR(50) NOT NULL,
    department ENUM('Retail Banking', 'Operations', 'IT', 'HR', 'Finance') NOT NULL,
    hire_date DATE DEFAULT CURRENT_DATE,
    salary DECIMAL(10,2) NOT NULL,
    manager_id INT NULL,
    status ENUM('Active', 'Inactive', 'Terminated') DEFAULT 'Active',
    FOREIGN KEY (manager_id) REFERENCES Employees(employee_id) ON DELETE SET NULL
);

-- 5. Loans Table
CREATE TABLE Loans (
    loan_id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT NOT NULL,
    account_id INT NOT NULL,
    loan_type ENUM('Personal', 'Home', 'Car', 'Education', 'Business') NOT NULL,
    loan_amount DECIMAL(15,2) NOT NULL,
    interest_rate DECIMAL(5,3) NOT NULL,
    term_months INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    status ENUM('Active', 'Paid Off', 'Defaulted', 'Processing') DEFAULT 'Processing',
    monthly_payment DECIMAL(10,2) NOT NULL,
    remaining_balance DECIMAL(15,2) NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id) ON DELETE CASCADE,
    FOREIGN KEY (account_id) REFERENCES Accounts(account_id) ON DELETE CASCADE,
    CONSTRAINT chk_positive_loan_amount CHECK (loan_amount > 0),
    CONSTRAINT chk_positive_interest_rate CHECK (interest_rate >= 0)
);

-- 6. LoanPayments Table
CREATE TABLE LoanPayments (
    payment_id INT PRIMARY KEY AUTO_INCREMENT,
    loan_id INT NOT NULL,
    payment_date DATE NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    principal_amount DECIMAL(10,2) NOT NULL,
    interest_amount DECIMAL(10,2) NOT NULL,
    status ENUM('Paid', 'Pending', 'Late', 'Missed') DEFAULT 'Pending',
    due_date DATE NOT NULL,
    FOREIGN KEY (loan_id) REFERENCES Loans(loan_id) ON DELETE CASCADE,
    CONSTRAINT chk_payment_breakdown CHECK (amount = principal_amount + interest_amount)
);

-- 7. Cards Table (Credit/Debit Cards)
CREATE TABLE Cards (
    card_id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT NOT NULL,
    account_id INT NOT NULL,
    card_number VARCHAR(20) UNIQUE NOT NULL,
    card_type ENUM('Debit', 'Credit') NOT NULL,
    expiry_date DATE NOT NULL,
    cvv VARCHAR(3) NOT NULL,
    daily_limit DECIMAL(10,2) DEFAULT 5000.00,
    status ENUM('Active', 'Blocked', 'Expired', 'Lost') DEFAULT 'Active',
    issue_date DATE DEFAULT CURRENT_DATE,
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id) ON DELETE CASCADE,
    FOREIGN KEY (account_id) REFERENCES Accounts(account_id) ON DELETE CASCADE
);

-- 8. Branches Table
CREATE TABLE Branches (
    branch_id INT PRIMARY KEY AUTO_INCREMENT,
    branch_code VARCHAR(10) UNIQUE NOT NULL,
    branch_name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    city VARCHAR(50) NOT NULL,
    state VARCHAR(50) NOT NULL,
    zip_code VARCHAR(20) NOT NULL,
    phone VARCHAR(20),
    manager_id INT NULL,
    opening_date DATE NOT NULL,
    status ENUM('Active', 'Closed', 'Temporary Closed') DEFAULT 'Active',
    FOREIGN KEY (manager_id) REFERENCES Employees(employee_id) ON DELETE SET NULL
);

-- Create indexes for better performance
CREATE INDEX idx_customers_email ON Customers(email);
CREATE INDEX idx_accounts_customer ON Accounts(customer_id);
CREATE INDEX idx_transactions_account_date ON Transactions(account_id, transaction_date);
CREATE INDEX idx_loans_customer ON Loans(customer_id);
CREATE INDEX idx_loanpayments_loan_date ON LoanPayments(loan_id, payment_date);
CREATE INDEX idx_cards_customer ON Cards(customer_id);
CREATE INDEX idx_employees_department ON Employees(department);

-- Insert sample data
INSERT INTO Customers (first_name, last_name, email, phone, date_of_birth, address, city, state, zip_code) VALUES
('Anish', 'Kumar', 'anish.kumar@email.com', '123-456', '2003-1-7', 'Uttara, Dhaka', 'Dhaka', 'DH', '10001'),
('Sadia', 'Afrin', 'sadia.afrin@email.com', '555-0102', '2003-07-22', '456 Oak Ave', 'Uttara, Dhaka', 'DH', '90001');

INSERT INTO Accounts (customer_id, account_number, account_type, balance, interest_rate) VALUES
(1, 'SAV00123456', 'Savings', 5000.00, 2.5),
(1, 'CHK00123457', 'Checking', 2500.00, 0.1),
(2, 'SAV00123458', 'Savings', 7500.00, 2.5);

INSERT INTO Employees (first_name, last_name, email, phone, position, department, salary) VALUES
('Robert', 'Johnson', 'robert.j@bank.com', '555-0201', 'Branch Manager', 'Retail Banking', 75000.00),
('Sarah', 'Wilson', 'sarah.w@bank.com', '555-0202', 'Loan Officer', 'Retail Banking', 60000.00);

INSERT INTO Branches (branch_code, branch_name, address, city, state, zip_code, phone, manager_id, opening_date) VALUES
('NYC001', 'Dhaka Main Branch', '789 Broadway', 'New York', 'NY', '10002', '555-0301', 1, '2020-01-15');

-- Create views for common queries
CREATE VIEW CustomerAccountSummary AS
SELECT 
    c.customer_id,
    c.first_name,
    c.last_name,
    c.email,
    a.account_id,
    a.account_number,
    a.account_type,
    a.balance,
    a.status
FROM Customers c
JOIN Accounts a ON c.customer_id = a.customer_id;

CREATE VIEW LoanSummary AS
SELECT 
    l.loan_id,
    c.first_name,
    c.last_name,
    l.loan_type,
    l.loan_amount,
    l.remaining_balance,
    l.status
FROM Loans l
JOIN Customers c ON l.customer_id = c.customer_id;