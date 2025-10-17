<?php
include 'database/database.php';
session_start();
?>

<head>
    <link rel="stylesheet" href="login.css">
</head>

<body>
<main class="loginview">
    <h2>Login</h2>
    <form action="login.php" method="post">
        <input type="text" id="username" name="username" placeholder="username" required><br><br>
        <input type="password" id="password" name="password" placeholder="password" required><br><br>
        <input type="submit" name="login" value="Sign In">
    </form>
</main>
</body>

<?php
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user from database
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            switch ($user['role']) {
                case 'admin':
                    header('Location: admin_dashboard.php');
                    break;
                case 'teacher':
                    header('Location: teacher_dashboard.php');
                    break;
                case 'student':
                    header('Location: student_dashboard.php');
                    break;
                default:
                    echo "<p style='color:red;'>Invalid role detected.</p>";
            }
            exit();
        } else {
            echo "<p style='color:red;'>Invalid password.</p>";
        }
    } else {
        echo "<p style='color:red;'>No user found with that username.</p>";
    }

    $stmt->close();
}
?>
