<!DOCTYPE html>
<html>
<head>
    <title>Reader Login</title>
    <link rel="stylesheet" href="style.css"> <!-- includes background image -->
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 300px;
        }

        h2 {
            color: #2e8b57;
            margin-bottom: 30px;
            font-weight: bold;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
            color: #333;
            text-align: left;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1em;
        }

        input[type="submit"] {
            margin-top: 25px;
            background-color: #2e8b57;
            color: white;
            border: none;
            padding: 12px 0;
            width: 100%;
            font-size: 1em;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        input[type="submit"]:hover {
            background-color: #246b46;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>📚 Reader Login</h2>
        <form action="login.php" method="post">
            <input type="hidden" name="user_type" value="reader">
            
            <label for="login_id">Login ID:</label>
            <input type="text" id="login_id" name="login_id" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <input type="submit" value="Login">
        </form>
    </div>

</body>
</html>
