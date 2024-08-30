<?php
// Include the database connection file
include('layout/db_connection.php'); // Ensure this file includes the database connection

// Check if the department ID is provided
if (isset($_GET['id'])) {
    $department_id = $_GET['id'];

    // Check if there are students assigned to this department
    $check_sql = "SELECT COUNT(*) as student_count FROM students WHERE department_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $department_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $row = $check_result->fetch_assoc();

    if ($row['student_count'] > 0) {
        // Department has assigned students
        echo "Cannot delete this department as there are students assigned to it.";
    } else {
        // Delete the department from the database
        $sql = "DELETE FROM departments WHERE department_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $department_id);

        if ($stmt->execute()) {
            // Redirect to the department list page after successful deletion
            header("Location: department_list.php");
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }

        $stmt->close();
    }

    $check_stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
