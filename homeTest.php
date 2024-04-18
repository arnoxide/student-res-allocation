<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("location: login.php");
    exit();
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<body>
    <h2>Welcome, <?php echo $user['fname'] . ' ' . $user['lname']; ?></h2>
    <p>Student Number: <?php echo $user['studentNumber']; ?></p>
    <p>Degree: <?php echo $user['degree']; ?></p>
    <!-- Display other user info here -->
</body>
</html>
