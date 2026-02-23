<?php
session_start();
require_once 'includes/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($email === 'admin@example.com' && $password === 'admin123') {
        $_SESSION['user_id'] = 0;
        $_SESSION['role'] = 'admin';
        header('Location: index.php');
        exit();
    } elseif ($email === 'accountant@example.com' && $password === 'account123') {
        $_SESSION['user_id'] = 0;
        $_SESSION['role'] = 'accountant';
        header('Location: index.php');
        exit();
    } else {
        $stmt = $conn->prepare("SELECT EID, EName FROM Employee WHERE Email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['EID'];
            $_SESSION['role'] = 'employee';
            $_SESSION['ename'] = $row['EName'];
            header('Location: index.php');
            exit();
        } else {
            $message = "Invalid credentials";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('https://images.unsplash.com/photo-1496307042754-b4aa456c4a2d') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 40px 30px;
            width: 350px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        h2 {
            text-align: center;
            color: #fff;
            margin-bottom: 25px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            border: none;
            outline: none;
            background: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            color: #ff4d4d;
            text-align: center;
            margin-top: 15px;
            font-weight: bold;
        }

        .info {
            color: #f1f1f1;
            font-size: 14px;
            margin-top: 20px;
            text-align: center;
        }

        .info code {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 2px 6px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="post" action="">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <div class="info">
            <p><strong>Test Accounts:</strong></p>
            <p>Admin: <code>admin@example.com</code> / <code>admin123</code></p>
            <p>Accountant: <code>accountant@example.com</code> / <code>account123</code></p>
            <p>Employee: Use any valid employee email from DB (no password)</p>
        </div>
    </div>
</body>
</html>
