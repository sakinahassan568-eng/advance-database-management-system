<?php
require 'db.php';
session_start();

// Optional: check if staff is logged in
if (!isset($_SESSION['staff_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

// Fetch currently borrowed books (Return_Date IS NULL)
$sql = "
    SELECT 
        b.Book_No, bk.Title, bk.Author, r.User_ID, r.Name AS ReaderName, b.Borrow_Date, b.Return_Date
    FROM 
        Borrow b
    JOIN 
        Book bk ON b.Book_No = bk.Book_no
    JOIN 
        Readers r ON b.User_ID = r.User_ID
    WHERE 
        b.Return_Date IS NULL
    ORDER BY 
        b.Borrow_Date DESC
";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>📚 View Borrowed Books</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('reader.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            margin: 0; padding: 0;
            color: #333;
        }
        .container {
            max-width: 900px;
            margin: 40px auto;
            background-color: rgba(255,255,255,0.95);
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
        }
        h2 {
            color: #2e8b57;
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background-color: #2e8b57;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .back {
            margin-top: 25px;
            text-align: center;
        }
        .back a {
            color: #2e8b57;
            text-decoration: none;
            font-weight: bold;
            font-size: 1em;
        }
        .back a:hover {
            text-decoration: underline;
        }
        p.message {
            text-align: center;
            font-weight: bold;
            margin-top: 15px;
            color: #d9534f;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📚 Currently Borrowed Books</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Book No</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Reader ID</th>
                    <th>Reader Name</th>
                    <th>Borrow Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Book_No']); ?></td>
                        <td><?php echo htmlspecialchars($row['Title']); ?></td>
                        <td><?php echo htmlspecialchars($row['Author']); ?></td>
                        <td><?php echo htmlspecialchars($row['User_ID']); ?></td>
                        <td><?php echo htmlspecialchars($row['ReaderName']); ?></td>
                        <td><?php echo htmlspecialchars($row['Borrow_Date']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="message">No borrowed books found.</p>
    <?php endif; ?>

    <div class="back">
        <a href="staff_dashboard.php">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>
