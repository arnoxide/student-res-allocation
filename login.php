<?php
session_start();

// Connect to MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$database = "student_allocation";
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentNumber = $_POST['studentNumber'];
    $pin = $_POST['pin'];

    $sql = "SELECT * FROM users WHERE studentNumber = '$studentNumber' AND pin = '$pin'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user'] = $row;
        header("location: home.php");
    } else {
        echo "Invalid student number or pin.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Student Number: <input type="text" name="studentNumber" required><br><br>
        PIN: <input type="password" name="pin" required><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>

<?php
mysqli_close($conn);
?>
