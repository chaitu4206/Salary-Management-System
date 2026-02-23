<?php
require_once 'includes/auth.php';
requireLogin();

$role = $_SESSION['role'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

            /* ✅ Set background image */
            background: url('background.png') no-repeat center center fixed;
            background-size: cover;

            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: rgba(255, 255, 255, 0.92);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .logo {
            font-size: 48px;
            margin-bottom: 20px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }

        ul li {
            margin: 12px 0;
        }

        a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #0056b3;
        }

        .message {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }

        .logout {
            margin-top: 30px;
            display: inline-block;
            color: #dc3545;
            font-weight: bold;
            text-decoration: none;
        }

        .logout:hover {
            color: #a71d2a;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">💼</div>
        <h2>Welcome to Salary Management System</h2>

        <p>
            Hello, <strong><?php echo htmlspecialchars($_SESSION['ename'] ?? $role); ?></strong>!<br>
            Your role: <strong><?php echo htmlspecialchars($role); ?></strong>
        </p>

        <ul>
            <?php if ($role === 'admin'): ?>
                <li><a href="admin/add_employee.php">➕ Add Employee</a></li>
                <li><a href="admin/change_post.php">🔄 Change Employee Post</a></li>
                <li><a href="admin/view_employees.php">👥 View Employees</a></li>
                <li><a href="admin/ter_employee.php">🛑 Terminate Employees</a></li>
            <?php elseif ($role === 'accountant'): ?>
                <li><a href="accountant/pay_salary.php">💰 Pay Salary</a></li>
                <li><a href="accountant/add_fund.php">➕ Add Fund</a></li>
                <li><a href="accountant/add_leave.php">🏖️ Add Leave</a></li>
            <?php elseif ($role === 'employee'): ?>
                <li><a href="employee/view_details.php">📄 View My Details & Salary</a></li>
            <?php else: ?>
                <p class="message">Unknown role.</p>
            <?php endif; ?>
        </ul>

        <a class="logout" href="logout.php">🚪 Logout</a>
    </div>
</body>
</html>
