# 🏦 Banking Management System

## 📋 Project Overview
A comprehensive web-based Banking Management System developed using PHP and MySQL. This system allows bank administrators to manage customers, accounts, transactions, and other banking operations efficiently.

---

## 🏫 Academic Information
**Department:** Computer Science and Engineering  
**Course Code:** CSE 2291  
**Course Title:** Software Development Lab 2  
**University:** Northern University Bangladesh  

---

## 👥 Team Members
- **Twuhed Ahmed Rifat** - ID: 41230301559
- **Sadia Afrin** - ID: 41230301548  
- **Anish Kumar** - ID: 41230301902

**Supervised by:** Amir Labib Khan, Lecturer, Department of CSE

---

## ✨ Features
- ✅ Customer Management (Add, Edit, View)
- ✅ Account Management (Savings, Checking, Fixed Deposit, Business)
- ✅ Transaction Processing (Deposit, Withdrawal, Transfer)
- ✅ Interest Calculation System
- ✅ Employee Management
- ✅ Loan Management System
- ✅ Bank Branch Management
- ✅ Real-time Balance Tracking
- ✅ User-friendly Dashboard
- ✅ Responsive Design

---

## 🛠️ Technology Stack
- **Frontend:** HTML5, CSS3, JavaScript
- **Backend:** PHP
- **Database:** MySQL
- **Server:** XAMPP/Apache
- **Design:** Responsive CSS with Banking Theme

---

## 📁 Project Structure

---

## 🗃️ Database Schema
The system uses 8 main tables:
- **Customers** - Customer personal information and details
- **Accounts** - Bank account information and balances
- **Transactions** - Financial transaction records
- **Employees** - Bank staff management
- **Loans** - Loan products and management
- **LoanPayments** - Loan repayment tracking
- **Cards** - Debit/Credit card management
- **Branches** - Bank branch information

---

## 🚀 Installation Guide

### Prerequisites
- XAMPP/WAMP Server
- PHP 7.4+
- MySQL 5.7+
- Web Browser

### Installation Steps
1. **Start Services**
   - Start Apache and MySQL in XAMPP/WAMP

2. **Set up the database**
   - Open phpMyAdmin (`http://localhost/phpmyadmin`)
   - Create a new database named `BankingManagementSystem`
   - Import the `asr.sql` file to create tables and sample data

3. **Configure database connection**
   - Edit `config.php` with your database credentials:
   ```php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "BankingManagementSystem";
