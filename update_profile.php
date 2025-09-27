<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: reader_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['address'];
$phone = $_POST['phone'];

$stmt = $conn->prepare("UPDATE Readers SET Name = ?, Email = ?, Address = ?, Phone_Number = ? WHERE User_ID = ?");
$stmt->bind_param("ssssi", $name, $email, $address, $phone, $user_id);
$stmt->execute();

echo "✅ Profile updated successfully.<br>";
echo "<a href='reader_dashboard.php'>Back to Dashboard</a>";
?>
