<?php 
require_once '../database/authcontroller.php';
$uid = $_SESSION['id'];
$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];
// $sql = "SELECT * FROM founders JOIN industries on ";
$sql = "SELECT * FROM team_reports JOIN staff_members_tbl WHERE staff_members_tbl.team_member_id=team_reports.uid AND manager = CONCAT_WS(' ', '$fname', '$lname') OR uid='$uid'";
$result = mysqli_query($conn, $sql);
$reports = mysqli_fetch_all($result, MYSQLI_ASSOC);



?>
<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <title>TMentors</title>


<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <?php include_once('../includes/dashboard-navbar.php'); ?>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <?php include_once('../includes/top-navbar.php'); ?>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Weekly team reports</span>  </h4>
              <?php include '../database/flash-messages.php' ;?>
              <div class="row">
              
              </div><br>
            
           

              <!-- Basic Bootstrap Table -->
              <div class="card">
              
                <div class="table-responsive text-nowrap">
                
              <!--/ Basic Bootstrap Table -->

              <table id="datatablesSimple" class="table table-striped" style="width:100%">
        <thead>
            <tr>
            <th>Sn</th>
            <th>Department</th>
                <th>Manager</th>
                <th></th>
               
            </tr>
        </thead>
        <tbody>
           
        <?php
// $sql = "SELECT * FROM departments JOIN staff_members_tbl WHERE staff_members_tbl.team_member_id=team_reports.uid AND manager = CONCAT_WS(' ', '$fname', '$lname') ";
$sql ="SELECT * FROM departments";


                                     				$result = mysqli_query($conn, $sql);
			  
                                                     if (mysqli_num_rows($result) > 0) {
                                                      // output data of each row
                                                      while($row = mysqli_fetch_assoc($result)) {
                                                        // $firstName = $row["fname"];
                                                        // // $middleName = $row["middle_name"];
                                                        // $lastName = $row["lname"];
                                                
                                                        // // Extract the initials
                                                        // if (!empty($firstName) && !empty($lastName)) {
                                                        //     $initials = strtoupper($firstName[0]);
                                                        
                                                            // Check if middleName is not empty before accessing its first character
                                                            // if (!empty($middleName)) {
                                                            //     $initials .= strtoupper($middleName[0]);
                                                            // }
                                                        
                                                        //  else {
                                                         //     // Handle the case where either first name or last name is empty
                                                        //     $initials = "N/A"; // or any other suitable value
                                                        
                                                        $key = '0' ;
                                                        
                                     ?>
            <tr>
                <td><?php echo $key + 1;?></td>
                <td><?php echo $row['department_name'];?> </td>
                <td><?php echo $row['dept_manager'];?> </td>
                <td><a href="view-department?id=<?php echo $row['department_id'];?>">View Reports</a></td>
                
               
            </tr>
            <?php }};?>
            
        </tbody>
      
    </table>
            </div>
            <!-- / Content -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

   

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script>
        const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }

    </script>
 <script>
    function updateCurrentTime() {
        let currentTimeElement = document.getElementById("currentTime");
        let timeInputElement = document.getElementById("timeInput");
        let currentTime = new Date();
        let formattedTime = currentTime.toLocaleTimeString();

        currentTimeElement.textContent = "Current Time: " + formattedTime;
        timeInputElement.value = formattedTime;
    }

    // Update time every second
    setInterval(updateCurrentTime, 1000);

    // Initial update
    updateCurrentTime();
</script>

<<script>
    function updateCurrentTime() {
        let currentTimeElement = document.getElementById("currentTimes");
        let timeInputElement = document.getElementById("timeInputs");
        let currentTime = new Date();
        let formattedTime = currentTime.toLocaleTimeString();

        currentTimeElement.textContent = "Current Time: " + formattedTime;
        timeInputElement.value = formattedTime;
    }

    // Update time every second
    setInterval(updateCurrentTime, 1000);

    // Initial update
    updateCurrentTime();
</script>
  </body>
</html>
