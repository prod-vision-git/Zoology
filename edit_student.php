<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

include 'database/database.php';
include 'header.php';

if (!isset($_GET['id'])) {
    header('Location: update_student.php');
    exit();
}

$id = $_GET['id'];

// Fetch current student data
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    echo "<p>Student not found.</p>";
    exit();
}

// Update on form submit
if (isset($_POST['update'])) {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $course = $_POST['course'];
    $semester = $_POST['semester'];
    $year = $_POST['year'];
    $roll_number = $_POST['roll_number'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];

    $update = $conn->prepare("UPDATE students 
        SET user_id=?, name=?, course=?, semester=?, year=?, roll_number=?, phone_number=?, email=? 
        WHERE id=?");
    $update->bind_param("ssssssssi", $user_id, $name, $course, $semester, $year, $roll_number, $phone_number, $email, $id);

    if ($update->execute()) {
        header("Location: update_student.php?msg=updated");
        exit();
    } else {
        echo "<p style='color:red;'>Error updating student.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Student</title>
<link rel="stylesheet" href="addstudent.css">
<style>
    .edit-container {
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        width: 450px;
        margin: 40px auto;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    input[type=text], input[type=number], input[type=email] {
        width: 100%;
        padding: 10px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 6px;
    }
    input[type=submit] {
        background: #00bcd4;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        margin-top: 10px;
    }
    input[type=submit]:hover {
        background: #0097a7;
    }
</style>
</head>
<body>
<div class="dashboard-container">
<div class="edit-container">
    <h2>Edit Student Details</h2>
    <form action="" method="post">
        <label>User ID</label>
        <input type="text" name="user_id" value="<?php echo htmlspecialchars($student['user_id']); ?>" required>

        <label>Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>

        <label>Course</label>
        <input type="text" name="course" value="<?php echo htmlspecialchars($student['course']); ?>" required>

        <label>Semester</label>
        <input type="text" name="semester" value="<?php echo htmlspecialchars($student['semester']); ?>" required>

        <label>Year</label>
        <input type="text" name="year" value="<?php echo htmlspecialchars($student['year']); ?>" required>

        <label>Roll Number</label>
        <input type="text" name="roll_number" value="<?php echo htmlspecialchars($student['roll_number']); ?>" required>

        <label>Phone Number</label>
        <input type="text" name="phone_number" value="<?php echo htmlspecialchars($student['phone_number']); ?>">

        <label>Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>">

        <input type="submit" name="update" value="Update Student">
    </form>
</div>
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
            <li><a href="settings.php">⚙️ Settings</a></li>
        </ul>

        <div class="logout">
            <a href="logout.php">🚪 Logout</a>
        </div>
    </aside>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
