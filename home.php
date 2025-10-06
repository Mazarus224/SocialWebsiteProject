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
  <title>Welcome Home</title>
</head>
<body>
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
      $allPosts = array_reverse($allPosts);  // Optional: show newest posts first
      foreach ($allPosts as $post) {
          echo "<p>" . htmlspecialchars($post) . "</p>";
      }
  } else {
      echo "<p>No posts yet. Be the first to post something!</p>";
  }
  ?>
</body>
<footer>
  <a href="logout.php">Log out</a>
</footer>  
</html>

