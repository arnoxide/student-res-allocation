<?php

// Connect to your database
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

session_start();

if (!isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}

$user = $_SESSION['user'];


// Get residence ID from URL
$residenceId = isset($_GET['residenceId']) ? $_GET['residenceId'] : null;
$studentNumber = $user['studentNumber'];
// Query to fetch the residence details
$sql = "SELECT * FROM residences WHERE residenceId = '$residenceId'";
$result = $conn->query($sql);
$goal = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Check if the student has already applied for a residence
$checkSql = "SELECT * FROM applications WHERE studentNumber = '$studentNumber'";
$checkResult = $conn->query($checkSql);
$hasApplied = $checkResult->num_rows > 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $studentNumber = $user['studentNumber'];
    $residenceId = $_POST['residenceId'];
    $resName = $_POST['resName'];
    $levelOfStudy = $user['levelOfStudy'];

    if (!$hasApplied) {
        // Insert application data into the database
        $insertSql = "INSERT INTO applications (studentNumber, residenceId, resName, levelOfStudy) VALUES ('$studentNumber', '$residenceId', '$resName', '$levelOfStudy')";

        if ($conn->query($insertSql) === TRUE) {
            echo '<div class="alert alert-success">Application submitted successfully.</div>';
            // Redirect to the student dashboard
            header("Location: home.php");
        } else {
            echo "Error: " . $insertSql . "<br>" . $conn->error;
        }
    }
}


$otherImages = array();

if (!empty($goal) && isset($goal[0]['otherImages'])) {
    // Split otherImages string into an array of image URLs
    $otherImages = explode(',', $goal[0]['otherImages']);
}


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php foreach($goal as $key => $g):?>
    <title>Student Allocation | <?php echo $g['resName'];?></title>
      <?php endforeach ?>
    <!-- web fonts -->
    <link href="//fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Hind&display=swap" rel="stylesheet">
    <!-- //web fonts -->
    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css">

      <!-- jQuery -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  </head>
  <body>


<!-- Top Menu 1 -->
<section class="w3l-top-menu-1">
	<div class="top-hd">
		<div class="container">
	<header class="row">
		<div class="social-top col-lg-3 col-6">
			<li>Univen Student Accomodation</li>
			
		</div>
		<div class="accounts col-lg-9 col-6">
            <li class="top_li2">Welcome, <?php echo $user['fname'] . ' ' . $user['lname']; ?></li>
				<li class="top_li2"><a href="logout">Logout</a></li>
		</div>
		
	</header>
</div>
</div>
</section>
<!-- //Top Menu 1 -->
<section class="w3l-bootstrap-header">
  <nav class="navbar navbar-expand-lg navbar-light py-lg-2 py-2">
    <div class="container">
    <?php foreach($goal as $key => $g):?>
      <a class="navbar-brand" href="#"><span class="fa fa-home"></span> <?php echo $g['resName'];?> Residence |<span style="color:red"> <?php echo $g['location'];?></span></a>
      <?php endforeach ?>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon fa fa-bars"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="home">Home</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Check Status" data-toggle="modal" data-target="#status">My status</a>
        </li>
        </ul>
       
      </div>
    </div>
  </nav>
</section>
<section class="form-12" id="home">
<?php foreach($goal as $key => $g):?>
	<div class="form-12-content" style=" background: url('<?php echo 'admin/' . $g['mainImage']; ?>') no-repeat; background-size:cover;">
		<div class="container">
			<div class="grid grid-column-2 ">
				<div class="column2">
					</div>
				<div class="column1">
					
					
        <form action="res-single" method="POST" class="row">
    <div class="form-group col-md-6">
        <label for="fname">Res Name</label>
        <input type="text" class="form-control" id="fname" name="resName" value="<?php echo $g['resName']; ?>" readonly>
    </div>
    <div class="form-group col-md-6">
        <label for="fname">Res Code</label>
        <input type="text" class="form-control" id="resCode" name="residenceId" value="<?php echo $g['residenceId']; ?>" readonly>
    </div>
    <div class="form-group col-md-6">
        <label for="fname">Full Name:</label>
        <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $user['fname']; ?>" readonly>
    </div>
    <div class="form-group col-md-6">
        <label for="surname">Surname:</label>
        <input type="text" class="form-control" id="lname" name="surname" value="<?php echo $user['lname']; ?>" readonly>
    </div>
    <div class="form-group col-md-6">
        <label for="student_number">Student Number:</label>
        <input type="text" class="form-control" id="student_number" name="student_number" value="<?php echo $user['studentNumber']; ?>" readonly>
    </div>
    <div class="form-group col-md-6">
        <label for="degree">Degree:</label>
        <input type="text" class="form-control" id="degree" name="degree" value="<?php echo $user['degree']; ?>" readonly>
    </div>
    <div class="form-group col-md-6">
        <label for="degree">Level:</label>
        <input type="text" class="form-control" id="levelOfStudy" name="levelOfStudy" value="<?php echo $user['levelOfStudy']; ?>" readonly>
    </div>
    <div class="form-group col-md-6">
        <label for="degree">Contact:</label>
        <input type="text" class="form-control" id="Contact" name="Contact" value="<?php echo $user['Contact']; ?>" readonly>
    </div>
    <br>
    <?php if ($hasApplied) { ?>
        <div class="form-group col-md-12">
            <div class="alert alert-success">
                You have already applied for a residence. Check your status <a href="" data-toggle="modal" data-target="#status" style="font-weight: bolder;color:blue;">My Status</a>
            </div>
        </div>
    <?php } else { ?>
        <div class="form-group">
            <button type="submit" class="btn">Submit</button>
        </div>
    <?php } ?>
</form>
                    
					</div>
				
			</div>
		</div>
	</div>
    <?php endforeach ?>
</section>

<section class="locations-1" id="locations">
    <div class="locations py-5">
        <div class="container py-md-3">
            <div class="heading text-center mx-auto">
                <h3 class="head">Other Images</h3>
                <p class="my-3 head "> View the Rooms, showers, kitchens, outside, taxis, etc.</p>
            </div>
            <div class="row mt-3 pt-5">
                <?php
                // Check if other images are available
                if (!empty($otherImages)) {
                    // Initialize a counter
                    $counter = 1;
                    
                    // Loop through each other image
                    foreach ($otherImages as $image) {
                        // Output the image
                        echo '
                            <div class="col-md-4 col-sm-6">
                                <div class="box16">
                                    <img class="img-fluid" src="admin/' . $image . '" alt="">
                                    <div class="box-content">
                                        <h3 class="title">View</h3>
                                        <span class="post">' . $counter . '.</span>
                                    </div>
                                </div>
                            </div>';
                        
                        // Increment the counter
                        $counter++;
                    }
                } else {
                    // No other images found for this residence
                    echo '<p>No other images available.</p>';
                }
                ?>
            </div>
        </div>
    </div>
</section>

<!-- status modal -->
<div class="modal fade" id="status" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">My Residence Status</h5>
                <button class="btn btn-link text-dark p-0 fixed-plugin-close-button" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <?php
                 $sql = "SELECT a.*, r.location FROM applications a 
                 INNER JOIN residences r ON a.residenceId = r.residenceId 
                 WHERE a.studentNumber = '" . $user['studentNumber'] . "'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="card-body">
                            <form role="form text-left" method="POST" action="#">

                                <div class="mb-3">
                                    <label for="">Full Names:</label>
                                    <input type="text" name="fname" class="form-control" placeholder="Full-Name" aria-label="Name" aria-describedby="email-addon" value="<?php echo $user['fname'] . ' ' . $user['lname']; ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="">Student Number:</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email-addon"value="<?php echo $user['studentNumber']?>" disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="">Residence Name:</label>
                                    <input type="text" name="job" class="form-control" placeholder="Job" aria-label="job" aria-describedby="email-addon" value="<?php echo $row['resName'];?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="">Res Location:</label>
                                    <input type="text" name="location" class="form-control"  aria-label="Name" aria-describedby="email-addon" value="<?php echo $row['location'];?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="">Status:</label>
                                    <input type="text" name="location" class="form-control"  aria-label="Name" aria-describedby="email-addon" value="<?php echo $row['status'];?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="">Room Type:</label>
                                    <input type="text" name="location" class="form-control"  aria-label="Name" aria-describedby="email-addon" value="<?php echo $row['roomType'];?>"  disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="">Room Number:</label>
                                    <input type="text" name="location" class="form-control"  aria-label="Name" aria-describedby="email-addon" value="<?php echo $row['roomNumber'];?>"  disabled>
                                </div>


                        </div>
                    <?php }}?>
            </div>
            <div class="modal-footer">
                <button type="submit" name="update-profile-btn" class="btn btn-primary">Cancel Room</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
// Close connection
$conn->close();
?>

<!-- // grids block 5 -->
<script src="assets/js/jquery-3.3.1.min.js"></script>
<!-- //footer-28 block -->
</section>

<script>
    $(function () {
      $('.navbar-toggler').click(function () {
        $('body').toggleClass('noscroll');
      })
    });
  </script>
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
  </script>
  
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
  </script>

<!-- Smooth scrolling -->
<script>
    var timeout;

    function startTimer() {
        timeout = setTimeout(function() {
            window.location.href = 'index.php';
        }, 900000); // 15 minutes in milliseconds
    }

    function resetTimer() {
        clearTimeout(timeout);
        startTimer();
    }

    startTimer();

    document.onmousemove = resetTimer;
    document.onkeypress = resetTimer;
</script>


</body>

</html>
<!-- // grids block 5 -->
