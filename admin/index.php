<?php
include('layout/topbar.php');

// Query to get the count of students
$student_count_query = "SELECT COUNT(*) as total FROM students";
$student_result = $conn->query($student_count_query);
$student_count = $student_result->fetch_assoc()['total'];

// Query to get the count of admins
$admin_count_query = "SELECT COUNT(*) as total FROM admins";
$admin_result = $conn->query($admin_count_query);
$admin_count = $admin_result->fetch_assoc()['total'];

// Query to get the count of departments
$department_count_query = "SELECT COUNT(*) as total FROM departments";
$department_result = $conn->query($department_count_query);
$department_count = $department_result->fetch_assoc()['total'];

// Close the database connection
$conn->close();
?>
<div class="dashboard-container">
    <div class="dashboard-box">
        <h3>Total Students</h3>
        <p><?php echo htmlspecialchars($student_count); ?></p>
    </div>
    <div class="dashboard-box">
        <h3>Total Admins</h3>
        <p><?php echo htmlspecialchars($admin_count); ?></p>
    </div>
    <div class="dashboard-box">
        <h3>Total Departments</h3>
        <p><?php echo htmlspecialchars($department_count); ?></p>
    </div>
</div>

<?php include('layout/bottom.php') ?>
