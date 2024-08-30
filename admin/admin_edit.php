<?php
// Include the topbar layout
include('layout/topbar.php');

// Message variable for displaying errors or success messages
$message = "";

// Check if the admin ID is provided
if (isset($_GET['id'])) {
    $admin_id = $_GET['id'];

    // Fetch admin data based on the provided ID
    $sql = "SELECT * FROM admins WHERE admin_id = '$admin_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
    } else {
        echo "Admin not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

// Handle form submission for updating the admin
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);

    // Validate form data
    if (empty($username) || empty($full_name) || empty($email)) {
        $message = "All fields except password are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } elseif (!empty($password) && strlen($password) < 6) {
        $message = "Password must be at least 6 characters.";
    } else {
        // Hash new password if provided, else keep old password
        $password = !empty($password) ? password_hash($password, PASSWORD_BCRYPT) : $admin['password'];

        // Update the admin data in the database
        $sql = "UPDATE admins SET 
                    username = '$username',
                    password = '$password',
                    full_name = '$full_name',
                    email = '$email',
                    updated_at = NOW()
                WHERE admin_id = '$admin_id'";

        if ($conn->query($sql) === TRUE) {
            // Redirect to the admin list page (optional)
            header("Location: admin_list.php");
            exit();
        } else {
            $message = "Error updating record: " . $conn->error;
        }
    }
}
?>

<div class="form-container">
    <h2>Edit Admin</h2>
    <?php if (!empty($message)) { ?>
        <p><?php echo $message; ?></p>
    <?php } ?>
    <form action="" method="POST">
        <div class="input-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo $admin['username']; ?>">
        </div>
        <div class="input-group">
            <label for="password">Password (leave blank to keep current password)</label>
            <input type="password" id="password" name="password">
        </div>
        <div class="input-group">
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo $admin['full_name']; ?>">
        </div>
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $admin['email']; ?>">
        </div>
        <div class="input-group">
            <button type="submit">Update Admin</button>
        </div>
    </form>
</div>

<?php include('layout/bottom.php') ?>
