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


// $studentNumber = $_POST['student_number'];
// $action = $_POST['action'];
$studentNumber = $_GET['id'];

// switch ($action) {
//     case 'approve':
//         $newStatus = 'Approved';
//         break;
//     case 'reject':
//         $newStatus = 'Rejected';
//         break;
//     case 'waiting':
//         $newStatus = 'Waiting List';
//         break;
//     default:
//         echo "Invalid action";
//         exit();
// }

// Update the status in the database
$sql = "UPDATE applications SET status = 'Waiting List' WHERE studentNumber = '$studentNumber'";

if ($conn->query($sql) === TRUE) {
    echo "Status updated successfully";
    header("refresh:0; url=application");
} else {
    echo "Error updating status: " . $conn->error;
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn->close();

