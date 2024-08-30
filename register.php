<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    require('admin/layout/db_connection.php');
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get form data
        $student_code = $_POST['student_code'];
        $full_name = $_POST['full_name'];
        $date_of_birth = $_POST['date_of_birth'];
        $date_of_last_donation = $_POST['date_of_last_donation'];
        $gender = $_POST['gender'];
        $blood_group = $_POST['blood_group'];
        $contact_number = $_POST['contact_number'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $department_id = $_POST['department_id'];

        // Validate input
        if (!empty($student_code) && !empty($full_name) && !empty($date_of_birth) && !empty($gender) && !empty($blood_group) && !empty($contact_number) && !empty($email) && !empty($address) && !empty($department_id)) {
            // Insert data into the database
            $sql = "INSERT INTO students (student_code, full_name, date_of_birth, date_of_last_donation, gender, blood_group, contact_number, email, address, department_id) 
                    VALUES ('$student_code', '$full_name', '$date_of_birth', '$date_of_last_donation', '$gender', '$blood_group', '$contact_number', '$email', '$address', '$department_id')";

            if ($conn->query($sql) === TRUE) {
                // Redirect to the student list page (optional)
                header("Location: index.php");
                exit();
            } else {
                $message = "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            $message = "All fields are required.";
        }
    }

    // Fetch departments for the department dropdown
    $dept_sql = "SELECT department_id, department_name FROM departments";
    $dept_result = $conn->query($dept_sql);
    
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="admin/css/login.css">
</head>
<body class="register-body">
    <div class="register-container">
        <h2>Registration</h2>
        <?php if (isset($message)) { ?>
            <p><?php echo $message; ?></p>
        <?php } ?>
        <form action="" method="POST">
            <div class="input-group">
                <label for="student_code">Student Code</label>
                <input type="text" id="student_code" name="student_code" required>
            </div>
            <div class="input-group">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" required>
            </div>
            <div class="input-group">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" id="date_of_birth" name="date_of_birth" required>
            </div>
            <div class="input-group">
                <label for="date_of_last_donation">Last Donation</label>
                <input type="date" id="date_of_last_donation" name="date_of_last_donation">
            </div>
            <div class="input-group">
                <label for="gender">Gender</label>
                <select id="gender" name="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="input-group">
                <label for="blood_group">Blood Group</label>
                <select id="blood_group" name="blood_group" required>
                    <?php 
                    $blood_groups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
                    foreach ($blood_groups as $group) { ?>
                        <option value="<?php echo $group; ?>" <?php echo (!empty($_GET['blood_group']) && $_GET['blood_group'] == $group) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($group); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="input-group">
                <label for="contact_number">Contact Number</label>
                <input type="tel" id="contact_number" name="contact_number" required>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" required></textarea>
            </div>
            <div class="input-group">
                <label for="department_id">Department</label>
                <select id="department_id" name="department_id" required>
                    <?php while ($dept = $dept_result->fetch_assoc()) { ?>
                        <option value="<?php echo $dept['department_id']; ?>"><?php echo $dept['department_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="input-group">
                <button type="submit">Save Student</button>
            </div>
            <div class="footer">
                <p>Return to <a href="index.php">Student Portal</a></p>
            </div>
        </form>
    </div>
</body>
</html>
