<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
requireRole('admin');

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ename = $_POST['ename'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $joindate = $_POST['joindate'];
    $sid = $_POST['sid'];

    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("INSERT INTO Employee (EName, Gender, Email, JoinDate) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $ename, $gender, $email, $joindate);
        $stmt->execute();

        $eid = $stmt->insert_id;

        $stmt->close();

        $stmt2 = $conn->prepare("INSERT INTO Employee_Salary (EID, SID) VALUES (?, ?)");
        $stmt2->bind_param("ii", $eid, $sid);
        $stmt2->execute();

        $stmt2->close();

        $conn->commit();

        $message = "Employee added successfully with ID $eid";
    } catch (Exception $e) {
        $conn->rollback();
        $message = "Error: " . $e->getMessage();
    }
}

// Fetch salary scales for dropdown
$salary_res = $conn->query("SELECT SID, Basic, Allowance FROM Salary");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Employee</title>

    <!-- ======= UPDATED: Center content & add Unsplash background image ======= -->
    <style>
      /* Full page setup with flexbox centering */
      html, body {
        height: 100%;
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      }
      body {
        /* Background image from Unsplash */
        background: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
        background-size: cover;

        /* Center horizontally and vertically */
        display: flex;
        justify-content: center;
        align-items: center;

        /* Text color fallback */
        color: #2c3e50;
        padding: 20px;
      }

      /* Container to hold form and text */
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
        color: #333;
        margin-bottom: 25px;
        text-align: center;
      }

      form {
        display: flex;
        flex-direction: column;
      }

      input[type="text"],
      input[type="email"],
      input[type="date"],
      select {
        padding: 12px;
        margin-bottom: 18px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 1rem;
        box-sizing: border-box;
      }

      button {
        padding: 14px;
        border: none;
        background-color: #4A90E2;
        color: white;
        font-size: 1.1rem;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
      }
      button:hover {
        background-color: #357ABD;
      }

      p.message {
        margin-top: 20px;
        font-weight: 600;
        color: #2c3e50;
        text-align: center;
      }

      p a {
        display: block;
        margin-top: 20px;
        text-align: center;
        color: #4A90E2;
        text-decoration: underline;
        font-weight: 600;
      }
      p a:hover {
        color: #357ABD;
      }
    </style>
    <!-- ======= END UPDATED ======= -->

</head>
<body>

<div class="container">
  <h2>Add New Employee</h2>
  <form method="post" action="">
      Name:
      <input type="text" name="ename" required>
      Gender:
      <select name="gender" required>
          <option value="">Select</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Other">Other</option>
      </select>
      Email:
      <input type="email" name="email" required>
      Join Date:
      <input type="date" name="joindate" required>
      Salary Scale:
      <select name="sid" required>
          <option value="">Select</option>
          <?php while ($row = $salary_res->fetch_assoc()) : ?>
              <option value="<?php echo $row['SID']; ?>">
                  Basic: <?php echo $row['Basic']; ?>, Allowance: <?php echo $row['Allowance']; ?>
              </option>
          <?php endwhile; ?>
      </select>
      <button type="submit">Add Employee</button>
  </form>

  <?php if ($message): ?>
  <p class="message"><?php echo htmlspecialchars($message); ?></p>
  <?php endif; ?>

  <p><a href="../index.php">Back to Dashboard</a></p>
</div>

</body>
</html>
