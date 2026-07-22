-- Create the database
CREATE DATABASE ATM_bank_system;

-- Use the ATM_bank_system database
USE ATM_bank_system;

-- Table to store customer information
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    account_type ENUM('Savings', 'Current') NOT NULL,
    balance DECIMAL(15, 2) NOT NULL DEFAULT 0.00,
    password VARCHAR(255) NOT NULL,
    status ENUM('Pending', 'Approved', 'Rejected') NOT NULL DEFAULT 'Pending',
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table to store transaction history for each customer
CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_number INT NOT NULL,
    transaction_type ENUM('Deposit', 'Withdrawal') NOT NULL,
    amount DECIMAL(15, 2) NOT NULL,
    balance_after DECIMAL(15, 2) NOT NULL,
    transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (account_number) REFERENCES customers(id) ON DELETE CASCADE
);

-- Table to store admin login credentials
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO admins (username, password)
VALUES 
('admin', MD5('admin123'));