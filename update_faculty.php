<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

include 'header.php';
include 'database/database.php';
?>

<link rel="stylesheet" href="admin.css">

<div class="dashboard-container"> <!-- flex container -->

    <!-- Main Content -->
    <main class="main-content">
        <div class="faculty-header">
            <h2>Faculty Records</h2>
            <a href="add_faculty.php" class="btn-primary">➕ Create New Faculty</a>
        </div>

        <div class="table-container">
            <?php
            // Delete faculty if delete_id is posted
            if (isset($_POST['delete_id'])) {
                $id = $_POST['delete_id'];
                $stmt = $conn->prepare("DELETE FROM faculty WHERE id=?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                echo "<p class='success-msg'>Faculty deleted successfully.</p>";
            }

            // Fetch all faculty
            $result = $conn->query("SELECT * FROM faculty ORDER BY id DESC");

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Profile Link</th>
                        <th>Experience</th>
                        <th>Qualification</th>
                        <th>Speciality</th>
                        <th>Actions</th>
                      </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['name']}</td>
                            <td><img src='{$row['image']}' alt='{$row['name']}' style='width:60px;height:60px;border-radius:50%;'></td>
                            <td><a href='{$row['link']}' target='_blank'>View Profile</a></td>
                            <td>{$row['experience']}</td>
                            <td>{$row['qualification']}</td>
                            <td>{$row['speciality']}</td>
                            <td>
                                <form action='edit_faculty.php' method='get' style='display:inline;'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <button class='action-btn edit-btn'>Edit</button>
                                </form>
                                <form action='' method='post' style='display:inline;' onsubmit=\"return confirm('Delete this faculty?');\">
                                    <input type='hidden' name='delete_id' value='{$row['id']}'>
                                    <button class='action-btn delete-btn'>Delete</button>
                                </form>
                            </td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No faculty records found.</p>";
            }
            ?>
        </div>
    </main>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Admin Panel</h2>
        </div>

        <ul class="menu">
            <li><a href="admin_dashboard.php">📊 Dashboard</a></li>
            <li><a href="create_user.php">👤 Create User</a></li>
            <li><a href="update_faculty.php">🏫 Update Faculty</a></li>
            <li><a href="add_student.php">🎓 Create New Student</a></li>
            <li><a href="update_student.php">🎓 Update Student</a></li>
            <li><a href="settings.php">⚙️ Settings</a></li>
        </ul>

        <div class="logout">
            <a href="logout.php">🚪 Logout</a>
        </div>
    </aside>
</div>

<?php include 'footer.php'; ?>
