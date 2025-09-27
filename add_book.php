<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_no = $_POST['book_no'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $year = $_POST['published_year'];
    $copies = $_POST['copies'];

    $sql = "INSERT INTO Book (Book_no, Title, Author, Genre, Published_Year, Copies_Available) VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL Prepare Failed: " . $conn->error);
    }

    $stmt->bind_param("isssii", $book_no, $title, $author, $genre, $year, $copies);

    if ($stmt->execute()) {
        echo "<p style='color: green; text-align:center; font-weight:bold;'>✅ Book added successfully!</p>";
    } else {
        echo "<p style='color: red; text-align:center; font-weight:bold;'>❌ Execute failed: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
    <style>
        /* ==== Global Page Background ==== */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('reader.jpg'); /* Your background image */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            color: #333;
        }

        /* ==== Container for form ==== */
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
            text-align: center;
        }

        h2 {
            color: #2e8b57;
            margin-bottom: 25px;
            font-weight: 700;
        }

        form {
            text-align: left;
        }

        form label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #2e8b57;
        }

        form input[type="text"],
        form input[type="number"],
        form input[type="date"],
        form input[type="password"],
        form input[type="email"],
        form input[type="select"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
            box-sizing: border-box;
        }

        form input[type="submit"],
        button {
            margin-top: 25px;
            background-color: #2e8b57;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 1.1em;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            width: 100%;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        form input[type="submit"]:hover,
        button:hover {
            background-color: #246b46;
        }

        /* Back to Dashboard button */
        .back-btn {
            display: inline-block;
            margin-top: 15px;
            font-size: 0.9em;
            color: #2e8b57;
            text-decoration: none;
            border: 1.5px solid #2e8b57;
            padding: 6px 12px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
            cursor: pointer;
            text-align: center;
        }

        .back-btn:hover {
            background-color: #2e8b57;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Book</h2>
        <form method="post">
            <label for="book_no">Book No:</label>
            <input type="number" id="book_no" name="book_no" required>

            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="author">Author:</label>
            <input type="text" id="author" name="author" required>

            <label for="genre">Genre:</label>
            <input type="text" id="genre" name="genre" required>

            <label for="published_year">Published Year:</label>
            <input type="number" id="published_year" name="published_year" required>

            <label for="copies">Copies Available:</label>
            <input type="number" id="copies" name="copies" required>

            <input type="submit" value="Add Book">
        </form>
        <!-- Back to Dashboard button -->
        <a href="staff_dashboard.php" class="back-btn">← Back to Dashboard</a>
    </div>
</body>
</html>
