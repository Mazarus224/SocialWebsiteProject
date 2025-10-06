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

  <p>Tell us whats on your mind:</p>
    <form action="process.php" method="POST">
        <label for="user_text">Start Posting:</label><br>
        <textarea id="user_text" name="user_text" rows="5" cols="40"></textarea><br>
        <input type="submit" value="Submit">
    </form>

  
</body>
<footer>
  <a href="index.html">Log out</a>
</footer>  
</html>
