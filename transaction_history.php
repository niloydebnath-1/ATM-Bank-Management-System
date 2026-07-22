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
$customer = mysqli_fetch_assoc($result);

$sql_transactions = "SELECT * FROM transactions WHERE account_number = {$customer['id']} ORDER BY transaction_date DESC";
$result_transactions = mysqli_query($conn, $sql_transactions);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            display: inline-block;
            margin-top: 20px;
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
        <h1>Transaction History</h1>
        <table>
            <thead>
                <tr>
                    <th>Date/Time</th>
                    <th>Transaction Type</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result_transactions)) : ?>
                    <tr>
                        <td><?php echo $row['transaction_date']; ?></td>
                        <td><?php echo $row['transaction_type']; ?></td>
                        <td><?php echo $row['amount']; ?>TK</td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>