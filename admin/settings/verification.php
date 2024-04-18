<?php 
require_once '../database/authcontroller.php';
// include 'flash-messages.php';
$errors = array();
$domain = $_SERVER['PHP_SELF'];
$email = $_SESSION['email'];
// $uid= $_SESSION['id'];

// $sql ="SELECT * FROM users WHERE id ='$uid'";
// $result = mysqli_query($conn, $sql);
// $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

if(isset($_GET['factor-pass']))
{
  $pass= $_GET['pass'];
  
  if($pass=="")
  {
    // echo "<center> <b>Please Write Something in Search Box!</b> </center>";
    echo "<center><script>alert ('Please Write the verification code') </script></center>";
    header("refresh:0; url='$domain'");
    exit();
  }
  
  $sql="select * from admin_users where two_factor like '%$pass%' and email ='$email'";
               
  $rs= mysqli_query($conn,$sql);
   
  if(mysqli_num_rows($rs)<1)
  {
    //   echo '<script>alert("Incorrect Code")</script>';
   echo "<center><script>alert ('incorrect Code') </script></center>";
    header("refresh:0; url='$domain'");
}
   else{
     header('location: ../dashboard');
   }
    exit();
    
  }


  
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>2FA | <?php echo $_SESSION['fname'];?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style type="text/css">
    	body{margin-top:20px;
background:#f6f9fc;
}
.icon-circle[class*=text-] [fill]:not([fill=none]), .icon-circle[class*=text-] svg:not([fill=none]), .svg-icon[class*=text-] [fill]:not([fill=none]), .svg-icon[class*=text-] svg:not([fill=none]) {
    fill: currentColor!important;
}
.svg-icon-xl>svg {
    width: 3.25rem;
    height: 3.25rem;
}

.hover-lift-light {
    transition: box-shadow .25s ease,transform .25s ease,color .25s ease,background-color .15s ease-in;
}
.mt-4 {
    margin-top: 1.5rem!important;
}
.w-100 {
    width: 100%!important;
}
.btn-group-lg>.btn, .btn-lg {
    padding: 0.8rem 1.85rem;
    font-size: 1.1rem;
    border-radius: 0.3rem;
}
.btn-purple {
    color: #fff;
    background-color: #6672e8;
    border-color: #6672e8;
}

.text-center {
    text-align: center!important;
}
.py-4 {
    padding-top: 1.5rem!important;
    padding-bottom: 1.5rem!important;
}
.form-control-lg {
    min-height: calc(1.5em + 1rem + 2px);
    padding: 0.5rem 1rem;
    font-size: 1.25rem;
    border-radius: 0.3rem;
}
.form-control {
    display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #1e2e50;
    background-color: #f6f9fc;
    background-clip: padding-box;
    border: 1px solid #dee2e6;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
    </style>
</head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" class="sign-in-form" method="get">
            <?php if(count($errors) > 0): ?>
    <div class="alert alert-danger">
     <?php foreach($errors as $error): ?>
     <li><?php echo $error; ?></li>
   <?php endforeach; ?>
   </div>
 <?php endif; ?>
<div class="row justify-content-center mt-7">
<div class="col-lg-5 text-center">
<a href="index.html">
<img src="assets/img/svg/logo.svg" alt="">
</a>
<div class="card mt-5">
<div class="card-body py-5 px-lg-5">
<div class="svg-icon svg-icon-xl text-purple">
<svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512"><title>ionicons-v5-g</title><path d="M336,208V113a80,80,0,0,0-160,0v95" style="fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></path><rect x="96" y="208" width="320" height="272" rx="48" ry="48" style="fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></rect></svg>
</div>
<h3 class="fw-normal text-dark mt-4">
2-step verification
</h3>
<p class="mt-4 mb-1">
We sent a verification code to your email.
</p>
<p>
Please enter the code in the field below in order to approve the login request.
</p>
<div class="row mt-4 pt-2">
<div class="col">
<input type="text" class="form-control form-control-lg text-center py-4" name="pass" maxlength="1" >
</div>
<div class="col">
<input type="text" class="form-control form-control-lg text-center py-4" name="pass" maxlength="1">
</div>
<div class="col">
<input type="text" class="form-control form-control-lg text-center py-4" name="pass" maxlength="1">
</div>
<div class="col">
<input type="text" class="form-control form-control-lg text-center py-4" name="pass" maxlength="1">
</div>
<div class="col">
<input type="text" class="form-control form-control-lg text-center py-4" name="pass" maxlength="1">
</div>
</div>
<input type="submit" name="factor-pass" value="Verify code"  class="btn btn-purple btn-lg w-100 hover-lift-light mt-4">

</form>
</div>
</div>
<p class="text-center text-muted mt-4">
Didn't receive it?
<a href="#!" class="text-decoration-none ms-2">
Resend code
</a>
</p>
</div>
</div>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
	
</script>
</body>
</html>