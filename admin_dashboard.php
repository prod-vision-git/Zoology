<?php
session_start();

// only allow admins
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

include 'header.php'; // ✅ your shared header file
include 'database/database.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin.css"> <!-- your dashboard stylesheet -->
</head>

<body>
<div class="dashboard-container">
    
    <!-- Main Content -->
    <main class="main-content">
        <header class="topbar">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> 👋</h1>
        </header>

        <section class="dashboard-section">
            <div class="cards">
                <div class="card">
                    <h3>Total Faculty</h3>
                    <p>18</p>
                </div>
               <div class="card">
    <h3>Total Students</h3>
    <p>
        <?php
        // Fetch total students from DB
        $result = $conn->query("SELECT COUNT(*) AS total FROM students");
        $row = $result->fetch_assoc();
        echo $row['total'];
        ?>
    </p>
</div>
                <div class="card">
                    <h3>New Registrations</h3>
                    <p>12</p>
                </div>
            </div>

            <div class="content-box">
                <h2>Admin Actions</h2>
                <p>Select an option from the right menu to manage records.</p>
            </div>
        </section>
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
            <li><a href="add_student.php">🎓 create new Student</a></li>
            <li><a href="update_student.php">🎓 Update Student</a></li>
            <li><a href="settings.php">⚙️ Settings</a>
        </ul>

        <div class="logout">
            <a href="logout.php">🚪 Logout</a>
        </div>
    </aside>
</div>

<?php include 'footer.php'; ?> <!-- ✅ your shared footer -->
</body>
</html>
