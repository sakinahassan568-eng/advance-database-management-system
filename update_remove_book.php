<?php
require 'db.php';

$message = "";

// Handle Update
if (isset($_POST['update'])) {
    $book_no = $_POST['book_no'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $year = $_POST['published_year'];
    $copies = $_POST['copies'];

    $sql = "UPDATE Book SET Title=?, Author=?, Genre=?, Published_Year=?, Copies_Available=? WHERE Book_no=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssiii", $title, $author, $genre, $year, $copies, $book_no);
        $stmt->execute();
        $message = "<p style='color:green;'>✅ Book updated successfully!</p>";
        $stmt->close();
    } else {
        $message = "<p style='color:red;'>❌ Update failed: " . $conn->error . "</p>";
    }
}

// Handle Delete
if (isset($_POST['delete'])) {
    $book_no = $_POST['book_no'];

    $sql = "DELETE FROM Book WHERE Book_no=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $book_no);
        $stmt->execute();
        $message = "<p style='color:green;'>✅ Book deleted successfully!</p>";
        $stmt->close();
    } else {
        $message = "<p style='color:red;'>❌ Delete failed: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update/Remove Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('reader.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: rgba(255,255,255,0.9);
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
            text-align: center;
        }

        h2 {
            color: #2e8b57;
            margin-bottom: 25px;
        }

        form {
            text-align: left;
        }

        form label {
            font-weight: bold;
            margin-top: 15px;
            display: block;
            color: #2e8b57;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
        }

        input[type="submit"] {
            background-color: #2e8b57;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            width: 48%;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #246b46;
        }

        .back {
            text-align: center;
            margin-top: 20px;
        }

        .back a {
            color: #2e8b57;
            text-decoration: none;
            font-size: 0.9em;
        }

        .back a:hover {
            text-decoration: underline;
        }

        .message {
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>🔄 Update / Remove Book</h2>

    <?php echo $message; ?>

    <form method="post">
        <label for="book_no">Book No:</label>
        <input type="number" name="book_no" id="book_no" required>

        <label for="title">Title:</label>
        <input type="text" name="title" id="title">

        <label for="author">Author:</label>
        <input type="text" name="author" id="author">

        <label for="genre">Genre:</label>
        <input type="text" name="genre" id="genre">

        <label for="published_year">Published Year:</label>
        <input type="number" name="published_year" id="published_year">

        <label for="copies">Copies Available:</label>
        <input type="number" name="copies" id="copies">

        <div class="btn-group">
            <input type="submit" name="update" value="Update Book">
            <input type="submit" name="delete" value="Remove Book">
        </div>
    </form>

    <div class="back">
        <a href="staff_dashboard.php">← Back to Dashboard</a>
    </div>
</div>
</body>
</html>
