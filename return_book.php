<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: reader_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$book_no = $_POST['book_no'];

// Delete from Borrow
$stmt = $conn->prepare("DELETE FROM Borrow WHERE User_ID = ? AND Book_No = ?");
$stmt->bind_param("ii", $user_id, $book_no);
$stmt->execute();

// Update Book
$stmt = $conn->prepare("UPDATE Book SET Copies_Available = Copies_Available + 1 WHERE Book_No = ?");
$stmt->bind_param("i", $book_no);
$stmt->execute();

echo "✅ Book returned successfully.<br>";
echo "<a href='reader_dashboard.php'>Back to Dashboard</a>";
?>
