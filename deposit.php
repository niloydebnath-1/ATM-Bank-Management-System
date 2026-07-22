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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $deposit_amount = $_POST['deposit_amount'];

    if ($deposit_amount <= 0) {
        $error = "Invalid deposit amount.";
    } else {
        $new_balance = $customer['balance'] + $deposit_amount;

        $sql_update = "UPDATE customers SET balance = $new_balance WHERE id = {$customer['id']}";
        if (mysqli_query($conn, $sql_update)) {
            $sql_transaction = "INSERT INTO transactions (account_number, transaction_type, amount, balance_after) 
                                VALUES ({$customer['id']}, 'Deposit', $deposit_amount, $new_balance)";
            if (mysqli_query($conn, $sql_transaction)) {
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Error recording transaction.";
            }
        } else {
            $error = "Error updating account balance.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a Deposit</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Make a Deposit</h1>
        <?php if (isset($error)) : ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <label for="deposit_amount">Deposit Amount:</label>
            <input type="number" id="deposit_amount" name="deposit_amount" step="0.01" required>
            <button type="submit">Deposit</button>
        </form>
    </div>
</body>
</html>