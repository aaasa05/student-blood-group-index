<?php
// Include the topbar layout
include('layout/topbar.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $department_name = $_POST['department_name'];

    // Validate input
    if (!empty($department_name)) {
        // Insert data into the database
        $sql = "INSERT INTO departments (department_name) VALUES ('$department_name')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to the department list page (optional)
            header("Location: dept_list.php");
            exit();
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $message = "Department name is required.";
    }
}
?>

<div class="form-container">
    <h2>Add Department</h2>
    <?php if (isset($message)) { ?>
        <p><?php echo $message; ?></p>
    <?php } ?>
    <form action="" method="POST">
        <div class="input-group">
            <label for="department_name">Department Name</label>
            <input type="text" id="department_name" name="department_name" required>
        </div>
        <div class="input-group">
            <button type="submit">Save Department</button>
        </div>
    </form>
</div>

<?php include('layout/bottom.php'); ?>
