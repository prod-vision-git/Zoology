<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher') {
    header('Location: login.php');
    exit();
}
include 'header.php';
?>

<main>
    <h1>Welcome Teacher <?php echo $_SESSION['username']; ?></h1>
</main>

<?php include 'footer.php'; ?>
