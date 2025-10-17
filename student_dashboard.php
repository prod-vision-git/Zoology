<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'student') {
    header('Location: login.php');
    exit();
}
include 'header.php';
?>

<main>
    <h1>Welcome Student <?php echo $_SESSION['username']; ?></h1>
</main>

<?php include 'footer.php'; ?>
