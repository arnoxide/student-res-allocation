<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}

$user = $_SESSION['user'];


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_allocation";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//get id
// $residenceId = $_GET['residenceId'];

// Query to fetch the residence details
$sql = "SELECT applications.*, applications.id AS app_id, users.fname, users.lname 
        FROM applications 
        INNER JOIN users ON applications.studentNumber = users.studentNumber 
        WHERE status = 'approved'";

$result = $conn->query($sql);

if ($result !== false && $result->num_rows > 0) {
    $applications = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    // Handle the case when the query fails or returns no results
    $applications = array();
}

?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <title>Approved Applications</title>

    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.png" />

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <meta name="description" content="" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />

    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <script src="assets/vendor/js/helpers.js"></script>
    <script src="./assets/js/config.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"
        integrity="sha512-..." crossorigin="anonymous"></script>
   <!-- jQuery -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include_once('includes/dashboard-navbar.php'); ?>
            <div class="layout-page">
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center">
                                <i class="bx bx-search fs-4 lh-0"></i>
                                <input type="text" class="form-control border-0 shadow-none" placeholder="Search..."
                                    aria-label="Search..." />
                            </div>
                        </div>
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <li class="nav-item lh-1 me-3">
                                Welcome, <?php echo $user['fname'] . ' ' . $user['lname']; ?>
                            </li>
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img
                                            src="https://e7.pngegg.com/pngimages/81/570/png-clipart-profile-logo-computer-icons-user-user-blue-heroes-thumbnail.png"
                                            alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img
                                                            src="https://e7.pngegg.com/pngimages/81/570/png-clipart-profile-logo-computer-icons-user-user-blue-heroes-thumbnail.png"
                                                            alt class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span
                                                        class="fw-semibold d-block"><?php echo $user['fname'] . ' ' . $user['lname']; ?></span>
                                                    <small class="text-muted">Admin</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="logout">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"> Approved Applications</span></h4>
                        <div class="card">
                            <div class="table-responsive text-nowrap">
                                <table id="datatablesSimple" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Sn</th>
                                            <th>Student No</th>
                                            <th>Full Names</th>
                                            <th>Res Code</th>
                                            <th>Res Name</th>
                                            <th>Level of study</th>
                                            <th>Status</th>
                                            <th>Date Created</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($applications as $key => $application): ?>
                                        <tr>
                                            <td><?php echo $key + 1; ?></td>
                                            <td><?php echo $application['studentNumber']; ?></td>
                                            <td><?php echo $application['fname'] . ' ' . $application['lname']; ?>
                                            </td>
                                            <td><?php echo $application['residenceId']; ?></td>
                                            <td><?php echo $application['resName']; ?></td>
                                            <td><?php echo $application['levelOfStudy']; ?></td>
                                            <td><?php echo $application['status']; ?></td>
                                            <td><?php echo $application['date_created']; ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton<?php echo $key; ?>"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $key; ?>">
                                                    <a class="dropdown-item approve-action" href="#" data-student-number="<?php echo $application['studentNumber']; ?>"
    data-residence="<?php echo $application['resName']; ?>" data-toggle="modal" data-target="#assign">
    Assign Room
</a>
    <a class="dropdown-item reject-action" href="reject?id=<?php echo $application['studentNumber'];?>" data-student-number="<?php echo $application['studentNumber']; ?>">Reject</a>
    
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-backdrop fade"></div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
<!-- Assign Modal -->
    <div class="modal fade" id="assign" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Assign the Room</h5>
                <button class="btn btn-link text-dark p-0 fixed-plugin-close-button" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-close"></i>
                </button>
            </div>
         <!-- Inside the modal body -->
         <div class="modal-body">
    <div class="card-body">
        <form role="form text-left" method="POST" action="assign.php">
            <div class="mb-3">
                <label for="fullName">Full Name:</label>
                <input type="text" id="fullName" name="fullName" class="form-control" placeholder="Full Name" aria-label="Full Name" aria-describedby="fullName-addon" readonly>
            </div>
            <div class="mb-3">
                <label for="residenceName">Residence Name:</label>
                <input type="text" id="residenceName" name="residenceName" class="form-control" placeholder="Residence Name" aria-label="Residence Name" aria-describedby="residence-addon" readonly>
            </div>
            <div class="mb-3">
                <label for="roomType">Room Type:</label>
                <select class="form-control" name="roomType" id="roomType">
                    <option value="Double">Double Room</option>
                    <option value="Single">Single Room</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="roomNumber">Room Number:</label>
                <input type="text" id="roomNumber" name="roomNumber" class="form-control" aria-label="Room Number" aria-describedby="roomNumber-addon">
            </div>
            <input type="hidden" id="studentNumber" name="studentNumber">
            <button type="submit" name="assign-room-btn" class="btn btn-primary">Assign Room</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </form>
    </div>
</div>
</div>
        </div>
    </div>
</div>
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>
    <script src="../assets/js/main.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script>
    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }
    </script>

<script>
// JavaScript to handle the click event on Assign Room button and populate the modal
$(document).on('click', '.approve-action', function() {
    var studentNumber = $(this).data('student-number');
    var residenceName = $(this).data('residence');

    // AJAX request to fetch student details
    $.ajax({
        url: 'assign.php',
        type: 'GET',
        data: { studentNumber: studentNumber },
        success: function(response) {
            var student = JSON.parse(response);
            $('#fullName').val(student.fname + ' ' + student.lname);
            $('#residenceName').val(residenceName);
            $('#studentNumber').val(studentNumber);
        }
    });
});
</script>

    
</body>

</html>
