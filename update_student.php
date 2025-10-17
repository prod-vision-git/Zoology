<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Update Student Records</title>
<link rel="stylesheet" href="admin.css">
<style>
    .table-container {
        margin: 30px auto;
        width: 95%;
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    th, td {
        text-align: left;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }
    th {
        background: #1e1f25;
        color: #fff;
    }
    tr:hover { background-color: #f7f7f7; }
    .action-btn {
        padding: 6px 12px;
        margin: 2px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        color: #fff;
    }
    .edit-btn { background-color: #00bcd4; }
    .delete-btn { background-color: #f44336; }
    .edit-btn:hover { background-color: #0097a7; }
    .delete-btn:hover { background-color: #d32f2f; }
    form { display: inline; }
</style>
</head>
<body>

<div class="dashboard-container">
    <main class="main-content">
        <h2>Update Student Records</h2>

        <div class="table-container">
            <?php
            // Delete student
            if (isset($_POST['delete_id'])) {
                $id = $_POST['delete_id'];
                $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                echo "<p style='color:green;'>Student deleted successfully.</p>";
            }

            // Fetch all students
            $result = $conn->query("SELECT * FROM students ORDER BY id DESC");

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Semester</th>
                        <th>Year</th>
                        <th>Roll No</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Actions</th>
                      </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['user_id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['course']}</td>
                            <td>{$row['semester']}</td>
                            <td>{$row['year']}</td>
                            <td>{$row['roll_number']}</td>
                            <td>{$row['phone_number']}</td>
                            <td>{$row['email']}</td>
                            <td>
                                <form action='edit_student.php' method='get'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <button type='submit' class='action-btn edit-btn'>Edit</button>
                                </form>
                                <form action='' method='post' onsubmit=\"return confirm('Delete this student?');\">
                                    <input type='hidden' name='delete_id' value='{$row['id']}'>
                                    <button type='submit' class='action-btn delete-btn'>Delete</button>
                                </form>
                            </td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No students found.</p>";
            }
            ?>
        </div>
    </main>
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Admin Panel</h2>
        </div>

        <ul class="menu">
                        <li><a href="admin_dashboard.php">📊 Dashboard</a></li>
           <li><a href="create_user.php">👤 Create User</a></li>
            <li><a href="update_faculty.php">🏫 Update Faculty</a></li>
            <li><a href="add_student.php">🎓 create new Student</a></li>
            <li><a href="update_student.php">🎓 Update Student</a></li>
            <li><a href="settings.php">⚙️ Settings</a>
        </ul>

        <div class="logout">
            <a href="logout.php">🚪 Logout</a>
        </div>
    </aside>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
