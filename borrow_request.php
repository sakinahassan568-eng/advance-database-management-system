<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: reader_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$book_no = $_POST['book_no'];
$today = date('Y-m-d');
$return_date = date('Y-m-d', strtotime('+14 days'));

// Check if book is available
$check = $conn->prepare("SELECT Copies_Available FROM Book WHERE Book_No = ?");
$check->bind_param("i", $book_no);
$check->execute();
$result = $check->get_result();
$row = $result->fetch_assoc();

if ($row && $row['Copies_Available'] > 0) {
    // Insert borrow record
    $stmt = $conn->prepare("INSERT INTO Borrow (User_ID, Book_No, Borrow_Date, Return_Date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $user_id, $book_no, $today, $return_date);
    $stmt->execute();

    // Update available copies
    $update = $conn->prepare("UPDATE Book SET Copies_Available = Copies_Available - 1 WHERE Book_No = ?");
    $update->bind_param("i", $book_no);
    $update->execute();

    echo "✅ Borrow request successful.";
} else {
    echo "❌ Book not available.";
}

echo "<br><a href='reader_dashboard.php'>Back to Dashboard</a>";
?>
