<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
requireRole('employee');

$eid = $_SESSION['user_id'];

// Get employee details
$stmt = $conn->prepare("SELECT EName, Gender, Email, JoinDate FROM Employee WHERE EID = ?");
$stmt->bind_param("i", $eid);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();
$stmt->close();

// Get salary scale
$stmt = $conn->prepare("SELECT s.Basic, s.Allowance FROM Employee_Salary es JOIN Salary s ON es.SID = s.SID WHERE es.EID = ?");
$stmt->bind_param("i", $eid);
$stmt->execute();
$result = $stmt->get_result();
$salary = $result->fetch_assoc();
$stmt->close();

// Get leaves
$stmt = $conn->prepare("SELECT L_month, L_days FROM Employee_Leave WHERE EID = ? ORDER BY L_month DESC");
$stmt->bind_param("i", $eid);
$stmt->execute();
$leaves = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Get transactions (salary paid)
$stmt = $conn->prepare("SELECT Amount, T_Date, S_month FROM Transection WHERE EID = ? ORDER BY T_Date DESC");
$stmt->bind_param("i", $eid);
$stmt->execute();
$transactions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Details & Salary</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            /* Fixed Unsplash background */
            background: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px 40px;
            border-radius: 12px;
            max-width: 850px;
            width: 100%;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        h2, h3 {
            color: #2c3e50;
            border-bottom: 2px solid #007BFF;
            padding-bottom: 6px;
            margin-top: 40px;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            margin: 8px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th {
            background-color: #007BFF;
            color: white;
            padding: 10px;
        }

        td {
            padding: 10px;
            text-align: center;
        }

        a {
            display: inline-block;
            margin-top: 30px;
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>My Details</h2>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($employee['EName']); ?></p>
    <p><strong>Gender:</strong> <?php echo htmlspecialchars($employee['Gender']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($employee['Email']); ?></p>
    <p><strong>Join Date:</strong> <?php echo htmlspecialchars($employee['JoinDate']); ?></p>

    <h3>Salary Scale</h3>
    <p><strong>Basic:</strong> <?php echo htmlspecialchars($salary['Basic'] ?? 'N/A'); ?></p>
    <p><strong>Allowance:</strong> <?php echo htmlspecialchars($salary['Allowance'] ?? 'N/A'); ?></p>

    <h3>Leaves</h3>
    <table>
        <tr>
            <th>Month</th>
            <th>Days</th>
        </tr>
        <?php foreach ($leaves as $leave): ?>
            <tr>
                <td><?php echo htmlspecialchars($leave['L_month']); ?></td>
                <td><?php echo $leave['L_days']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>Salary Payments</h3>
    <table>
        <tr>
            <th>Month</th>
            <th>Amount</th>
            <th>Date Paid</th>
        </tr>
        <?php foreach ($transactions as $t): ?>
            <tr>
                <td><?php echo htmlspecialchars($t['S_month']); ?></td>
                <td><?php echo $t['Amount']; ?></td>
                <td><?php echo htmlspecialchars($t['T_Date']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="../index.php">← Back to Dashboard</a>
</div>
</body>
</html>
