<?php
session_start();
require 'db.php';

// Session check
if (!isset($_SESSION['user_id'])) {
    header("Location: reader_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch reader profile
$reader_sql = "SELECT * FROM Readers WHERE User_ID = ?";
$stmt = $conn->prepare($reader_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$reader = $stmt->get_result()->fetch_assoc();

// Fetch available books
$book_sql = "SELECT * FROM Book WHERE Copies_Available > 0";
$books = $conn->query($book_sql);

// Fetch borrowed books
$borrow_sql = "SELECT B.Title, Bo.Borrow_Date, Bo.Return_Date 
               FROM Borrow Bo 
               JOIN Book B ON Bo.Book_No = B.Book_No 
               WHERE Bo.User_ID = ?";
$stmt = $conn->prepare($borrow_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$borrowed = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reader Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('library.png');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            margin: 40px auto;
            max-width: 1000px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
        }
        h2, h3 {
            color: #2e8b57;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #aaa;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        form {
            margin-top: 20px;
            text-align: left;
        }
        form label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        form input[type="text"],
        form input[type="email"],
        form input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        form button {
            margin-top: 15px;
            background-color: #2e8b57;
            color: white;
            padding: 10px 20px;
            border: none;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        form button:hover {
            background-color: #246b46;
        }
        .logout-link {
            float: right;
            text-decoration: none;
            color: #d00;
            font-weight: bold;
        }
        .feature-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .feature-table th, .feature-table td {
            padding: 10px;
            border: 1px solid #aaa;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>👋 Welcome, <?php echo htmlspecialchars($reader['Name']); ?>!</h2>
        <a href="logout.php" class="logout-link">🚪 Logout</a>



        <h3>👤 Update Profile</h3>
        <form method="post" action="update_profile.php">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($reader['Name']); ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($reader['Email']); ?>" required>

            <label>Address:</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($reader['Address']); ?>" required>

            <label>Phone Number:</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($reader['Phone_Number']); ?>" required>

            <button type="submit">Update Profile</button>
        </form>

        <h3>🔍 Search Books</h3>
        <form method="get" action="search_books.php">
            <input type="text" name="query" placeholder="Enter title / author / genre" required>
            <button type="submit">Search</button>
        </form>

        <h3>📤 Borrow Book Request</h3>
        <form method="post" action="borrow_request.php">
            <label>Book No:</label>
            <input type="number" name="book_no" required>
            <button type="submit">Request to Borrow</button>
        </form>

        <h3>📖 My Borrowed Books</h3>
        <table>
            <tr><th>Title</th><th>Borrow Date</th><th>Return Date</th></tr>
            <?php while ($row = $borrowed->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['Title']); ?></td>
                    <td><?php echo $row['Borrow_Date']; ?></td>
                    <td><?php echo $row['Return_Date']; ?></td>
                </tr>
            <?php } ?>
        </table>

        <h3>📚 Available Books</h3>
        <table>
            <tr><th>Title</th><th>Author</th><th>Genre</th><th>Published Year</th><th>Copies Available</th></tr>
            <?php while ($book = $books->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($book['Title']); ?></td>
                    <td><?php echo htmlspecialchars($book['Author']); ?></td>
                    <td><?php echo htmlspecialchars($book['Genre']); ?></td>
                    <td><?php echo $book['Published_Year']; ?></td>
                    <td><?php echo $book['Copies_Available']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
