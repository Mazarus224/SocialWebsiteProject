
<!DOCTYPE html>
<html>
<head>
    <title>Display User Text</title>
</head>
<body>
    <h1>Posts:</h1>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['user_text'])) {
            $submittedText = htmlspecialchars($_POST['user_text']);

            echo "<p>" . $submittedText . "</p>";
        } else {
            echo "<p>No text was submitted.</p>";
        }
    } else {
        echo "<p>This page should be accessed via a form submission.</p>";
    }
    ?>
</body>
</html>