<?php include('layout/topbar.php'); ?>

<div class="table-container">
    <h2>Students List</h2>
    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Student Code</th>
                <th>Full Name</th>
                <th>Date of Birth</th>
                <th>Last Donation</th>
                <th>Gender</th>
                <th>Blood Group</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Department</th>
                <th class="add-action-buttons">
                    <a href="student_add.php" class="add-btn">Add</a>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch students data from the database
            $sql = "SELECT students.*, departments.department_name
                    FROM students
                    LEFT JOIN departments ON students.department_id = departments.department_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data for each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['student_id'] . "</td>";
                    echo "<td>" . $row['student_code'] . "</td>";
                    echo "<td>" . $row['full_name'] . "</td>";
                    echo "<td>" . $row['date_of_birth'] . "</td>";
                    echo "<td>" . $row['date_of_last_donation'] . "</td>";
                    echo "<td>" . $row['gender'] . "</td>";
                    echo "<td>" . $row['blood_group'] . "</td>";
                    echo "<td>" . $row['contact_number'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['department_name'] . "</td>";
                    echo "<td class='action-buttons'>";
                    echo "<a href='student_edit.php?id=" . $row['student_id'] . "' class='edit-btn'>Edit</a> ";
                    echo "<a href='student_delete.php?id=" . $row['student_id'] . "' class='delete-btn'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='11'>No students found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include('layout/bottom.php'); ?>
