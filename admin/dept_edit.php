<?php
// Include the topbar layout
include('layout/topbar.php');

// Check if the department ID is provided
if (isset($_GET['id'])) {
    $department_id = $_GET['id'];

    // Fetch department data based on the provided ID
    $sql = "SELECT * FROM departments WHERE department_id = '$department_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $department = $result->fetch_assoc();
    } else {
        echo "Department not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

// Handle form submission for updating the department
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $department_name = $_POST['department_name'];

    // Validate input
    if (!empty($department_name)) {
        // Update the department data in the database
        $sql = "UPDATE departments SET 
                    department_name = '$department_name',
                    updated_at = NOW()
                WHERE department_id = '$department_id'";

        if ($conn->query($sql) === TRUE) {
            // Redirect to the department list page (optional)
            header("Location: dept_list.php");
            exit();
        } else {
            $message = "Error updating record: " . $conn->error;
        }
    } else {
        $message = "Department name is required.";
    }
}
?>

<div class="form-container">
    <h2>Edit Department</h2>
    <?php if (isset($message)) { ?>
        <p><?php echo $message; ?></p>
    <?php } ?>
    <form action="" method="POST">
        <div class="input-group">
            <label for="department_name">Department Name</label>
            <input type="text" id="department_name" name="department_name" value="<?php echo $department['department_name']; ?>" required>
        </div>
        <div class="input-group">
            <button type="submit">Update Department</button>
        </div>
    </form>
</div>

<?php include('layout/bottom.php'); ?>
