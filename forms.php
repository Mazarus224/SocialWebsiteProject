<?php
session_start();

$users_file = 'users.txt';

function saveUser($username, $email, $password) {
    global $users_file;
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $entry = "$username|$email|$hashed\n";
    file_put_contents($users_file, $entry, FILE_APPEND);
}

function findUser($email) {
    global $users_file;
    if (!file_exists($users_file)) return false;

    $lines = file($users_file, FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        list($username, $storedEmail, $hashed) = explode('|', $line);
        if (trim($storedEmail) === trim($email)) {
            return ['username' => $username, 'email' => $storedEmail, 'password' => $hashed];
        }
    }
    return false;
}

$signup_error = $signin_error = '';
$signup_success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sign Up
    if (isset($_POST['signup-username'])) {
        $username = trim($_POST['signup-username']);
        $email = trim($_POST['signup-email']);
        $password = $_POST['signup-password'];
        $confirm = $_POST['signup-confirm-password'];

        if ($password !== $confirm) {
            $signup_error = "Passwords do not match.";
        } elseif (findUser($email)) {
            $signup_error = "User already exists.";
        } else {
            saveUser($username, $email, $password);
            $signup_success = "Account created successfully! You can now sign in.";
        }
    }

    // Sign In
    if (isset($_POST['signin-email'])) {
        $email = trim($_POST['signin-email']);
        $password = $_POST['signin-password'];

        $user = findUser($email);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['username'];
            header("Location: home.php");
            exit();
        } else {
            $signin_error = "Invalid email or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Student Social | Sign In / Sign Up</title>
  <link rel="stylesheet" href="#" />  <!-- Link CSS here -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <!-- Bootstrap CSS link -->
  </head>
</head>

<body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <!-- Bootstrap JS link -->
  <header>
    <h1>Sign up Form</h1>
  </header>

  <main>
    <nav>
    <ul style="list-style: none; display: flex; gap: 1rem; justify-content: center; padding: 0;">
    <li><a href="index.html">Home</a></li>
    </ul>
  </nav>

    <section id="signup" style="margin-top: 3rem;">
      <h2>Sign Up</h2>
      <p>Create an account to get access to this social network.</p>

      <?php if ($signup_error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($signup_error); ?></p>
      <?php elseif ($signup_success): ?>
        <p style="color: green;"><?php echo htmlspecialchars($signup_success); ?></p>
      <?php endif; ?>

      <form action="forms.php" method="post">
        <fieldset>
          <legend><strong>Account Information</strong></legend>

          <label for="signup-username">Username:</label><br />
          <input type="text" id="signup-username" name="signup-username" placeholder="Enter username" required /><br /><br />

          <label for="signup-email">Email:</label><br />
          <input type="email" id="signup-email" name="signup-email" placeholder="example@email.com" required /><br /><br />

          <label for="signup-password">Password:</label><br />
          <input type="password" id="signup-password" name="signup-password" placeholder="Create a password" required /><br /><br />

          <label for="signup-confirm-password">Confirm Password:</label><br />
          <input type="password" id="signup-confirm-password" name="signup-confirm-password" placeholder="Repeat password" required /><br /><br />

          <label>
            <input type="checkbox" name="terms" required />
            I agree to the <a href="termsandcons.html">terms and conditions</a>.
          </label><br /><br />

          <button type="submit">Sign Up</button>
        </fieldset>
      </form>
    </section>

    <hr style="margin: 4rem auto; width: 60%;" />

    <section id="signin">
      <h2>Sign In</h2>
      <p>Welcome back! Log in to your account to access personalized content.</p>

      <?php if ($signin_error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($signin_error); ?></p>
      <?php endif; ?>

      <form action="forms.php" method="post">
        <fieldset>
          <legend><strong>Login Credentials</strong></legend>

          <label for="signin-email">Email:</label><br />
          <input type="email" id="signin-email" name="signin-email" placeholder="Enter your email" required /><br /><br />

          <label for="signin-password">Password:</label><br />
          <input type="password" id="signin-password" name="signin-password" placeholder="Enter your password" required /><br /><br />

          <label>
            <input type="checkbox" name="remember" />
            Remember me
          </label><br /><br />

          <button type="submit">Sign In</button>
        </fieldset>
      </form>

      <p>Forgot your password? <a href="passreset.html">Click here to reset it</a>.</p>
    </section>

  </main>



</body>
<footer style="margin-top: 4rem;">
  <address>
    <p>&copy; 2025 Malik Robinson, Ben Gives. All rights reserved.</p>
    <p><a href="termsandcons.html">Terms and Conditions</a></p>
    <p><a href="privacy.html">Privacy Policy</a></p>
    <p><a href="cookie.html">Cookie Policy</a></p>
  </address>
</footer>
</html>


