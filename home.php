<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: forms.php");
    exit();
}

$posts_file = 'posts.txt';

// When form is submitted, save the new post
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_text'])) {
    $submittedText = trim($_POST['user_text']);
    if ($submittedText !== '') {
        $safeText = htmlspecialchars($submittedText);
        $postEntry = "[" . date("Y-m-d H:i:s") . "] " . $_SESSION['user'] . ": " . $safeText . "\n";
        file_put_contents($posts_file, $postEntry, FILE_APPEND);
    }
}

// Read all posts to display
$allPosts = [];
if (file_exists($posts_file)) {
    $allPosts = file($posts_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Social | Home Page</title>
  <link rel="stylesheet" href="#" /> <!-- Link CSS here -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <!-- Bootstrap CSS link -->
</head>
<body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <!-- Bootstrap JS link -->
  <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>
  <p>You are logged in.</p>

  <p>Tell us what's on your mind:</p>
  <form action="home.php" method="POST">
      <label for="user_text">Start Posting:</label><br>
      <textarea id="user_text" name="user_text" rows="5" cols="40"></textarea><br>
      <input type="submit" value="Submit">
  </form>

  <p>Timeline:</p>
  <?php
  if (!empty($allPosts)) {
      $allPosts = array_reverse($allPosts);  //show newest posts first
      foreach ($allPosts as $post) {
          echo "<p>" . htmlspecialchars($post) . "</p>";
      }
  } else {
      echo "<p>No posts yet. Be the first to post something!</p>";
  }
  ?>
</body>
 <footer style="margin-top: 4rem;">
    <address>
      <p>&copy; 2025 Malik Robinson, Ben Gives. All rights reserved.</p>
      <p><a href="termsandcons.html">Terms and Conditions</a></p>
      <p><a href="privacy.html">Privacy Policy</a></p>
      <p><a href="cookie.html">Cookie Policy</a></p>  
      <a href="logout.php">Log out</a>
    </address>
  </footer>
</html>
 