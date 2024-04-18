<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}

$user = $_SESSION['user'];
?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Student Allocation | Home</title>
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
				<li class="top_li">Welcome, <?php echo $user['fname'] . ' ' . $user['lname']; ?></li>
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
      <a class="navbar-brand" href="index.html"><span class="fa fa-home"></span> Univen Res Allocation</a>
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



<section class="grids-4" id="properties">
    <div id="grids4-block" class="py-5">
       <div class="container py-md-3">
			<div class="heading text-center mx-auto">
      <h3 class="head">Univen Residences</h3>
      <p class="my-3 head"> Explore all Univen Residences.</p>
    </div>                         
    <div class="row mt-5 pt-3">
    <?php
    // Connect to your database
    $servername = "localhost";
    $username = "root"; // Change this to your database username
    $password = ""; // Change this to your database password
    $dbname = "student_allocation";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to fetch residences
    $sql = "SELECT * FROM residences";
    $result = $conn->query($sql);

    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        // Loop through each row
        while ($row = $result->fetch_assoc()) {
            // Output residence information
            echo '
            <div class="grids4-info  col-lg-4 col-md-6">
                <a href="#"><img src="admin/' . $row['mainImage'] . '" class="img-fluid" alt=""></a>
                <ul class="location-top">    
                    <li class="open-1">' . $row['location'] . '</li>
                </ul>
                <div class="info-bg">
                    <h5><a href="#">' . $row['resName'] . ' | ' . $row['residenceId'] . '</a></h5>
                    <p>' . $row['address'] . '</p>
                    <ul>
                        <li><span class="fa fa-bed"></span> ' . $row['doubleRoom'] . ' Double Rooms</li>
                        <li><span class="fa fa-bed"></span> ' . $row['singlesRoom'] . ' Single Rooms</li>
                        <li><span class="fa fa-bath"></span>3 Baths</li>
                        <li><span class="fa fa-share-square-o"></span> ' . ($row['extras'] == '1' ? 'Generator' : 'No Generator') . '</li>
                    </ul>
                    <div class="form-group">
                    <a href="res-single.php?residenceId=' . $row['residenceId'] . '" class="btn btn-success">View</a>
                </div>
                </div>
            </div>';
        }
    } else {
        echo "0 results";
    }

    // Close connection
    $conn->close();
    ?>
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
