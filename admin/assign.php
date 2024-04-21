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

// Check if the 'studentNumber' parameter is set in the GET request
if (isset($_GET['studentNumber'])) {
    $studentNumber = $_GET['studentNumber'];
    
    // Fetch student details based on student number
    $sql = "SELECT * FROM users WHERE studentNumber = '$studentNumber'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        echo json_encode($student);
    } else {
        echo json_encode(array('error' => 'Student not found'));
    }
} else {
    echo json_encode(array('error' => 'Invalid request'));
}

if (isset($_POST['assign-room-btn'])) {
    $studentNumber = $_POST['studentNumber'];
    $roomType = $_POST['roomType'];
    $roomNumber = $_POST['roomNumber'];

    // Update the room assignment in the database
    $sql = "UPDATE applications SET roomType = '$roomType', roomNumber = '$roomNumber', status = 'assigned' WHERE studentNumber = '$studentNumber'";

    if ($conn->query($sql) === TRUE) {
        echo "Room assigned successfully";
        header("refresh:0; url=application");
    } else {
        echo "Error assigning room: " . $conn->error;
    }
}

$conn->close();

