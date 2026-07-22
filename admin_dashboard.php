<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// Fetch all customer accounts
$sql_customers = "SELECT * FROM customers";
$result_customers = mysqli_query($conn, $sql_customers);

// Fetch all transactions
$sql_transactions = "SELECT * FROM transactions";
$result_transactions = mysqli_query($conn, $sql_transactions);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        .dashboard-container {
            width: 90%;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #007bff;
        }
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0 0 20px;
            display: flex;
            gap: 20px;
            background-color: #007bff;
            padding: 10px;
            border-radius: 5px;
        }
        nav ul li {
            display: inline;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        nav ul li a:hover {
            text-decoration: underline;
        }
        section {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        form {
            display: flex;
            flex-direction: column;
            max-width: 400px;
        }
        label, input, button {
            margin-bottom: 10px;
        }
        input, button {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Welcome, Admin</h1>
        <nav>
            <ul>
                <li><a href="#view-customers">View All Customers</a></li>
                <li><a href="#search-customers">Search Customers</a></li>
                <li><a href="#view-transactions">View All Transactions</a></li>
            </ul>
        </nav>

        <!-- View All Customers -->
        <section id="view-customers">
            <h2>All Customer Accounts</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Account Type</th>
                    <th>Balance</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result_customers)) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['address'] ?></td>
                    <td><?= $row['phone'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['account_type'] ?></td>
                    <td><?= $row['balance'] ?></td>
                </tr>
                <?php } ?>
            </table>
        </section>

        <!-- Search Customers -->
        <section id="search-customers">
            <h2>Search for a Customer</h2>
            <form method="GET" action="">
                <label for="search">Enter Customer Name or ID:</label>
                <input type="text" id="search" name="search" required>
                <button type="submit">Search</button>
            </form>
            <?php
            if (isset($_GET['search'])) {
                $search = $_GET['search'];
                $sql_search = "SELECT * FROM customers WHERE id = '$search' OR name LIKE '%$search%'";
                $result_search = mysqli_query($conn, $sql_search);

                if (mysqli_num_rows($result_search) > 0) {
                    echo "<h3>Search Results:</h3><table><tr>
                          <th>ID</th><th>Name</th><th>Address</th><th>Phone</th><th>Email</th><th>Account Type</th><th>Balance</th>
                          </tr>";
                    while ($row = mysqli_fetch_assoc($result_search)) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['address']}</td>
                                <td>{$row['phone']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['account_type']}</td>
                                <td>{$row['balance']}</td>
                              </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No customer found.</p>";
                }
            }
            ?>
        </section>

        <!-- View All Transactions -->
        <section id="view-transactions">
            <h2>All Transactions</h2>
            <table>
                <tr>
                    <th>Transaction ID</th>
                    <th>Account Number</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Balance After</th>
                    <th>Date</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result_transactions)) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['account_number'] ?></td>
                    <td><?= $row['transaction_type'] ?></td>
                    <td><?= $row['amount'] ?></td>
                    <td><?= $row['balance_after'] ?></td>
                    <td><?= $row['transaction_date'] ?></td>
                </tr>
                <?php } ?>
            </table>
        </section>
    </div>
</body>
</html>
