<?php include('layout/topbar.php'); ?>

<div class="table-container">
    <h2>Departments List</h2>
    <table>
        <thead>
            <tr>
                <th>Department ID</th>
                <th>Department Name</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th class="add-action-buttons">
                    <a href="dept_add.php" class="add-btn">Add</a>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch departments data from the database
            $sql = "SELECT * FROM departments";
            $result = $conn->query($sql);

            // Get a list of department IDs that are used
            $usedDepartments = [];
            $studentSql = "SELECT DISTINCT department_id FROM students";
            $studentResult = $conn->query($studentSql);

            if ($studentResult->num_rows > 0) {
                while ($studentRow = $studentResult->fetch_assoc()) {
                    $usedDepartments[$studentRow['department_id']] = $studentRow['department_id'];
                }
            }

            if ($result->num_rows > 0) {
                // Output data for each row
                while($row = $result->fetch_assoc()) {
                    $department_id = $row['department_id'];
                    $department_name = $row['department_name'];
                    $created_at = $row['created_at'];
                    $updated_at = $row['updated_at'];
                    
                    echo "<tr>";
                    echo "<td>$department_id</td>";
                    echo "<td>$department_name</td>";
                    echo "<td>$created_at</td>";
                    echo "<td>$updated_at</td>";
                    echo "<td class='action-buttons'>";
                    // Conditionally show the delete button
                    if (isset($usedDepartments[$department_id])) {
                        echo "<span class='delete-btn disabled'>Delete</span>";
                    } else {
                        echo "<a href='dept_delete.php?id=$department_id' class='delete-btn'>Delete</a>";
                    }
                    echo "<a href='dept_edit.php?id=$department_id' class='edit-btn'>Edit</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No departments found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include('layout/bottom.php'); ?>
