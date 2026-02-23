<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
requireRole('accountant');

$message = '';

function generateSalary($conn, $eid, $month) {
    // Get salary scale for employee
    $stmt = $conn->prepare("SELECT s.Basic, s.Allowance FROM Employee_Salary es JOIN Salary s ON es.SID = s.SID WHERE es.EID = ?");
    $stmt->bind_param("i", $eid);
    $stmt->execute();
    $result = $stmt->get_result();
    $salary = 0;
    if ($row = $result->fetch_assoc()) {
        $basic = $row['Basic'];
        $allowance = $row['Allowance'];

        // Get leaves in the month
        $stmt2 = $conn->prepare("SELECT L_days FROM Employee_Leave WHERE EID = ? AND L_month = ?");
        $stmt2->bind_param("is", $eid, $month);
        $stmt2->execute();
        $res2 = $stmt2->get_result();
        $leaves = 0;
        if ($r = $res2->fetch_assoc()) {
            $leaves = $r['L_days'];
        }
        $stmt2->close();

        $working_days = 30 - $leaves; // Assuming 30 days in month
        $daily_salary = ($basic + $allowance) / 30;
        $salary = $daily_salary * $working_days;
    }
    $stmt->close();

    return round($salary, 2);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eid = intval($_POST['eid']);
    $month = $_POST['month'];
    $amount = generateSalary($conn, $eid, $month);
    $date = date('Y-m-d');

    $stmt = $conn->prepare("INSERT INTO Transection (EID, Amount, T_Date, S_month) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("idss", $eid, $amount, $date, $month);

    if ($stmt->execute()) {
        $message = "Salary of $amount paid for Employee ID $eid for $month.";
    } else {
        $message = "Error paying salary.";
    }

    $stmt->close();
}

$employees = $conn->query("SELECT EID, EName FROM Employee");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Pay Salary</title>
<style>
  html, body {
    height: 100%;
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  body {
    /* Background image from Unsplash */
    background: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
    background-size: cover;

    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
    color: #2c3e50;
  }
  form {
    background: rgba(255, 255, 255, 0.9);
    padding: 30px 40px;
    border-radius: 10px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.25);
    max-width: 400px;
    width: 100%;
    box-sizing: border-box;
  }
  h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #34495e;
  }
  label, select, input, button, p.message {
    display: block;
    width: 100%;
  }
  select, input[type="month"] {
    padding: 10px 12px;
    font-size: 1rem;
    border: 1.8px solid #ccc;
    border-radius: 6px;
    margin-bottom: 20px;
    box-sizing: border-box;
    transition: border-color 0.3s ease;
  }
  select:focus, input[type="month"]:focus {
    border-color: #3498db;
    outline: none;
  }
  button {
    background-color: #3498db;
    border: none;
    padding: 12px;
    color: white;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  button:hover {
    background-color: #2980b9;
  }
  p.message {
    margin-top: 15px;
    padding: 12px 20px;
    background-color: #dff0d8;
    color: #3c763d;
    font-weight: 600;
    border-radius: 6px;
    text-align: center;
  }
  a {
    margin-top: 20px;
    display: block;
    text-align: center;
    color: #3498db;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
  }
  a:hover {
    text-decoration: underline;
  }
</style>
</head>
<body>

<form method="post" action="">
    <h2>Pay Salary</h2>

    <label for="eid">Employee:</label>
    <select name="eid" id="eid" required>
        <option value="">Select Employee</option>
        <?php while ($row = $employees->fetch_assoc()) : ?>
            <option value="<?php echo $row['EID']; ?>"><?php echo htmlspecialchars($row['EName']); ?></option>
        <?php endwhile; ?>
    </select>

    <label for="month">Month (e.g., 2025-05):</label>
    <input type="month" name="month" id="month" required>

    <button type="submit">Pay Salary</button>

    <?php if ($message): ?>
    <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <a href="../index.php">Back to Dashboard</a>
</form>

</body>
</html>
