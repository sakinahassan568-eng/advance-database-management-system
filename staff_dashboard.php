<?php
session_start();
require 'db.php';

// Check if staff is logged in
if (!isset($_SESSION['staff_id'])) {
    header("Location: login.php");
    exit();
}

// You can fetch staff name if you want:
$staff_id = $_SESSION['staff_id'];
$sql = "SELECT Name FROM Staff WHERE Staff_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $staff_id);
$stmt->execute();
$result = $stmt->get_result();
$staff = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f8ff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #2e8b57;
        }
        .dashboard {
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.15);
            text-align: center;
            width: 350px;
        }
        h2 {
            margin-bottom: 20px;
        }
        .btn {
            display: block;
            background-color: #2e8b57;
            color: white;
            border: none;
            padding: 12px;
            margin: 10px auto;
            width: 90%;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #246b46;
        }
        .logout {
            margin-top: 25px;
            background-color: #d9534f;
        }
        .logout:hover {
            background-color: #b0302a;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h2>👋 Welcome, <?php echo htmlspecialchars($staff['Name']); ?>!</h2>

        <a href="add_book.php" class="btn">➕ Add New Book</a>
        <a href="update_remove_book.php" class="btn">🔄 Update / Remove Book</a>
        <a href="issue_book.php" class="btn">📤 Issue Book to Reader</a>
        <a href="view_borrowed_books.php" class="btn">📚 View Borrowed Books</a>
        <a href="view_readers.php" class="btn">📖 View All Readers</a>
        <a href="staff_return.php" class="btn">🔁 Return Book</a>

        <a href="logout.php" class="btn logout">🚪 Logout</a>
    </div>
</body>
</html>
