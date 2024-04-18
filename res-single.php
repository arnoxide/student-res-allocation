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

// Query to fetch the residence details
$sql = "SELECT * FROM residences WHERE residenceId = '$residenceId'";
$result = $conn->query($sql);
$goal = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $studentNumber = $user['studentNumber'];
  $residenceId = $_POST['residenceId'];
  $resName = $_POST['resName'];
  $levelOfStudy = $user['levelOfStudy'];

  // Check if the student has already applied for a residence
  $checkSql = "SELECT * FROM applications WHERE studentNumber = '$studentNumber'";
  $checkResult = $conn->query($checkSql);

  if ($checkResult->num_rows > 0) {
      // Student has already applied, handle accordingly
      echo "You have already applied for a residence.";
  } else {
      // Insert application data into the database
      $insertSql = "INSERT INTO applications (studentNumber, residenceId, resName, levelOfStudy) VALUES ('$studentNumber', '$residenceId', '$resName', '$levelOfStudy')";

      if ($conn->query($insertSql) === TRUE) {
          echo "Application submitted successfully.";
          // Redirect to the student dashboard
          header("Location: home.php");
      } else {
          echo "Error: " . $insertSql . "<br>" . $conn->error;
      }
  }
}

$conn->close();

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
  </head>
  <body>


<!-- Top Menu 1 -->
<section class="w3l-top-menu-1">
	<div class="top-hd">
		<div class="container">
	<header class="row">
		<div class="social-top col-lg-3 col-6">
			<li>Follow Us</li>
			<li><a href="#"><span class="fa fa-facebook"></span></a></li>
			<li><a href="#"><span class="fa fa-instagram"></span></a> </li>
				<li><a href="#"><span class="fa fa-twitter"></span></a></li>
				<li><a href="#"><span class="fa fa-vimeo"></span></a> </li>
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
      <a class="navbar-brand" href="index.html"><span class="fa fa-home"></span> <?php echo $g['resName'];?> Residence |<span style="color:red"> <?php echo $g['location'];?></span></a>
      <?php endforeach ?>
      <!-- if logo is image enable this   
    <a class="navbar-brand" href="#index.html">
        <img src="image-path" alt="Your logo" title="Your logo" style="height:35px;" />
    </a> -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon fa fa-bars"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.html">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.html">My status</a>
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
    <div class="form-group">
        <button type="submit" class="btn">Submit</button>
    </div>
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
        <p class="my-3 head "> Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
          Nulla mollis dapibus nunc, ut rhoncus
          turpis sodales quis. Integer sit amet mattis quam.</p>
      </div>
            <div class="row mt-3 pt-5">
                <div class="col-md-4 col-sm-6">
                    <div class="box16">
                        <img class="img-fluid" src="assets/images/g1.jpg" alt="">
                        <div class="box-content">
                            <h3 class="title">Austin</h3>
                            <span class="post">2 Listings</span>
                           
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
	 </div>
 </section>



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
