<?php require_once 'authcontroller.php'; 
  // include 'flash-messages.php';
if (isset($_GET['token'])) {
  $token = $_GET['token'];
  verifyUser($token);

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>theBoxlab | Sign in</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
      <script src="jquery.passwordstrength.js"></script>
  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
  <script src="jquery.passwordstrength.js"></script>
<style>

    
     
      .eye{
        position: absolute;
        color: black !important;
      }
      #hide1{
        display: none;
        color: black !important;
      }
      #hide3{
        display: none;
        color: black !important;
      }
     
      .password-strength-indicator{
        font-size: 12px;
        text-align: center;
        display: inline-block;
        min-width: 20%;
        transition: 1s;
        height: 16px;
        color: white;
      }
      .password-strength-indicator.very-weak{
        background: red;
        width: 20%;
      }
      .password-strength-indicator.weak{
        background: #f6891f;
        width: 40%;
      }
      .password-strength-indicator.mediocre{
        background: #eeee00;
        width: 60%;
      }
      .password-strength-indicator.strong{
        background: #99ff33;
        width: 80%;
      }
      .password-strength-indicator.very-strong{
        background: #22cf00;
        width: 100%;
      }
</style>
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <!-- <img src="assets/img/logo.png" alt=""> -->
                  <span class="d-none d-lg-block">theBoxlab.</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Reset password</h5>
                  
                  </div>

                  <form class="row g-3 needs-validation" novalidate action="reset_password" method="post">
                  <?php include '../flash-messages.php';?>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">New password</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend"></span>
                        <input type="password" name="password" id="password" class="form-control"  required>
                        <div class="invalid-feedback">Please enter your new password.</div>
                       
                      </div>
                      <span class="eye" onclick=" myFunction()">
                <i id="hide1" class="fa fa-eye" aria-hidden="true"></i>
                <i id="hide2"class="fa fa-eye-slash" aria-hidden="true"></i>
              </span>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Confirm-Password</label>
                      <input type="password" id="myInput2" name="passwordConf" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please confirm your password!</div>
                      <span class="eye" onclick=" myFunction2()">
                <i id="hide3" class="fa fa-eye" aria-hidden="true"></i>
                <i id="hide4"class="fa fa-eye-slash" aria-hidden="true"></i>
              </span>
                    </div><br><br>

                    <br>
                    <div class="col-12"><br>
                      <button class="btn btn-primary w-100" type="submit" name="reset-password-btn">Reset password</button>
                    </div>
                  
                      <!-- DETECTING DEVICE TYPE-->
    <div>  <span><textarea hidden name="browser" id="browser"></textarea></span></div>
          <div>  <span><textarea hidden name="version"  id="version"></textarea></span></div>
          <div>  <span><textarea hidden name="layout"  id="layout"></textarea></span></div>
          <div>  <span><textarea hidden name="os"  id="os"></textarea></span></div>
          <div>  <span><textarea hidden name="description"  id="description"></textarea></span></div>
          <div>  <span><textarea hidden name="product"  id="product"></textarea></span></div>
          <div>  <span><textarea hidden name="manufacturer"  id="manufacturer"></textarea></span></div>
    <!-- END DETECTING DEVICE TYPE-->
                  </form>

                </div>
              </div>

              <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
              
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

 <!---================================================================ BOOTSTRAP-=================================== -->
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/platform/1.3.6/platform.min.js" integrity="sha512-eYPrm8TgYWg3aa6tvSRZjN4v0Z9Qx69q3RhfSj+Mf89QqwOMqmwSlsVqfp4N8NVAcZe/YeUhh9x/nM2CAOp6cA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/platform/1.3.6/platform.min.js" integrity="sha512-eYPrm8TgYWg3aa6tvSRZjN4v0Z9Qx69q3RhfSj+Mf89QqwOMqmwSlsVqfp4N8NVAcZe/YeUhh9x/nM2CAOp6cA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    document.getElementById('browser').textContent = platform.name;
    document.getElementById('version').textContent = platform.version;
    document.getElementById('layout').textContent = platform.layout;
    document.getElementById('os').textContent = platform.os;
    document.getElementById('description').textContent = platform.description;
    document.getElementById('product').textContent = platform.product;
    document.getElementById('manufacturer').textContent = platform.manufacturer;
  </script>
   <script>
    function myFunction() {
      var x = document.getElementById("password");
        var y = document.getElementById("hide1");
          var z = document.getElementById("hide2");

          if(x.type ==='password'){
            x.type = "text";
            y.style.display = "block";
            z.style.display = "none";
          }
        else{  x.type = "password";
          y.style.display = "none";
          z.style.display = "block";
        }
    }

  </script>
  <script>
    function myFunction2() {
      var x = document.getElementById("myInput2");
        var y = document.getElementById("hide3");
          var z = document.getElementById("hide4");

          if(x.type ==='password'){
            x.type = "text";
            y.style.display = "block";
            z.style.display = "none";
          }
        else{  x.type = "password";
          y.style.display = "none";
          z.style.display = "block";
        }
    }

  </script>
</body>

</html>