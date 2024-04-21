<?php
session_start();

if (!isset($_SESSION['user'])) {
    echo "Unauthorized access";
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_allocation";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentNumber = $_POST['studentNumber'];
    $roomType = $_POST['roomType'];
    $roomNumber = $_POST['roomNumber'];

    $sql = "UPDATE applications SET roomType = '$roomType', roomNumber = '$roomNumber', status = 'assigned' WHERE studentNumber = '$studentNumber'";

    if ($conn->query($sql) === TRUE) {
        echo "Room assigned successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();