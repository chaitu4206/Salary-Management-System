<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
requireRole('accountant');

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = floatval($_POST['amount']);

    // Get current fund
    $res = $conn->query("SELECT Fund_amount FROM Fund WHERE FID=1");
    $row = $res->fetch_assoc();
    $old_fund = $row['Fund_amount'];

    $new_fund = $old_fund + $amount;

    $stmt = $conn->prepare("UPDATE Fund SET Fund_amount = ? WHERE FID = 1");
    $stmt->bind_param("d", $new_fund);

    if ($stmt->execute()) {
        $message = "Fund updated successfully. New Fund: $new_fund";
    } else {
        $message = "Error updating fund.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Add Fund</title>
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
    max-width: 360px;
    width: 100%;
    box-sizing: border-box;
  }
  h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #34495e;
  }
  label, input, button, p.message {
    display: block;
    width: 100%;
  }
  input[type="number"] {
    padding: 10px 12px;
    font-size: 1rem;
    border: 1.8px solid #ccc;
    border-radius: 6px;
    margin-bottom: 20px;
    box-sizing: border-box;
    transition: border-color 0.3s ease;
  }
  input[type="number"]:focus {
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
    <h2>Add Fund</h2>

    <label for="amount">Amount to Add:</label>
    <input type="number" step="0.01" name="amount" id="amount" required>

    <button type="submit">Add Fund</button>

    <?php if ($message): ?>
    <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <a href="../index.php">Back to Dashboard</a>
</form>

</body>
</html>
