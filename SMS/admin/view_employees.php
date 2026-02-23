<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
requireRole('admin');

$sql = "SELECT e.EID, e.EName, e.Gender, e.Email, e.JoinDate, s.Basic, s.Allowance
        FROM Employee e
        LEFT JOIN Employee_Salary es ON e.EID = es.EID
        LEFT JOIN Salary s ON es.SID = s.SID
        ORDER BY e.EID";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>View Employees</title>
    <style>
        /* ===== UPDATED: full page centering & background ===== */
        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
            background-size: cover;

            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: #333;
        }
        .container {
            background: rgba(255,255,255,0.95);
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            max-width: 950px;
            width: 100%;
            box-sizing: border-box;
        }
        /* ===== END UPDATED ===== */

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px 18px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        th {
            background: #3498db;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        tr:hover {
            background-color: #f1f9ff;
        }
        td:nth-child(6), td:nth-child(7) {
            text-align: right;
        }
        a {
            display: block;
            width: 180px;
            margin: 30px auto 0 auto;
            text-align: center;
            padding: 10px 0;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        a:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Employee List</h2>

    <table>
        <tr>
            <th>EID</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Email</th>
            <th>Join Date</th>
            <th>Basic Salary</th>
            <th>Allowance</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?php echo $row['EID']; ?></td>
            <td><?php echo htmlspecialchars($row['EName']); ?></td>
            <td><?php echo htmlspecialchars($row['Gender']); ?></td>
            <td><?php echo htmlspecialchars($row['Email']); ?></td>
            <td><?php echo htmlspecialchars($row['JoinDate']); ?></td>
            <td><?php echo $row['Basic'] ?? 'N/A'; ?></td>
            <td><?php echo $row['Allowance'] ?? 'N/A'; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <p><a href="../index.php">Back to Dashboard</a></p>
</div>

</body>
</html>
