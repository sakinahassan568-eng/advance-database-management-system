<?php
session_start();
require 'db.php';

// Check if staff is logged in
if (!isset($_SESSION['staff_id'])) {
    header("Location: login.php");
    exit();
}

$staff_id = $_SESSION['staff_id'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = trim($_POST['user_id'] ?? '');
    $book_no = trim($_POST['book_no'] ?? '');

    if (empty($user_id) || empty($book_no)) {
        $message = "Please enter both Reader ID and Book Number.";
    } elseif (!preg_match('/^[A-Za-z0-9]+$/', $user_id) || !ctype_digit($book_no)) {
        $message = "Reader ID must be alphanumeric and Book Number must be numeric.";
    } else {
        // Check if book is borrowed by this user and not returned yet
        $check_sql = "SELECT * FROM Borrow WHERE User_ID = ? AND Book_No = ? AND Return_Date IS NULL";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("si", $user_id, $book_no);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $message = "This book is not currently borrowed by this reader or already returned.";
        } else {
            // Update Borrow table with Return_Date
            $return_date = date('Y-m-d');
            $update_sql = "UPDATE Borrow SET Return_Date = ? WHERE User_ID = ? AND Book_No = ? AND Return_Date IS NULL";
            $stmt2 = $conn->prepare($update_sql);
            $stmt2->bind_param("ssi", $return_date, $user_id, $book_no);
            if ($stmt2->execute()) {
                // Insert record into Manage table
                $manage_sql = "INSERT INTO Manage (Staff_ID, Book_No, Management_Date, Operation_Type) VALUES (?, ?, ?, 'Return')";
                $stmt3 = $conn->prepare($manage_sql);
                $stmt3->bind_param("iis", $staff_id, $book_no, $return_date);
                $stmt3->execute();

                // Increase Copies_Available by 1 in Book table
                $update_book_sql = "UPDATE Book SET Copies_Available = Copies_Available + 1 WHERE Book_no = ?";
                $stmt4 = $conn->prepare($update_book_sql);
                $stmt4->bind_param("i", $book_no);
                $stmt4->execute();

                $message = "Book returned successfully.";
            } else {
                $message = "Failed to update return date. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Return Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('library_bg.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0; padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #004d40;
        }
        .container {
            background: rgba(255,255,255,0.95);
            padding: 40px 50px;
            border-radius: 12px;
            width: 420px;
            box-shadow: 0 0 20px rgba(0,0,0,0.25);
            text-align: center;
        }
        h2 {
            margin-bottom: 30px;
            color: #00796b;
            font-size: 28px;
        }
        label {
            display: block;
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            text-align: left;
            color: #004d40;
        }
        input[type="text"], button {
            width: 100%;
            padding: 14px;
            margin-top: 8px;
            border-radius: 8px;
            border: 1.5px solid #ccc;
            font-size: 18px;
            box-sizing: border-box;
        }
        button {
            background-color: #00796b;
            color: white;
            border: none;
            margin-top: 30px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #004d40;
        }
        .message {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }
        .success {
            color: #388e3c;
        }
        .error {
            color: #d32f2f;
        }
        .back-btn {
            margin-top: 30px;
            display: inline-block;
            text-decoration: none;
            background: #004d40;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }
        .back-btn:hover {
            background: #00251a;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🔁 Return Book</h2>

        <form method="POST" action="staff_return.php">
            <label for="user_id">Enter Reader ID:</label>
            <input type="text" id="user_id" name="user_id" placeholder="Reader ID (e.g., R001)" required pattern="[A-Za-z0-9]+" title="Alphanumeric only">

            <label for="book_no">Enter Book Number:</label>
            <input type="text" id="book_no" name="book_no" placeholder="Book Number (e.g., 101)" required pattern="\d+" title="Numbers only">

            <button type="submit">Return Book</button>
        </form>

        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, 'successfully') !== false ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <a href="staff_dashboard.php" class="back-btn">⬅️ Back to Dashboard</a>
    </div>
</body>
</html>
