<?php
// Include the topbar layout
include('layout/topbar.php');

// Check if the student ID is provided
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Fetch student data based on the provided ID
    $sql = "SELECT * FROM students WHERE student_id = '$student_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "Student not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

// Handle form submission for updating the student
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_code = $_POST['student_code'];
    $full_name = $_POST['full_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $blood_group = $_POST['blood_group'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $department_id = $_POST['department_id'];

    // Validate input
    if (!empty($student_code) && !empty($full_name) && !empty($date_of_birth) && !empty($gender) && !empty($blood_group) && !empty($contact_number) && !empty($email) && !empty($address) && !empty($department_id)) {
        // Update student data in the database
        $sql = "UPDATE students SET 
                    student_code = '$student_code',
                    full_name = '$full_name',
                    date_of_birth = '$date_of_birth',
                    gender = '$gender',
                    blood_group = '$blood_group',
                    contact_number = '$contact_number',
                    email = '$email',
                    address = '$address',
                    department_id = '$department_id',
                    updated_at = NOW()
                WHERE student_id = '$student_id'";

        if ($conn->query($sql) === TRUE) {
            // Redirect to the student list page (optional)
            header("Location: student_list.php");
            exit();
        } else {
            $message = "Error updating record: " . $conn->error;
        }
    } else {
        $message = "All fields are required.";
    }
}

// Fetch departments for the department dropdown
$dept_sql = "SELECT department_id, department_name FROM departments";
$dept_result = $conn->query($dept_sql);
?>

<div class="form-container">
    <h2>Edit Student</h2>
    <?php if (isset($message)) { ?>
        <p><?php echo $message; ?></p>
    <?php } ?>
    <form action="" method="POST">
        <div class="input-group">
            <label for="student_code">Student Code</label>
            <input type="text" id="student_code" name="student_code" value="<?php echo $student['student_code']; ?>" required>
        </div>
        <div class="input-group">
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo $student['full_name']; ?>" required>
        </div>
        <div class="input-group">
            <label for="date_of_birth">Date of Birth</label>
            <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo $student['date_of_birth']; ?>" required>
        </div>
        <div class="input-group">
            <label for="gender">Gender</label>
            <select id="gender" name="gender" required>
                <option value="Male" <?php if ($student['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if ($student['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                <option value="Other" <?php if ($student['gender'] == 'Other') echo 'selected'; ?>>Other</option>
            </select>
        </div>
        <div class="input-group">
            <label for="blood_group">Blood Group</label>
            <input type="text" id="blood_group" name="blood_group" value="<?php echo $student['blood_group']; ?>" required>
        </div>
        <div class="input-group">
            <label for="contact_number">Contact Number</label>
            <input type="tel" id="contact_number" name="contact_number" value="<?php echo $student['contact_number']; ?>" required>
        </div>
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $student['email']; ?>" required>
        </div>
        <div class="input-group">
            <label for="address">Address</label>
            <textarea id="address" name="address" required><?php echo $student['address']; ?></textarea>
        </div>
        <div class="input-group">
            <label for="department_id">Department</label>
            <select id="department_id" name="department_id" required>
                <?php while ($dept = $dept_result->fetch_assoc()) { ?>
                    <option value="<?php echo $dept['department_id']; ?>" <?php if ($dept['department_id'] == $student['department_id']) echo 'selected'; ?>><?php echo $dept['department_name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="input-group">
            <button type="submit">Update Student</button>
        </div>
    </form>
</div>

<?php include('layout/bottom.php'); ?>
