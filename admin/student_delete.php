<?php
// Include the database connection file
include('layout/db_connection.php'); // Ensure this file includes the database connection

// Check if the student ID is provided
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Delete the student from the database
    $sql = "DELETE FROM students WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);

    if ($stmt->execute()) {
        // Redirect to the student list page after successful deletion
        header("Location: student_list.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
