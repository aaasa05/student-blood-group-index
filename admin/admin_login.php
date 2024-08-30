<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    require('layout/db_connection.php');

    session_start();
    if (!empty($_SESSION['isLoggedIn'])) {
        header('Location: index.php');
        exit();
    }

    $login_error = "";

    if (isset($_POST['submit'])) {
        $usernameOrEmail = $_POST['username'];
        $password = $_POST['password'];

        // Prepare statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $login_error = "Username or email is incorrect";
        } else {
            $admin = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $admin['password'])) {
                $_SESSION['isLoggedIn'] = 1;
                header('Location: index.php');
                exit();
            } else {
                $login_error = "Password is incorrect";
            }
        }
        $stmt->close();
        $conn->close();
    }
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (!empty($login_error)) { ?>
            <p class="error"><?php echo htmlspecialchars($login_error); ?></p>
        <?php } ?>
        <form action="" method="POST">
            <div class="input-group">
                <label for="username">Username or Email</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <button type="submit" name="submit">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
