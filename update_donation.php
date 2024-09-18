<?php
require('admin/layout/db_connection.php');

$student = null;
$message = "";

// Handle search submission
if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['student_code'])) {
    $student_code = $conn->real_escape_string($_GET['student_code']);

    // Fetch student details by student code
    $sql = "SELECT * FROM students WHERE student_code = '$student_code'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        $message = "No student found with this code.";
    }
}

// Handle update submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['student_code'])) {
    $student_code = $conn->real_escape_string($_POST['student_code']);
    $date_of_last_donation = $conn->real_escape_string($_POST['date_of_last_donation']);

    // Update the last donation date in the database
    $sql = "UPDATE students SET date_of_last_donation = '$date_of_last_donation' WHERE student_code = '$student_code'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        $message = "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Last Donation Date</title>
    <link rel="stylesheet" href="admin/css/update_donation.css">
</head>
<body class="update-donation-body">
    <div class="update-container">
        <h2>Update Last Donation Date</h2>
        <?php if ($message) { ?>
            <p><?php echo $message; ?></p>
        <?php } ?>
        <!-- Search Form -->
        <form method="GET" action="">
            <div class="input-group">
                <label for="student_code">Student Code</label>
                <input type="text" id="student_code" name="student_code" required value="<?php echo isset($student_code) ? $student_code : ''; ?>">
            </div>
            <div class="input-group">
                <button type="submit">Search</button>
            </div>
            <div class="footer">
                <p>Return to <a href="index.php">Student Portal</a></p>
            </div>
        </form>

        <!-- Update Form -->
        <?php if ($student) { ?>
            <form method="POST" action="">
                <div class="input-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" value="<?php echo $student['full_name']; ?>" readonly>
                </div>
                <div class="input-group">
                    <label for="contact_number">Contact Number</label>
                    <input type="tel" id="contact_number" name="contact_number" value="<?php echo $student['contact_number']; ?>" readonly>
                </div>
                <div class="input-group">
                    <label for="date_of_last_donation">Last Donation Date</label>
                    <input type="date" id="date_of_last_donation" name="date_of_last_donation" value="<?php echo $student['date_of_last_donation']; ?>" required>
                </div>
                <input type="hidden" name="student_code" value="<?php echo $student['student_code']; ?>">
                <div class="input-group">
                    <button type="submit">Update Donation Date</button>
                </div>

            </form>
        <?php } ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>
