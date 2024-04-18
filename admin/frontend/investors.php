<?php 
require_once '../database/authcontroller.php';
// $sql = "SELECT * FROM founders JOIN industries on ";
$sql = "SELECT * FROM founders JOIN industries on industries.industry_code=founders.industry";
$result = mysqli_query($conn, $sql);
$founders = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
    <title>Investors</title>


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
        <?php include_once('../includes/side-navbar.php'); ?>
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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Investors</span> </h4>

              <!-- Basic Bootstrap Table -->
              <div class="card">
              
                <div class="table-responsive text-nowrap">
                
              <!--/ Basic Bootstrap Table -->

              <table id="datatablesSimple" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Sn</th>
                <th>Company Name</th>
                <th>thebox Reg No</th>
                <th>Industry</th>
                <th>Founder Name</th>
                <th>Rep Email</th>
                <th>Years operating</th>
                <th>Funding Goal</th>
                <th>Status</th>
                <th>CIPC Reg</th>
                <th>CIPC Reg No</th>
                <th>Start-up Stage</th>
                <th>Contact No</th>
                <th>Date Listed</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
           
           <?php foreach($founders as $key => $founder):?>
            <tr>
                <td><?php echo $key + 1;?></td>
                <td><?php echo $founder['company_name'];?></td>
                <td><?php echo $founder['thebox_reg_number'];?></td>
                <td><?php echo $founder['industry_name'];?></td>
                <td><?php echo $founder['founder_name'];?></td>
                <td><?php echo $founder['rep_email'];?></td>
                <td><?php echo $founder['years_operating'];?></td>
                <td><?php echo $founder['funding_goal'];?></td>
                <td>
<?php 
$status = $founder['approved'];
if ($status == '1'){
  echo '<span class="badge bg-label-success me-1">Approved</span>';
}elseif($status == '0'){
  echo '<span class="badge bg-label-warning me-1">Pending Approval</span>';
}elseif($status == '2'){
  echo '<span class="badge bg-label-danger me-1">Rejected</span>';
}
?>
                </td>
                <td><?php echo $founder['cipc_reg'];?></td>
                <td><?php echo $founder['ck'];?></td>
                <td><?php echo $founder['stage'];?></td>
                <td><?php echo $founder['phone'];?></td>
                <td><?php echo $founder['date_created'];?></td>
                <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="view-company?id=<?php echo $founder['thebox_reg_number'];?>"
                                ><i class="bx bx-edit-alt me-2"></i> View Company</a
                              >
                            
                            </div>
                          </div>
                        </td>
                    
          
            </tr>
            <?php endforeach;?>
            
        </tbody>
        <tfoot>
        <tr>
                <th>Sn</th>
                <th>Company Name</th>
                <th>thebox Reg No</th>
                <th>Industry</th>
                <th>Founder Name</th>
                <th>Rep Email</th>
                <th>Years operating</th>
                <th>Funding Goal</th>
                <th>Status</th>
                <th>CIPC Reg</th>
                <th>CIPC Reg No</th>
                <th>Start-up Stage</th>
                <th>Contact No</th>
                <th>Date Listed</th>
                <th>Action</th>
            </tr>
        </tfoot>
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

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script>
        const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }

    </script>
  </body>
</html>
