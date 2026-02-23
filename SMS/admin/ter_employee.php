<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
requireRole('admin');

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eid = $_POST['eid'];
    $reason = $_POST['reason'];

    // Check if employee exists
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM Employee WHERE EID = ?");
    $checkStmt->bind_param("i", $eid);
    $checkStmt->execute();
    $checkStmt->bind_result($exists);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($exists == 0) {
        $message = "Error: Employee ID $eid does not exist.";
    } else {
        try {
            $stmt = $conn->prepare("CALL TerminateEmployee(?, ?)");
            $stmt->bind_param("is", $eid, $reason);
            $stmt->execute();
            $stmt->close();

            $message = "Employee ID $eid terminated successfully.";
        } catch (Exception $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}

// Fetch current employees
$employees = $conn->query("SELECT EID, EName, Email FROM Employee ORDER BY EName");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Terminate Employee</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f2f4f8;
            padding: 40px;
            display: flex;
            justify-content: center;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
        }

        select, textarea, button {
            margin-bottom: 15px;
            padding: 12px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            background-color: #e74c3c;
            color: white;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #c0392b;
        }

        .message {
            text-align: center;
            color: #2c3e50;
            font-weight: bold;
            margin-top: 20px;
        }

        a {
            display: block;
            text-align: center;
            color: #3498db;
            margin-top: 20px;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Terminate Employee</h2>

    <form method="post">
        <label for="eid">Select Employee:</label>
        <select name="eid" id="eid" required>
            <option value="">-- Choose Employee --</option>
            <?php while ($row = $employees->fetch_assoc()): ?>
                <option value="<?= $row['EID']; ?>">
                    <?= htmlspecialchars($row['EName']) ?> (<?= $row['Email'] ?>)
                </option>
            <?php endwhile; ?>
        </select>

        <label for="reason">Reason:</label>
        <textarea name="reason" id="reason" required rows="4" placeholder="Provide a reason for termination..."></textarea>

        <button type="submit">Terminate</button>
    </form>

    <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <a href="../index.php">Back to Dashboard</a>
</div>
</body>
</html>
