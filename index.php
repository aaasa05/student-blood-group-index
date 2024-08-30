<?php
require('admin/layout/db_connection.php');

// Fetch departments for the filter dropdown
$departments = [];
$dept_sql = "SELECT department_id, department_name FROM departments";
$dept_result = $conn->query($dept_sql);

if ($dept_result->num_rows > 0) {
    while ($dept = $dept_result->fetch_assoc()) {
        $departments[] = $dept;
    }
}

// Fetch blood groups for the filter dropdown
$blood_groups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

// Build query for students based on filters
$whereClauses = [];
if (!empty($_GET['department_id'])) {
    $department_id = intval($_GET['department_id']);
    $whereClauses[] = "department_id = $department_id";
}
if (!empty($_GET['blood_group'])) {
    $blood_group = $conn->real_escape_string($_GET['blood_group']);
    $whereClauses[] = "blood_group = '$blood_group'";
}
$whereSql = count($whereClauses) > 0 ? 'WHERE ' . implode(' AND ', $whereClauses) : '';

$sql = "SELECT * FROM students $whereSql";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Group Index</title>
    <link rel="stylesheet" href="admin/css/blood_index.css">
</head>
<body>
    <div class="container">
        <h1>Blood Group Index</h1>
        <div class="button-container">
            <a href="register.php" class="action-btn register-btn">Interested to Donate? Register</a>
            <a href="update_donation.php" class="action-btn update-btn">Update Last Donation Date</a>
            <a href="admin/admin_login.php" class="action-btn admin-btn update-btn">Admin Login</a>
        </div>
        
        <!-- Search Form -->
        <form method="GET" action="">
            <div class="search-container">
                <div class="input-group">
                    <label for="department_id">Department</label>
                    <select id="department_id" name="department_id">
                        <option value="">All Departments</option>
                        <?php foreach ($departments as $dept) { ?>
                            <option value="<?php echo $dept['department_id']; ?>" <?php echo (!empty($_GET['department_id']) && $_GET['department_id'] == $dept['department_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($dept['department_name']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="input-group">
                    <label for="blood_group">Blood Group</label>
                    <select id="blood_group" name="blood_group">
                        <option value="">All Blood Groups</option>
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
                    <label for="search">&nbsp;</label>
                    <button name="search" type="submit">Search</button>
                </div>
            </div>
        </form>

        <!-- Results Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Student Code</th>
                        <th>Full Name</th>
                        <th>Date of Birth</th>
                        <th>Last Donation</th>
                        <th>Gender</th>
                        <th>Blood Group</th>
                        <th>Contact Number</th>
                        <th>Email</th>
                        <th>Department</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Fetch department name for this student
                            $dept_sql = "SELECT department_name FROM departments WHERE department_id = " . $row['department_id'];
                            $dept_result = $conn->query($dept_sql);
                            $department_name = $dept_result->num_rows > 0 ? $dept_result->fetch_assoc()['department_name'] : 'N/A';
                            
                            // Calculate the age
                            $dob = new DateTime($row['date_of_birth']);
                            $now = new DateTime();
                            $age = $now->diff($dob)->y; // Get the difference in years

                            // Calculate the number of months since the last donation
                            if(!empty($row['date_of_last_donation']) && ($row['date_of_last_donation'] != '0000-00-00')){ 
                                 $lastDonation = new DateTime($row['date_of_last_donation']);
                                 $monthsSinceDonation = $now->diff($lastDonation)->m + ($now->diff($lastDonation)->y * 12);

                            } else{
                                $monthsSinceDonation = "no";
                            }
                           

                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['student_code']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($age) . " years</td>"; // Display the age
                            echo "<td>" . htmlspecialchars($monthsSinceDonation) . " months</td>"; // Display the months since donation
                            echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['blood_group']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['contact_number']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($department_name) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No students found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>
