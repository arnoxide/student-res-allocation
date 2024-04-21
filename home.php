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
            <a class="navbar-brand" href="home"><span class="fa fa-home"></span> Univen Res Allocation</a>
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
                <a href="#"><img src="admin/' . $row['mainImage'] . '" class="img-fluid" alt="" style="height:200px;width:100%;"></a>
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
                        <li><span class="fa fa-share-square-o"></span> ' . ($row['extras'] == '1' ? 'Generator' : 'Generator') . '</li>
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
