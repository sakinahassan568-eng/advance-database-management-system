<?php
session_start();
require 'db.php';

// Get form data
$login_id = $_POST['login_id'];
$password = $_POST['password'];
$user_type = $_POST['user_type']; // 'reader' or 'staff'

// Step 1: Check if login ID and password match in Authentication_System
$sql = "SELECT * FROM Authentication_System WHERE Login_ID = ? AND Password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $login_id, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    // Step 2: Check if user is a Reader or Staff in Authenticate table
    $auth_query = "SELECT * FROM Authenticate WHERE Login_ID = ?";
    $stmt2 = $conn->prepare($auth_query);
    $stmt2->bind_param("s", $login_id);
    $stmt2->execute();
    $auth_result = $stmt2->get_result();

    if ($auth_result->num_rows === 1) {
        $auth_data = $auth_result->fetch_assoc();

        if ($user_type === 'reader' && !empty($auth_data['User_ID'])) {
            $_SESSION['user_id'] = $auth_data['User_ID'];
            header("Location: reader_dashboard.php");
            exit();
        } elseif ($user_type === 'staff' && !empty($auth_data['Staff_ID'])) {
            $_SESSION['staff_id'] = $auth_data['Staff_ID'];
            header("Location: staff_dashboard.php");
            exit();
        } else {
            echo "❌ Invalid user type or credentials.";
        }
    } else {
        echo "❌ Authentication record not found.";
    }
} else {
    echo "❌ Incorrect Login ID or Password.";
}

$conn->close();
?> 