<!DOCTYPE html>
<html>
<head>
    <title>Staff Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="staff-page">
    <header>
        <h2>📋 Staff Login</h2>
    </header>

    <main>
        <form action="login.php" method="post">
            <input type="hidden" name="user_type" value="staff">

            <label for="login_id">Login ID:</label>
            <input type="text" name="login_id" id="login_id" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <input type="submit" value="Login">
        </form>
    </main>

    <footer>
        <p>© 2025 Library Management System</p>
    </footer>
</body>
</html>
