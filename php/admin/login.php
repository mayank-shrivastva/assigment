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
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with that username.";
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
        <form action="login.php" method="post" class="login-form">
            <h2>Login</h2>
            <?php if(isset($error)) { ?>
                <div class="error"><?php echo $error; ?></div>
            <?php } ?>
            <div class="form-group">
                <label for="login-username">Email:</label>
                <input type="text" id="login-username" name="username" required>
            </div>
            <div class="form-group">
                <label for="login-password">Password:</label>
                <input type="password" id="login-password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <h3> If you don't have an account then <a href="signup.php">signup</a></h3>
    </div>
    <?php require_once '../templates/footer.php'; ?>
</body>
</html>
