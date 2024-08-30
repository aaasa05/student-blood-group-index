<?php
// Include the topbar layout
include('layout/topbar.php');

$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);

    // Validate form data
    if (empty($username) || empty($password) || empty($full_name) || empty($email)) {
        $message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters.";
    } else {
        // Hash the password
        $password = password_hash($password, PASSWORD_BCRYPT);

        // Insert data into the database
        $sql = "INSERT INTO admins (username, password, full_name, email)
                VALUES ('$username', '$password', '$full_name', '$email')";

        if ($conn->query($sql) === TRUE) {
            header("Location: admin_list.php");
            exit();
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<div class="form-container">
    <h2>Add Admin</h2>
    <?php if (!empty($message)) { ?>
        <p><?php echo $message; ?></p>
    <?php } ?>
    <form action="" method="POST">
        <div class="input-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username">
        </div>
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        </div>
        <div class="input-group">
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name">
        </div>
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email">
        </div>
        <div class="input-group">
            <button type="submit">Save Admin</button>
        </div>
    </form>
</div>

<?php include('layout/bottom.php') ?>
