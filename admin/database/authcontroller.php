<?php
//session_start();
  require ('connection.php');
  // require_once 'emailcontroller.php';
require_once 'mailer.php';
include_once 'base_url.php';
////////////////////////REGISTERING USERS////////////////
$errors = array();
$fname = "";
$lname = "";
$phone = "";
$token = "";
$email = "";


if(isset($_POST['signup-btn'])){

$errors = array();
$fname = "";
$lname = "";
$email = "";
$phone = "";
$token = "";

  $fname = $_POST['fname'];
  $lname = $_POST['lname'];

  $email = $_POST['email'];
  //$token = $_POST['token'];
  // $password = $_POST['password'];
  // $passwordConf = $_POST['passwordConf'];
  $time = date("Y-m-d H:i:s");
  $date = date('Y-m-d', strtotime($time. ' + 6 months'));
$browser = $_POST['browser'];
$version = $_POST['version'];
$layout = $_POST['layout'];
$os = $_POST['os']; 
$description = $_POST['description'];
 $product = $_POST['product'];
  $manufacturer = $_POST['manufacturer'];
  $expiration = time() + (60 * 60); // Link expires after 60 minutes
  if (empty($fname)) {
    $errors['fname'] = "Firstname is required";
  }
  if (empty($lname)) {
    $errors['lname'] = "Lastname is required";
  }
  // if (empty($admin_users)) {
  //   $errors['admin_users'] = "Role is required";
  // }
  // if (empty($department)) {
  //   $errors['department'] = "Department is required";
  // }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors['email'] = "Invalid Email address";
  }
  if (empty($email)) {
    $errors['email'] = "Email required";
  }
  // if (empty($password)) {
  //   $errors['password'] = "Password required";
  // }
  // if ($password !== $passwordConf) {
  //   $errors['password'] = "The two passwords do not match";
  // }

  $emailQuery = "SELECT * FROM admin_users WHERE email=? LIMIT 1";
  $stmt = $conn->prepare($emailQuery);
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $userCount = $result->num_rows;
  $stmt->close();

  if ($userCount > 0){
    $errors['email'] = "Email already exists";
  }
  if (count($errors) === 0) {
    // $password = password_hash($password, PASSWORD_DEFAULT);
    $generate= "012345678910111213141516171819202abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $token=  substr(str_shuffle($generate),0,50); 
      $generate= "012345678910111213141516171819202122232425262728290313233343536373839404142434445464748495051525354555657585960616263646566676869707172737475767778798081828384858687888990919293949596979899";
  $gen=  substr(str_shuffle($generate),0,5); 
    $verified = false;
  
    $sql = "INSERT INTO admin_users (fname,lname, email, verified, token,id,password_expire_date,browser,version,layout,OS,description,active,activity_logs,img,link_expiration_time) VALUES ( ?, ?, ?,?,?,?,?,?,?,?,?,?,'0','0','user.png',?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssbsssssssss', $fname,$lname, $email, $verified, $token,$gen,$date,$browser,$version,$layout,$os,$description,$expiration);

      
    if ($stmt->execute()){

      $user_id = $conn->insert_id;
      $_SESSION['id'] = $user_id;
      $_SESSION['fname'] = $fname;
      $_SESSION['lname'] = $lname;
      $_SESSION['email'] = $email;
      $_SESSION['verified'] = $verified;

///////////////SENDING VERIFICATION EMAIL///////////////
      sendVerificationEmail($email, $token,$fname,$lname, $base_url);
///////////////////////END SENDING VERIFICATION EMAIL//////////////  

      $_SESSION['alert-class'] = "alert-success";
       echo '<script>alert("Admin user added")</script>';
  header("refresh:0; url=admin_users");
      exit();
    }else {
      $errors['db_error'] = "Database error: failed to register";
    }
  }
}
////////////////////////END REGISTERING USERS////////////////

/////////////////////////ACCTIVATE ACCOUNT LINK/////

function validateaccountToken($token,$base_url)
{ 
  global $conn;
  // Prepare and execute the select statement
  $query = "SELECT * FROM admin_users WHERE token = '$token' LIMIT 1";
  $result = mysqli_query($conn, $query);
  $user = mysqli_fetch_assoc($result);
  $_SESSION['email'] = $user['email'];
$email =  $_SESSION['email'] = $user['email'];
  if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $link_expiration_time = $user['link_expiration_time'];

      // Check if the link has expired
      if (time() < $link_expiration_time) {
          // Link is valid, allow the user to reset
          // Display the password reset form or redirect to the reset page
          // You can include the necessary HTML and form elements here
          header('location: '.$base_url.'database/activate_account?activateToken=' .$token. '"');
          echo '
         
          ';
      } else {
          // Link has expired, display an error message
          // echo "The password reset link has expired. Please request a new one.";
          echo'
          <!DOCTYPE html>
          <html lang="en">
          <head>
          <meta charset="utf-8">
          <title>Reset password</title>
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
          Password reset
          </h3>
          <p class="mt-4 mb-1">
          The password reset link has expired. Please request a new one.
          </p>
          <p class="mt-4 mb-1">
          <input type="text" value="'.$email.'"
          <a href="'.$base_url.'database/password-reset"><button class="btn btn-purple btn-lg w-100 hover-lift-light mt-4">Resend Link</button></a>
          </p>
          <!-- <p>
          Please enter the code in the field below.
          </p> -->
          <!-- <div class="row mt-4 pt-2">
          <div class="col">
          <input type="text" class="form-control form-control-lg text-center py-4" maxlength="1" >
          </div>
          <div class="col">
          <input type="text" class="form-control form-control-lg text-center py-4" maxlength="1">
          </div>
          <div class="col">
          <input type="text" class="form-control form-control-lg text-center py-4" maxlength="1">
          </div>
          <div class="col">
          <input type="text" class="form-control form-control-lg text-center py-4" maxlength="1">
          </div>
          <div class="col">
          <input type="text" class="form-control form-control-lg text-center py-4" maxlength="1">
          </div>
          </div> -->
          
          </div>
          </div>
          
          </a>
          </p>
          </div>
          </div>
          <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
          <script type="text/javascript">
            
          </script>
          </body>
          </html>';
      }
  } else {
      // Invalid or expired token, display an error message
      echo "Invalid or expired password reset token.";
  }
  exit(0);
        }

//////////////////////////////////////////////////

//////////////////////SETTING PASSWORD fOR NEW ADMIN//////////
//RESETING PASSWORD//
if (isset($_POST['activate-btn'])) {
  $password = $_POST['password'];
  $passwordConf = $_POST['passwordConf'];
  $browser = $_POST['browser'];
  $version = $_POST['version'];
  $layout = $_POST['layout'];
  $os = $_POST['os'];
  $description = $_POST['description'];
  $product = $_POST['product'];
  $manufacturer = $_POST['manufacturer'];

  if (empty($password) || empty($passwordConf)) {
    $errors['password'] = "Password required";
  }
  if ($password !== $passwordConf) {
    $errors['password'] = "The two passwords do not match";
  }
 
  $password = password_hash($password, PASSWORD_DEFAULT);
  $email = $_SESSION['email'];

  if (count($errors) == 0) {
    $sql = "UPDATE admin_users SET password='$password', verified='1', active='1' WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
             echo '<script type/javascript> alert("Your Account was successfully Activated.")</script>';
             activateEmail($email,$browser,$version,$os,$description,$product,$manufacturer,$fname,$lname,$base_url);
             header("refresh:3; url=$base_url");
      }

      exit(0);
    }
  }

////////////////////

// ////////////////////////LOGING USERS IN////////////////

if(isset($_POST['login-btn'])){
  $email = $_POST['email'];
  $password = $_POST['password'];
  $generate= "012345678910111213456831684632865635286523865238653212345678901234567895175238529652753";
  $two_factor=  substr(str_shuffle($generate),0,5); 
  $time = date("Y-m-d H:i:s");
  $browser = $_POST['browser'];
  $version = $_POST['version'];
  $layout = $_POST['layout'];
  $os = $_POST['os'];
  $description = $_POST['description'];
  $product = $_POST['product'];
  $manufacturer = $_POST['manufacturer'];
  //////////////////////////////////////////updating your session in DB=======================//////////


  /////////////////////////////end db///////////////////////
  if (empty($email)) {
    $errors['email'] = "email required";
  }
  if (empty($password)) {
   $errors['password'] = "Password required";
  }


  if (count($errors) === 0) {
    $sql = "SELECT * FROM admin_users WHERE email=? OR fname=? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $email, $fname);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
 
    /////////////////////////////////////////CHECKING IF ACCOUNT IS VERIFIED AND IF 2FA IS ENABLED///////////////////////////////
   
// Prepare the SQL statement with a parameter placeholder
$sql = "SELECT * FROM admin_users WHERE email = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Bind the email parameter to the statement
    mysqli_stmt_bind_param($stmt, "s", $email);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the row as an associative array
    $posts = mysqli_fetch_assoc($result);

    // Close the statement
    mysqli_stmt_close($stmt);
}

if ($posts) {
    // Retrieve the values from the fetched row
    $email = $posts['email'];
    $fname = $posts['fname'];
    $verified = $posts['verified'];
    $active = $posts['active'];
}

/////////////////////////////////CHECKING IF ACC EXISTS/////////////////
if ($posts < 1){
   $errors['email'] = "Account not found";
  // echo '<script>alert("'.$fname.' Account Does not exist.")</script>';
  // header("refresh:0; url=http://localhost/echo/echo-tech/echo-code/config/login");
}
/////////////////////////////////END CHECKING IF ACC EXISTS/////////////////

/////////////////////////////////CODE WHEN  ACC NOT ACTIVATED/////////////////
 elseif($verified == 0){
            // echo '<script>alert("Please Activate Your Email | '.$email.' ")</script>';
             $errors['email'] = "Please Activate Your Email | $email ";
            // header("refresh:0; url=http://localhost/echo/echo-tech/echo-code/config/login");
          }
/////////////////////////////////END CHECKING IF ACC IS ACTIVATED/////////////////

 ////////////////////////////////////////CODE WHEN 2FA IS ENABLED & INSERTING OTP IN DB////////////////////////////////////////////
   
    elseif($active == 1 AND password_verify($password, $user['password'])){
      
        $orditmsql = "UPDATE admin_users SET two_factor='$two_factor' WHERE email='$email' LIMIT 1";
        $orditmres = mysqli_query($conn, $orditmsql) or die(mysqli_error($conn));
    

        $sql = "SELECT * FROM admin_users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $tfa = mysqli_fetch_all($result, MYSQLI_ASSOC);  

     $two_factor = $tfa[0]['two_factor'];
     $email = $tfa[0]['email'];

  
    ////////======================end==================///////////////////////////////

/////////////////////////////////SENDING EMAIL IF ACC HAS 2FA/////////////////
  sendtwoLink($email, $two_factor,$fname,$base_url);
    // exit(0);
    $_SESSION['id'] = $user['id'];
    $_SESSION['fname'] = $user['fname'];
    $_SESSION['lname'] = $user['lname'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['lname'] = $user['lname'];
    $_SESSION['verified'] = $user['verified'];
    // $_SESSION['message'] = "You are now logged in!";
    $_SESSION['alert-class'] = "alert-success";
    // header("refresh:0; url='.$base_url.'database/settings/verification");
    header('location: '.$base_url.'settings/verification');
      }
        ////////======================end==================///////////////////////////////

       ///////////////////////======================CODE WHEN ACC IS  ACTIVATED & NO 2FA==================///////////////////////////////
    elseif($verified == 1 AND password_verify($password, $user['password'])){
     
      $_SESSION['id'] = $user['id'];
      $_SESSION['fname'] = $user['fname'];
      $_SESSION['lname'] = $user['lname'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['verified'] = $user['verified'];
    //   $_SESSION['message'] = "You are now logged in!";
      $_SESSION['alert-class'] = "alert-success";
     
//////LOGGING A SESSION
$uid = $_SESSION['id'];
$gen= "012345678910111213456831684632865635286523865238653212345678901234567895175238529652753";
$idgen=  substr(str_shuffle($gen),0,6); 
$iosql = "INSERT INTO admin_users_session_login (uq_id,uid,browser,version,layout,os,description,device_name,manufacturer) VALUES ('$idgen','$uid','$browser', '$version','$layout','$os','$description','$product','$manufacturer')";
$iores = mysqli_query($conn, $iosql) or die(mysqli_error($conn));

      //CHECKING IF THE DEVICE IS THE PRIMARY DEVICE
      $sql = "SELECT * FROM admin_users WHERE email='$email' LIMIT 1";
      $result = mysqli_query($conn, $sql);
      $ph = mysqli_fetch_all($result, MYSQLI_ASSOC);  

    $sb = $ph[0]['browser'];
   $sv = $ph[0]['version'];
   $sl = $ph[0]['layout'];
   $so = $ph[0]['OS'];
    $sd = $ph[0]['description'];

////////////////////////////END//////////////////////////

    /////////////CHECKING IF THE DEVICE LOGGING IN MATCHES PRIMARY DEVICE
 
    $sql = "SELECT * FROM admin_users_session_login WHERE uid='$uid' AND uq_id='$idgen' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $sl = mysqli_fetch_all($result, MYSQLI_ASSOC);  

  $ub = $sl[0]['browser'];
  $uv = $sl[0]['version'];
  $ul = $sl[0]['layout'];
 $uo = $sl[0]['os'];
  $ud = $sl[0]['description'];
  $time_log = $sl[0]['time_log'];
//////////////////////END/////////////////////////

if($ub == $sb OR $uv == $sv OR $ul == $sl OR $uo == $so OR $ud == $sd){

}else {
 ////////signed in device matches the primary device and user is logged in//////////
 accountLink($email,$fname,$ub,$uv,$ul,$uo,$ud, $time_log);
}

      ////END DEVICE///
       header('location: dashboard');
      exit();
    }
    ////////======================end==================///////////////////////////////

 
else{
      $errors['login_fail'] = "Incorrect credentials";
      }
    //}
}}


/////////////////////////////////END LOGIN/////////////////////////////////////////////////


//////////////////////////END admin_users////////////////////////////////////


////////////////////////LOGOUT/////////////////////////////////////
if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['id']);
  unset($_SESSION['username']);
  unset($_SESSION['email']);
  unset($_SESSION['verified']);
  header('location: index');
  exit();
}
///////////////////////////////END LOGOUT//////////////////////////////////////


////////////////////////////////////FORGOT PASSWORD RESET LINK//////////////////////////////
if (isset($_POST['forgot-password'])) {
  $email = $_POST['email'];

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors['email'] = "Email address is invalid";
  }
  if (empty($email)) {
    $errors['email'] = "Email required";
  }
// Prepare the SQL statement with a parameter placeholder
$sql = "SELECT * FROM admin_users WHERE email = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Bind the email parameter to the statement
    mysqli_stmt_bind_param($stmt, "s", $email);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the row as an associative array
    $posts = mysqli_fetch_assoc($result);

    // Close the statement
    mysqli_stmt_close($stmt);
}

if ($posts) {
    // Retrieve the values from the fetched row
    $email = $posts['email'];
    $fname = $posts['fname'];
    $verified = $posts['verified'];
    $active = $posts['active'];
}

/////////////////////////////////CHECKING IF ACC EXISTS/////////////////
if ($posts < 1){
  $errors['email'] = "Account not found";
 // echo '<script>alert("'.$fname.' Account Does not exist.")</script>';
 // header("refresh:0; url=http://localhost/echo/echo-tech/echo-code/config/login");
}
  if(count($errors) == 0) {
    $sql = "SELECT * FROM admin_users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    $token = $user['token'];
    sendPasswordResetLink($email, $token);
    header('location: link');
    exit(0);
  }
}
////////////////////////////////////END FORGOT PASSWORD RESET LINK//////////////////////////////

////////////////////////////////////RESETING PASSWORD//////////////////////////////
//RESETING PASSWORD//
if (isset($_POST['reset-password-btn'])) {
  $password = $_POST['password'];
  $passwordConf = $_POST['passwordConf'];
  $browser = $_POST['browser'];
  $version = $_POST['version'];
  $layout = $_POST['layout'];
  $os = $_POST['os'];
  $description = $_POST['description'];
  $product = $_POST['product'];
  $manufacturer = $_POST['manufacturer'];

  if (empty($password) || empty($passwordConf)) {
    $errors['password'] = "Password required";
  }
  if ($password !== $passwordConf) {
    $errors['password'] = "The two passwords do not match";
  }
 
  $password = password_hash($password, PASSWORD_DEFAULT);
  $email = $_SESSION['email'];

  if (count($errors) == 0) {
    $sql = "UPDATE admin_users SET password='$password' WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
             echo '<script type/javascript> alert("Your Password was successfully changed.")</script>';
             changePassword($email,$browser,$version,$os,$description,$product,$manufacturer,$fname,$lname);
      }
header("refresh:3; url=$base_url");
      exit(0);
    }
  }


function resetPassword($token)
  {
    global $conn;
    $sql = "SELECT * FROM admin_users WHERE token='$token' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    $_SESSION['email'] = $user['email'];
    header('location: database/reset_password');
    exit(0);
  } 
////////////////////////////////////END RESETING PASSWORD//////////////////////////////





//////////////////////////CHANGING OLD PASSWORD VERIFICATION//////////////////////
if(isset($_POST['change-password'])){
 
  $pass = $_POST['pass'];
  $user_id = $_SESSION['id'];
  if (empty($pass)) {
    $errors['pass'] = "Password required";
  }

  if (count($errors) === 0) {
    $sql = "SELECT * FROM users WHERE id='$user_id'";
    $stmt = $conn->prepare($sql);
 
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (password_verify($pass, $user['password'])) {

      $_SESSION['id'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['verified'] = $user['verified'];


    //   $_SESSION['message'] = "You are now logged in!";
      $_SESSION['alert-class'] = "alert-success";
      header('location: change_password');
      exit();

    }else {
      $errors['login_fail'] = "Incorrect Password";
      }
  }
}
////////////////////////// END CHANGING OLD PASSWORD VERIFICATION//////////////////////


//////////////==================OTP PASSWORD=----------LINK//
if (isset($_POST['otp-reset'])) {

  $email = $_POST['email'];
  $generate= "012345678910111213141516171819202122232425262728290313233343536373839404142434445464748495051525354555657585960616263646566676869707172737475767778798081828384858687888990919293949596979899";
  $otp=  substr(str_shuffle($generate),0,5); 
  $browser = $_POST['browser'];
  $version = $_POST['version'];
  $layout = $_POST['layout'];
  $os = $_POST['os'];
  $description = $_POST['description'];
  $product = $_POST['product'];
  $manufacturer = $_POST['manufacturer'];
  $time = date("Y-m-d H:i:s");
  $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
  $result= mysqli_query($conn, $sql);
  $check = mysqli_num_rows($result);

  if ($check < 1){
      $errors['email'] = "Account does not Exist";
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors['email'] = "Email address is invalid";
  }
  if (empty($email)) {
    $errors['email'] = "Email required";
  }

  // Generate a unique token (e.g., using random_bytes or hash functions)
  // Prepare the SQL statement with a parameter placeholder
$sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Bind the email parameter to the statement
    mysqli_stmt_bind_param($stmt, "s", $email);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the row as an associative array
    $posts = mysqli_fetch_assoc($result);

    // Close the statement
    mysqli_stmt_close($stmt);
}

if ($posts) {
    // Retrieve the values from the fetched row
    $email = $posts['email'];
    $token = $posts['token'];
}

 

  if(count($errors) == 0) {
       //otp send
       $orditmsql = "UPDATE users SET otp='$otp' WHERE email = '$email'";
       $orditmres = mysqli_query($conn, $orditmsql) or die(mysqli_error($conn));
       //end
    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
 
    $otp = $user['otp'];
    $token = $user['token'];
    sendOtpLink($email, $otp, $token,$browser,$version,$os,$description,$product,$manufacturer,$time);
    header('location: link.php');
    exit(0);
  }
}


   

//////////////=================================RESET PASSWORD WITH TIME EXPIRATION============----------===========//


if (isset($_POST['password-reset'])) {
  $email = $_POST['email'];
  $generate= "012345678910111213141516171819202122232425262728290313233343536373839404142434445464748495051525354555657585960616263646566676869707172737475767778798081828384858687888990919293949596979899";
  $otp=  substr(str_shuffle($generate),0,5); 
  $browser = $_POST['browser'];
  $version = $_POST['version'];
  $layout = $_POST['layout'];
  $os = $_POST['os'];
  $description = $_POST['description'];
  $product = $_POST['product'];
  $manufacturer = $_POST['manufacturer'];
  $time = date("Y-m-d H:i:s");
  $sql = "SELECT * FROM admin_users WHERE email='$email' LIMIT 1";
  $result= mysqli_query($conn, $sql);
  $check = mysqli_num_rows($result);

  if ($check < 1){
      $errors['email'] = "Account not found";
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors['email'] = "Email address is invalid";
  }
  if (empty($email)) {
    $errors['email'] = "Email required";
  }

  // Generate a unique token (e.g., using random_bytes or hash functions)
  // Prepare the SQL statement with a parameter placeholder
$sql = "SELECT * FROM admin_users WHERE email = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Bind the email parameter to the statement
    mysqli_stmt_bind_param($stmt, "s", $email);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the row as an associative array
    $posts = mysqli_fetch_assoc($result);

    // Close the statement
    mysqli_stmt_close($stmt);
}

if ($posts) {
    // Retrieve the values from the fetched row
    $email = $posts['email'];
    $token = $posts['token'];
}

$expiration = time() + (60 * 60); // Link expires after 60 minutes

  if(count($errors) == 0) {
       //otp send
       $orditmsql = "UPDATE admin_users SET link_expiration_time='$expiration' WHERE email = '$email'";
       $orditmres = mysqli_query($conn, $orditmsql) or die(mysqli_error($conn));
       //end
    $sql = "SELECT * FROM admin_users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
 
    $link_expiration_time = $user['link_expiration_time'];
    $token = $user['token'];
    $fname = $user['fname'];
    $lname = $user['lname'];
    TokenExpireLink($email, $link_expiration_time, $token,$browser,$version,$os,$description,$product,$manufacturer,$time,$lname,$fname,$base_url);
    header('location: link.php');
    exit(0);
  }
}



  // Check if the token in the URL is valid and not expired
  // Check if the token in the URL is valid and not expired
  function validateResetToken($token,$base_url)
  { 
      global $conn;
      // Prepare and execute the select statement
      $query = "SELECT * FROM admin_users WHERE token = '$token' LIMIT 1";
      $result = mysqli_query($conn, $query);
      $user = mysqli_fetch_assoc($result);
      $_SESSION['email'] = $user['email'];
    $email =  $_SESSION['email'] = $user['email'];
      if ($result && mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);
          $link_expiration_time = $user['link_expiration_time'];
  
          // Check if the link has expired
          if (time() < $link_expiration_time) {
              // Link is valid, allow the user to reset
              // Display the password reset form or redirect to the reset page
              // You can include the necessary HTML and form elements here
              header('location: '.$base_url.'database/reset_password?resetToken=' .$token. '');
              echo '
             
              ';
          } else {
              // Link has expired, display an error message
              // echo "The password reset link has expired. Please request a new one.";
              echo'
              <!DOCTYPE html>
              <html lang="en">
              <head>
              <meta charset="utf-8">
              <title>Reset password</title>
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
              Password reset
              </h3>
              <p class="mt-4 mb-1">
              The password reset link has expired. Please request a new one.
              </p>
              <p class="mt-4 mb-1">
              <input type="text" value="'.$email.'"
              <a href="'.$base_url.'database/password-reset"><button class="btn btn-purple btn-lg w-100 hover-lift-light mt-4">Resend Link</button></a>
              </p>
              <!-- <p>
              Please enter the code in the field below.
              </p> -->
              <!-- <div class="row mt-4 pt-2">
              <div class="col">
              <input type="text" class="form-control form-control-lg text-center py-4" maxlength="1" >
              </div>
              <div class="col">
              <input type="text" class="form-control form-control-lg text-center py-4" maxlength="1">
              </div>
              <div class="col">
              <input type="text" class="form-control form-control-lg text-center py-4" maxlength="1">
              </div>
              <div class="col">
              <input type="text" class="form-control form-control-lg text-center py-4" maxlength="1">
              </div>
              <div class="col">
              <input type="text" class="form-control form-control-lg text-center py-4" maxlength="1">
              </div>
              </div> -->
              
              </div>
              </div>
              
              </a>
              </p>
              </div>
              </div>
              <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
              <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
              <script type="text/javascript">
                
              </script>
              </body>
              </html>';
          }
      } else {
          // Invalid or expired token, display an error message
          echo "Invalid or expired password reset token.";
      }
      exit(0);
  }
//////////////=================================END RESET PASSWORD WITH TIME EXPIRATION============----------===========//





 ?>