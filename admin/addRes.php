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

  // Prepare the SQL query
$sql = "INSERT INTO residences (residenceId, resName, address, location, rooms, singlesRoom, doubleRoom, buses, extras, mainImage, otherImages, rules) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Check if the prepare statement failed
if (!$stmt) {
    die("Prepare statement failed: " . $conn->error);
}

// Bind parameters with the appropriate data types
$otherImagesString = implode(',', $otherImagePaths);
$stmt->bind_param("ssssiiiiisss", $residenceId, $resName, $address, $location, $rooms, $singlesRoom, $doubleRoom, $buses, $extras, $mainImagePath, $otherImagesString, $rules);

    if ($stmt->execute()) {
        echo "<script>alert('Resident Added Successfully');</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Residence</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            background-color: #f8f9fa;
        }

        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .form-group label {
            font-weight: 600;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="form-container">
            <h2 class="text-center mb-4">Add Residence</h2>
            <form action="addRes.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="resName">Residence Name</label>
                    <input type="text" class="form-control" id="resName" name="resName" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" class="form-control" id="location" name="location" required>
                </div>
                <div class="form-group">
                    <label for="rooms">Total Rooms</label>
                    <input type="number" class="form-control" id="rooms" name="rooms" required>
                </div>
                <div class="form-group">
                    <label for="singlesRoom">Single Rooms</label>
                    <input type="number" class="form-control" id="singlesRoom" name="singlesRoom" required>
                </div>
                <div class="form-group">
                    <label for="doubleRoom">Double Rooms</label>
                    <input type="number" class="form-control" id="doubleRoom" name="doubleRoom" required>
                </div>
                <div class="form-group">
                    <label for="buses">Buses Available</label>
                    <select class="form-control" id="buses" name="buses" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="extras">Extras (separate with commas)</label>
                    <input type="text" class="form-control" id="extras" name="extras">
                </div>
                <div class="form-group">
                    <label for="mainImage">Main Image</label>
                    <input type="file" class="form-control-file" id="mainImage" name="mainImage" required>
                </div>
                <div class="form-group">
                    <label for="otherImages">Other Images (multiple allowed)</label>
                    <input type="file" class="form-control-file" id="otherImages" name="otherImages[]" multiple>
                </div>
                <div class="form-group">
                    <label for="rules">Rules (document)</label>
                    <textarea class="form-control" id="rules" name="rules" rows="5"></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>