<?php include('layout/topbar.php'); ?>

<div class="table-container">
    <h2>Admins List</h2>
    <table>
        <thead>
            <tr>
                <th>Admin ID</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th class="add-action-buttons">
                    <a href="admin_add.php" class="add-btn">Add</a>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch admins data from the database
            $sql = "SELECT * FROM admins";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data for each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['admin_id'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['full_name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['created_at'] . "</td>";
                    echo "<td>" . $row['updated_at'] . "</td>";
                    echo "<td class='action-buttons'>";
                    echo "<a href='admin_edit.php?id=" . $row['admin_id'] . "' class='edit-btn'>Edit</a> ";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No admins found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include('layout/bottom.php'); ?>
