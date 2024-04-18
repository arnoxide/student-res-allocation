<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_allocation";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate a unique residenceId
function generateResidenceId() {
    $prefix = 'UNV';
    $random = mt_rand(10000, 99999);
    $residenceId = $prefix . $random;
    return $residenceId;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $resName = $_POST["resName"];
    $address = $_POST["address"];
    $location = $_POST["location"];
    $rooms = $_POST["rooms"];
    $singlesRoom = $_POST["singlesRoom"];
    $doubleRoom = $_POST["doubleRoom"];
    $buses = $_POST["buses"];
    $extras = $_POST["extras"];
    $rules = $_POST["rules"];

    // Generate a unique residenceId
    $residenceId = generateResidenceId();

    // Handle file uploads
    $mainImagePath = 'uploads/' . basename($_FILES["mainImage"]["name"]);
    move_uploaded_file($_FILES["mainImage"]["tmp_name"], $mainImagePath);

    $otherImagePaths = [];
    if (isset($_FILES["otherImages"])) {
        $otherImages = $_FILES["otherImages"];
        $totalFiles = count($otherImages["name"]);

        for ($i = 0; $i < $totalFiles; $i++) {
            $filePath = 'uploads/' . basename($otherImages["name"][$i]);
            move_uploaded_file($otherImages["tmp_name"][$i], $filePath);
            $otherImagePaths[] = $filePath;
        }
    }

    $otherImagePathsStr = implode(',', $otherImagePaths);

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("INSERT INTO Residences (residenceId, resName, address, location, rooms, singlesRoom, doubleRoom, buses, extras, mainImage, otherImages, rules) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiiiiissss", $residenceId, $resName, $address, $location, $rooms, $singlesRoom, $doubleRoom, $buses, $extras, $mainImagePath, $otherImagePathsStr, $rules);

    if ($stmt->execute()) {
        echo "Residence added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>