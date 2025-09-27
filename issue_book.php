<?php
require 'db.php';

$message = "";

// Handle Issue Book form submission
if (isset($_POST['issue'])) {
    $staff_id = $_POST['staff_id'];
    $user_id = $_POST['user_id'];
    $book_no = $_POST['book_no'];           // new field
    $issue_date = $_POST['issue_date'];
    $expiry_date = $_POST['expiry_date'];

    $sql = "INSERT INTO Issue (Staff_ID, User_ID, Book_No, Issue_Date, Expiry_Date) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssss", $staff_id, $user_id, $book_no, $issue_date, $expiry_date);
        if ($stmt->execute()) {
            $message = "<p style='color:green;'>✅ Book issued successfully!</p>";
        } else {
            $message = "<p style='color:red;'>❌ Error issuing book: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        $message = "<p style='color:red;'>❌ Prepare failed: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Issue Book</title>
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
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn-group {
            margin-top: 25px;
        }

        input[type="submit"] {
            background-color: #2e8b57;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            width: 100%;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            font-size: 16px;
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
            font-size: 1em;
            font-weight: bold;
        }

        .back a:hover {
            text-decoration: underline;
        }

        p {
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>📤 Issue Book to Reader</h2>

    <?php echo $message; ?>

    <form method="post">
        <label for="staff_id">Staff ID:</label>
        <input type="text" name="staff_id" id="staff_id" required placeholder="e.g. S001">

        <label for="user_id">Reader's User ID:</label>
        <input type="text" name="user_id" id="user_id" required placeholder="e.g. U005">

        <label for="book_no">Book Number:</label>
        <input type="text" name="book_no" id="book_no" required placeholder="e.g. B100">

        <label for="issue_date">Issue Date:</label>
        <input type="date" name="issue_date" id="issue_date" required>

        <label for="expiry_date">Expiry Date:</label>
        <input type="date" name="expiry_date" id="expiry_date" required>

        <div class="btn-group">
            <input type="submit" name="issue" value="📤 Issue Book">
        </div>
    </form>

    <div class="back">
        <a href="staff_dashboard.php">← Back to Dashboard</a>
    </div>
</div>
</body>
</html>
