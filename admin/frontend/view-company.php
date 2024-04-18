<?php 
require_once '../database/authcontroller.php';
$id = $_GET['id'];
$sql = "SELECT * FROM founders JOIN industries on industries.industry_code=founders.industry WHERE thebox_reg_number='$id'";

$result = mysqli_query($conn, $sql);
$founders = mysqli_fetch_all($result, MYSQLI_ASSOC);


if(isset($_POST['approve-btn'])){
  $cid = $_GET['id'];
  $sql = "UPDATE founders SET approved='1' WHERE thebox_reg_number='$id' ";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    $_SESSION['message'] = 'Change was successful';
    $_SESSION['type'] = 'success';
    // header('location: '.$base_url.'dashboard');
    echo '<script>alert("Company Successfully Approved.")</script>';
    header('location: '.$base_url.'frontend/view-company?id='.$cid.'');
    }

}

if(isset($_POST['reject-btn'])){
  $reason = $_POST['reason'];
  $cid = $_GET['id'];
  $sql = "UPDATE founders SET approved='2',rejection_reason='$reason' WHERE thebox_reg_number='$id' ";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    $_SESSION['message'] = 'Change was successful';
    $_SESSION['type'] = 'success';
    echo '<script>alert("Company Successfully Rejected.")</script>';
     header('location: '.$base_url.'frontend/view-company?id='.$cid.'');
    }

}
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

    <title>View Company</title>

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
              <h4 class="fw-bold py-3 mb-4"><a href="founders"><span class="text-muted fw-light">Companies /</span></a> View Company</h4>

              <div class="row">
                <div class="col-md-12">
              
<?php foreach($founders as $key => $founder):?>
                  <div class="card mb-4">
                    <h5 class="card-header"><?php echo $founder['company_name'];?></h5>
                    <!-- Account -->
                    <div class="card-body">
                      <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img
                          src="../../founders/logo/<?php echo $founder['logo']; ?>"
                          alt="user-avatar"
                          class="d-block rounded"
                          height="100"
                          width="100"
                          id="uploadedAvatar"
                        />
                
                      </div>
                    </div>
                    <hr class="my-0" />

                    <div class="card-body">
                      <form id="formAccountSettings" method="POST" onsubmit="return false">
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label">Company Name</label>
                            <input
                              class="form-control"
                              type="text"
                              id="firstName"
                              name="firstName"
                              value="<?php echo $founder['company_name'];?>"
                              autofocus disabled/>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="lastName" class="form-label">Founder Name</label>
                            <input class="form-control" type="text" name="lastName" id="lastName" disabled value="<?php echo $founder['founder_name'];?>" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Representative E-mail</label>
                            <input class="form-control" type="text" name="lastName" id="lastName" disabled value="<?php echo $founder['rep_email'];?>" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="organization" class="form-label">Thebox Registration No</label>
                            <input class="form-control" type="text" name="lastName" id="lastName" disabled value="<?php echo $founder['thebox_reg_number'];?>" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="phoneNumber">Industry</label>
                            <div class="input-group input-group-merge">
                            
                            <input class="form-control" type="text" name="lastName" id="lastName" disabled value="<?php echo $founder['industry_name'];?>" />
                            </div>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Years in operation</label>
                            <input class="form-control" type="text" name="lastName" id="lastName" disabled value="<?php echo $founder['years_operating'];?>" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Funding goal</label>
                            <input type="text" class="form-control" id="address" name="address" disabled value="<?php echo $founder['funding_goal'];?>" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Website Address</label>
                            <input type="text" class="form-control" id="address" name="address" disabled value="<?php echo $founder['website'];?>" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Status</label>
                            <input type="text" class="form-control" id="address" name="address" disabled value="
                            <?php 
$status = $founder['approved'];
if ($status == '1'){
  echo 'Approved';
}elseif($status == '0'){
  echo 'Pending Approval';
}elseif($status == '2'){
  echo 'Rejected';
}
?>
                            " />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">CIPC registration</label>
                            <input type="text" class="form-control" id="address" name="address" disabled value="<?php echo $founder['cipc_reg'];?>" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">CIPC registration No</label>
                            <input type="text" class="form-control" id="address" name="address" disabled placeholder="<?php echo $founder['ck'];?>" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Start-up stage</label>
                            <input type="text" class="form-control" id="address" name="address" disabled value="<?php echo $founder['stage'];?>" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Capital invested</label>
                            <input type="text" class="form-control" id="address" name="address" disabled value="<?php echo $founder['invested'];?>" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Gain</label>
                            <input type="text" class="form-control" id="address" name="address" disabled value="<?php echo $founder['gain'];?>" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Company Address</label>
                            <input type="text" class="form-control" id="address" name="address" disabled value="<?php echo $founder['business_address'];?>" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Company Contact</label>
                            <input type="text" class="form-control" id="address" name="address" disabled placeholder="<?php echo $founder['phone'];?>" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Company Referal Code</label>
                            <input type="text" class="form-control" id="address" name="address" disabled value="<?php echo $founder['company_referal_code'];?>" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Redeemed Referal code</label>
                            <input type="text" class="form-control" id="address" name="address" disabled value="<?php echo $founder['redeemed_referal_code'];?>" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="state" class="form-label">Facebook</label>
                            <input class="form-control" type="text" id="state" name="state" disabled value="<?php echo $founder['facebook'];?>" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="zipCode" class="form-label">Twitter</label>
                            <input
                              type="text"
                              class="form-control"
                              id="zipCode"
                              name="zipCode" disabled
                              placeholder="231465"
                              value="<?php echo $founder['twitter'];?>"
                            />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label">Linkedin</label>
                            <input
                              class="form-control"
                              type="text"
                              id="firstName"
                              name="firstName" disabled
                              value="<?php echo $founder['linkedin'];?>"
                              autofocus
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="lastName" class="form-label">Instagram</label>
                            <a href ="mk"><input class="form-control"name="lastName" id="lastName" disabled value="<?php echo $founder['instagram'];?>" /></a>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Date Listed</label>
                            <input
                              class="form-control"
                              type="text"
                              id="email"
                              name="email"
                              value="<?php echo $founder['date_created'];?>"
                             disabled
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="organization" class="form-label">About</label>
                            <textarea name="" id=""   class="form-control" disabled><?php echo $founder['about'];?></textarea>
                          
                          </div>
                         
                      
                          <div class="mb-3 col-md-6">
                            <button data-toggle="modal" data-target="#exampleModal" class="btn btn-success">Approve Company</button>
                          </div>
                          <div class="mb-3 col-md-6">
          
                            <button data-toggle="modal" data-target="#rejectModal" class="btn btn-danger">Reject Company</button>
                          </div>
                        
                        
                      
                     
                       
                        </div>
                    
                      </form>
                    </div>
                    <!-- /Account -->

                 


                  </div>
                  <?php endforeach;?>
         
                </div>
              </div>
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

<!--------------======================================= APPROVE COMPANY mODAL-===============--------===============--->
<?php foreach($founders as $key => $founder):?>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Approve <?php echo $founder['company_name'];?></h5>
     
      </div>
      <form method="post">
        
      <div class="modal-body">
      <div class="mb-3 row">
             
                        <div class="col-md-10">
                    <p>Are you sure you want to approve <?php echo $founder['company_name'];?></p>
                        </div>
                      </div>

                  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" name="approve-btn" class="btn btn-primary">Approve Company</button>
</form>
      </div>
    </div>
  </div>
</div>
<?php endforeach;?>
<!--------------=======================================END APPROVE COMPANY-===============--------===============--->


    
<!--------------======================================= REJECT COMPANY mODAL-===============--------===============--->
<?php foreach($founders as $key => $founder):?>
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reject <?php echo $founder['company_name'];?></h5>
     
      </div>
      <form method="post">
        
      <div class="modal-body">
      <div class="mb-3 row">
             
                        <div class="col-md-10">
                    <p>Are you sure you want to Reject <?php echo $founder['company_name'];?></p>
                        </div>
                      </div>
                      <div class="mb-3 row">
                      <label for="html5-date-input" class="col-md-2 col-form-label">Reason::</label>
                        <div class="col-md-10">
                          <input class="form-control" required type="text" name="reason" id="html5-date-input" />
                        </div>
                      </div>

                  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" name="reject-btn" class="btn btn-primary">Reject Company</button>
</form>
      </div>
    </div>
  </div>
</div>
<?php endforeach;?>
<!--------------=======================================END REJECT COMPANY-===============--------===============--->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
    <script src="../assets/js/pages-account-settings-account.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
       <script src="tinymce/tinymce.min.js"></script>
    <script src="script.js"></script>
  </body>
</html>
