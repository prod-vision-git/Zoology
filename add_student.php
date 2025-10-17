<?php
session_start();

// Only allow admins
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

include 'header.php';
include 'database/database.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="addstudent.css"> <!-- same CSS as edit page -->
</head>
<body>
<div class="dashboard-container">
<main class="main-content">
    <div class="form-container">
        <h1>Add New Student</h1>
        <form action="add_student.php" method="post" class="form-box">
            <div class="form-group">
                <label>User ID</label>
                <input type="text" name="user_id" placeholder="e.g., SNP25001239" required>
            </div>

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" placeholder="Full Name" required>
            </div>

            <div class="form-group">
                <label>Course</label>
                <input type="text" name="course" placeholder="e.g., B.Sc Geology" required>
            </div>

            <div class="form-group">
                <label>Semester</label>
                <input type="text" name="semester" placeholder="e.g., 4th" required>
            </div>

            <div class="form-group">
                <label>Year</label>
                <input type="text" name="year" placeholder="e.g., 2025" required>
            </div>

            <div class="form-group">
                <label>Roll Number</label>
                <input type="text" name="roll_number" placeholder="e.g., GEO2301" required>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone_number" placeholder="10-digit phone" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="student@example.com" required>
            </div>

            <div class="form-actions">
                <input type="submit" name="add_student" value="Add Student" class="btn-primary">
                <a href="update_student.php" class="btn-secondary">Back</a>
            </div>
        </form>

        <?php
        if (isset($_POST['add_student'])) {
            $user_id = $_POST['user_id'];
            $name = $_POST['name'];
            $course = $_POST['course'];
            $semester = $_POST['semester'];
            $year = $_POST['year'];
            $roll_number = $_POST['roll_number'];
            $phone_number = $_POST['phone_number'];
            $email = $_POST['email'];

            $stmt = $conn->prepare("INSERT INTO students (user_id, name, course, semester, year, roll_number, phone_number, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $user_id, $name, $course, $semester, $year, $roll_number, $phone_number, $email);

            if ($stmt->execute()) {
                echo "<p class='success-msg'>✅ Student added successfully!</p>";
            } else {
                echo "<p class='error-msg'>❌ Error adding student: " . htmlspecialchars($conn->error) . "</p>";
            }

            $stmt->close();
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
