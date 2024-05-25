<?php
session_start();
require_once '../includes/functions.php';

// Redirect to dashboard if user is already logged in
if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}

require_once '../includes/db.php';
require_once '../templates/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO admin (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $email);

    if ($stmt->execute()) {
        echo "Signup successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="../assets/css/login.css">
         
</head>
<body>
<div class="container">
<form action="signup.php" method="POST">
      <h2>Signup</h2>
      <div class="form-group">
        <label for="login-username">Username</label>
        <input type="text" id="login-username" name="username" required>
      </div>
      <div class="form-group">
        <label for="login-password">Password:</label>
        <input type="password" id="login-password" name="password" required>
      </div>
      <div class="form-group">
        <label for="login-email">email</label>
        <input type="email" id="login-email" name="email" required>
      </div>
      <button type="submit">Login</button>
    </form>
    <h3> If you  have an account then <a href="login.php">login</a></h3>
  </div>

 

<?php require_once '../templates/footer.php'; ?>
</body>
</html>