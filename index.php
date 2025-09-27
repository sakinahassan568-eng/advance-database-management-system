<!DOCTYPE html>
<html>
<head>
    <title>Library Management System</title>
    <link rel="stylesheet" href="style.css"> <!-- background image included here -->
    <style>
        /* Remove inline body background, let style.css handle it */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.85);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
            text-align: center;
        }

        h1 {
            margin-bottom: 40px;
            font-size: 2em;
            color: #2e8b57;
        }

        .btn {
            padding: 15px 30px;
            margin: 20px;
            font-size: 18px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Welcome to the Library Management System</h1>
        <a href="reader_login.php" class="btn">Reader Login</a>
        <a href="staff_login.php" class="btn">Staff Login</a>
    </div>

</body>
</html>
