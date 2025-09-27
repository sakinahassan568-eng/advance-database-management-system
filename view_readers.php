<?php
session_start();
require 'db.php';

if (!isset($_SESSION['staff_id'])) {
    header("Location: login.php");
    exit();
}

// Modified SQL with LEFT JOIN
$sql = "SELECT r.User_ID, r.Name, r.Email, r.Address, r.Phone_Number, b.Title AS Borrowed_Title, br.Borrow_Date
        FROM Readers r
        LEFT JOIN Borrow br ON r.User_ID = br.User_ID
        LEFT JOIN Book b ON br.Book_No = b.Book_no
        ORDER BY r.User_ID";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View All Readers</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            margin: 50px auto;
            width: 90%;
            max-width: 900px;
            background-color: rgba(255,255,255,0.95);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            color: #2e8b57;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px;
        }
        th {
            background-color: #2e8b57;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .btn {
            display: inline-block;
            background-color: #2e8b57;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            margin-top: 20px;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #246b46;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📖 All Registered Readers (with Borrowed Books)</h2>
        <table>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Phone Number</th>
                <th>Borrowed Book</th>
                <th>Borrow Date</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['User_ID']) ?></td>
                        <td><?= htmlspecialchars($row['Name']) ?></td>
                        <td><?= htmlspecialchars($row['Email']) ?></td>
                        <td><?= htmlspecialchars($row['Address']) ?></td>
                        <td><?= isset($row['Phone_Number']) ? htmlspecialchars($row['Phone_Number']) : 'N/A' ?></td>
                        <td><?= $row['Borrowed_Title'] ? htmlspecialchars($row['Borrowed_Title']) : 'None' ?></td>
                        <td><?= $row['Borrow_Date'] ? htmlspecialchars($row['Borrow_Date']) : 'N/A' ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7" style="text-align:center;">No readers found.</td></tr>
            <?php endif; ?>
        </table>

        <div style="text-align: center;">
            <a href="staff_dashboard.php" class="btn">⬅️ Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
