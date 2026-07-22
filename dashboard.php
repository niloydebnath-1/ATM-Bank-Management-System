<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['email'];

$sql = "SELECT * FROM customers WHERE email='$email'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    $customer = mysqli_fetch_assoc($result); 
} else {
    // Handle the case where no customer is found
    echo "No customer found with this email.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f0f0f0;
            margin: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 15px;
        }

        p {
            margin-bottom: 10px;
        }

        a {
            display: inline-block;
            margin-right: 15px;
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo $customer['name']; ?></h1>
        <h2>Account Information</h2>
        <p>Account Type: <?php echo $customer['account_type']; ?></p>
        <p>Current Balance: <?php echo $customer['balance']; ?>TK</p>

        <a href="transaction_history.php">View Transaction History</a>
        <a href="deposit.php">Make a Deposit</a>
        <a href="withdraw.php">Make a Withdrawal</a>
    </div>
</body>
</html>