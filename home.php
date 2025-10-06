<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: forms.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Welcome Home</title>
</head>
<body>
  <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>
  <p>You are logged in.</p>
  <a href="index.html">Log out</a>
</body>
</html>
