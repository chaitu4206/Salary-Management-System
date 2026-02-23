<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
requireRole('admin');

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eid = intval($_POST['eid']);
    $sid = intval($_POST['sid']);

    $stmt = $conn->prepare("UPDATE Employee_Salary SET SID = ? WHERE EID = ?");
    $stmt->bind_param("ii", $sid, $eid);
    if ($stmt->execute()) {
        $message = "Employee post changed successfully.";
    } else {
        $message = "Error updating post.";
    }
    $stmt->close();
}

// Fetch employees and salary scales
$employees = $conn->query("SELECT EID, EName FROM Employee");
$salary_res = $conn->query("SELECT SID, Basic, Allowance FROM Salary");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Change Employee Post</title>

<!-- ======= UPDATED: Center content & add Unsplash background image ======= -->
<style>
  /* Full page setup */
  html, body {
    height: 100%;
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  body {
    /* Background image from Unsplash */
    background: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
    background-size: cover;

    /* Flex centering */
    display: flex;
    justify-content: center;
    align-items: center;

    padding: 20px;
    color: #2c3e50;
  }

  /* Container to hold form */
  .container {
    background: rgba(255, 255, 255, 0.9);
    padding: 30px 40px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    max-width: 450px;
    width: 100%;
    box-sizing: border-box;
  }

  h2 {
    text-align: center;
    color: #34495e;
    margin-bottom: 30px;
  }

  form {
    display: flex;
    flex-direction: column;
  }

  label {
    margin-bottom: 8px;
    font-weight: 600;
    font-size: 1rem;
  }

  select {
    width: 100%;
    padding: 10px 12px;
    margin-bottom: 20px;
    border: 1.8px solid #ccc;
    border-radius: 6px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
  }
  select:focus {
    border-color: #3498db;
    outline: none;
  }

  button {
    width: 100%;
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
    background-color: #dff0d8;
    color: #3c763d;
    font-weight: 600;
    text-align: center;
    border-radius: 6px;
    padding: 12px 20px;
    margin-top: 20px;
  }

  p a {
    display: block;
    margin-top: 30px;
    text-align: center;
    color: #3498db;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
  }
  p a:hover {
    text-decoration: underline;
  }
</style>
<!-- ======= END UPDATED ======= -->

</head>
<body>

<div class="container">
  <h2>Change Employee Post (Salary Scale)</h2>

  <form method="post" action="">
      <label for="eid">Employee:</label>
      <select name="eid" id="eid" required>
          <option value="">Select Employee</option>
          <?php while ($row = $employees->fetch_assoc()) : ?>
              <option value="<?php echo $row['EID']; ?>"><?php echo htmlspecialchars($row['EName']); ?></option>
          <?php endwhile; ?>
      </select>

      <label for="sid">New Salary Scale:</label>
      <select name="sid" id="sid" required>
          <option value="">Select</option>
          <?php while ($row = $salary_res->fetch_assoc()) : ?>
              <option value="<?php echo $row['SID']; ?>">
                  Basic: <?php echo $row['Basic']; ?>, Allowance: <?php echo $row['Allowance']; ?>
              </option>
          <?php endwhile; ?>
      </select>

      <button type="submit">Change Post</button>
  </form>

  <?php if ($message): ?>
  <p class="message"><?php echo htmlspecialchars($message); ?></p>
  <?php endif; ?>

  <p><a href="../index.php">Back to Dashboard</a></p>
</div>

</body>
</html>
