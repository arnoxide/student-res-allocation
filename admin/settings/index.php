<?php
require_once '../database/authcontroller.php';
$uid = $_SESSION['id'];
  // include 'flash-messages.php';
$errors = array();
$pin ="";
$confirm = "";
$domain = $_SERVER['PHP_SELF'];

///////////////////-====================////ENABLING 2FA///////////////////////////
if (isset($_POST['enable'])){

        $sql = "UPDATE admin_users SET active='1' WHERE id='$uid'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
          $_SESSION['message'] = 'Two factor authentication Successfully Enabled';
          $_SESSION['type'] = 'success';
          }
    }
///////////////////////-===========END ENABLING 2FA///////////////////////////


///////////////////-====================////DISABLING 2FA///////////////////////////
if (isset($_POST['disable'])){

    $sql = "UPDATE admin_users SET active='0' WHERE id='$uid'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $_SESSION['messages'] = 'Two factor authentication Successfully Disabled';
      $_SESSION['types'] = 'danger';
          
      }
}
///////////////////////-===========END DISABLING 2FA///////////////////////////


///////////////////-====================////ENABLING activity_logs///////////////////////////
if (isset($_POST['enablelogs'])){

    $sql = "UPDATE admin_users SET activity_logs='1' WHERE id='$uid'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $_SESSION['message'] = 'Activity Logs Successfully Enabled';
          $_SESSION['type'] = 'success';
          
      }
}
///////////////////////-===========END ENABLING activity_logs///////////////////////////


///////////////////-====================////DISABLING activity_logs///////////////////////////
if (isset($_POST['disablelogs'])){

$sql = "UPDATE admin_users SET activity_logs='0' WHERE id='$uid'";
$result = mysqli_query($conn, $sql);
if ($result) {
  $_SESSION['messages'] = 'Activity logs successfully Disabled';
          $_SESSION['types'] = 'danger';
          
  }
}
///////deletiing acc
if (isset($_POST['delete'])){
  $sql = "DELETE FROM admin_users WHERE id='$uid'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    echo '<script type/javascript> alert("Your Account has been successfully deleted.")</script>';
    header("refresh:0; url=http://localhost/echo/echo-tech/echo-code/core");
    }
  }
///////////////////////-===========END DISABLING activity_logs///////////////////////////
$sql = "SELECT * FROM admin_users WHERE id='$uid'";
$result = mysqli_query($conn, $sql);
$enabled = mysqli_fetch_all($result, MYSQLI_ASSOC);  
// $theme = $enabled[0]['theme']; 
// $domain = $enabled[0]['domain'];

////////////////////////UPLOADING IMAGE/////////////////=---------------

$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $uid"));

if(isset($_FILES["img"]["name"])){
  $id = $_POST["id"];
  $fname = $_POST["fname"];

  $imageName = $_FILES["img"]["name"];
  $imageSize = $_FILES["img"]["size"];
  $tmpName = $_FILES["img"]["tmp_name"];

  // Image validation
  $validImageExtension = ['jpg', 'jpeg', 'png','gif'];
  $imageExtension = explode('.', $imageName);
  $imageExtension = strtolower(end($imageExtension));
  if (!in_array($imageExtension, $validImageExtension)){
    echo
    "
    <script>
      alert('Invalid Image Extension');
      document.location.href = '$domain';
    </script>
    ";
  }
  elseif ($imageSize > 120000000000000){
    echo
    "
    <script>
      alert('Image Size Is Too Large');
      document.location.href = '$domain';
    </script>
    ";
  }
  else{
    $newImageName = $fname . " - " . date("Y.m.d") . " - " . date("h.i.sa"); // Generate new image name
    $newImageName .= '.' . $imageExtension;
    $query = "UPDATE users SET img = '$newImageName' WHERE id = $uid";
    mysqli_query($conn, $query);
    move_uploaded_file($tmpName, '../assets/images/users/' . $newImageName);
    echo
    "
    <script>
    document.location.href = '$domain';
    </script>
    ";
  }
}
/////////////////////END IMAGE////////-=============
///////////////////-====================////DISABLING activity_logs///////////////////////////
if (isset($_POST['verify'])){
$oldemail = $_POST['oldemail'];
$newemail = $_POST['newemail'];
$generate= "012345678910111213141516171819202122232425262728290313233343536373839404142434445464748495051525354555657585960616263646566676869707172737475767778798081828384858687888990919293949596979899";
  $pin=  substr(str_shuffle($generate),0,5); 
  $sql = "SELECT * FROM users WHERE id='$uid'";
  $result = mysqli_query($conn, $sql);
  if ($newemail !== $oldemail) {
    $errors['newmail'] = "Email Does not match";
    }
    else{
      $_SESSION['message'] = 'Email Verified';
      $_SESSION['type'] = 'success';
     header("refresh:2; url=http://localhost/echo/echo-tech/echo-code/core/database/settings/old_email");
     $sql = "SELECT * FROM users WHERE id='$uid' LIMIT 1";
     $result = mysqli_query($conn, $sql);
     $enabled = mysqli_fetch_all($result, MYSQLI_ASSOC);
     $otp = $enabled[0]['otp']; 
     sendEmailChangeLink($oldemail, $pin);

     $sql = "UPDATE users SET otp='$pin' WHERE id='$uid'";
     $result = mysqli_query($conn, $sql);
     
    }
  }

$sql = "SELECT * FROM social_links WHERE uid=$uid";
$result = mysqli_query($conn, $sql);
$social = mysqli_fetch_all($result, MYSQLI_ASSOC);  

if (isset($_POST['socials'])){
  $website = filter_var($_POST['website'], FILTER_SANITIZE_STRING);
  $twitter = filter_var($_POST['twitter'], FILTER_SANITIZE_STRING);
  $facebook = filter_var($_POST['facebook'], FILTER_SANITIZE_STRING);
  $instagram = filter_var($_POST['instagram'], FILTER_SANITIZE_STRING);
  $github = filter_var($_POST['github'], FILTER_SANITIZE_STRING);
  $google = filter_var($_POST['google'], FILTER_SANITIZE_STRING);
  $youtube = filter_var($_POST['youtube'], FILTER_SANITIZE_STRING);
  $linkedin = filter_var($_POST['linkedin'], FILTER_SANITIZE_STRING);

// $website = $_POST['website'];
// $twitter = $_POST['twitter'];
// $facebook = $_POST['facebook'];
// $instagram = $_POST['instagram'];
// $github = $_POST['github'];
// $google = $_POST['google'];
// $youtube = $_POST['youtube'];
// $linkedin = $_POST['linkedin'];

// if($userCount < 1){
//   $isql = "INSERT INTO social_links (website, twitter, facebook,instagram,github,google,youtube,linkedin,uid) VALUES ('$website', '$twitter','$facebook','$instagram','$github','$google','$youtube','$linkedin','$uid')";
//   $ires = mysqli_query($conn, $isql) or die(mysqli_error($conn));
//   if ($ires) {
//     $_SESSION['message'] = 'Profile saved';
//         $_SESSION['type'] = 'success';
//     }
// }
// else{
// $sql = "UPDATE social_links SET website='$website', twitter='$twitter', facebook='$facebook', instagram='$instagram', github='$github', google='$google', youtube='$youtube', linkedin='$linkedin' WHERE uid=$uid";
// $result = mysqli_query($conn, $sql);
// if ($result) {
//   $_SESSION['message'] = 'Activity Logs Successfully Enabled';
//       $_SESSION['type'] = 'success';
      
//   }
// }

$sql = "SELECT * FROM social_links WHERE uid=$uid";
$res = mysqli_query($conn, $sql);
$r = mysqli_fetch_assoc($res);
$count = mysqli_num_rows($res);
if($count == 1){
  //update data in tutors table
  $usql = "UPDATE social_links SET website='$website', twitter='$twitter', facebook='$facebook', instagram='$instagram', github='$github', google='$google', youtube='$youtube', linkedin='$linkedin' WHERE uid=$uid";
  $ures = mysqli_query($conn, $usql) or die(mysqli_error($conn));
  if($ures){
    $_SESSION['message'] = 'Profile saved';
    $_SESSION['type'] = 'success';
  }
}else{
  //insert data in tutors table
  $isql = "INSERT INTO social_links (website, twitter, facebook,instagram,github,google,youtube,linkedin,uid) VALUES ('$website', '$twitter','$facebook','$instagram','$github','$google','$youtube','$linkedin','$uid')";
  $ires = mysqli_query($conn, $isql) or die(mysqli_error($conn));
  if($ires){
    $_SESSION['message'] = 'Profile saved';
    $_SESSION['type'] = 'success';
  }

}}

// if (isset($_POST['socials'])){
//     $website = filter_var($_POST['website'], FILTER_SANITIZE_STRING);
//     $twitter = filter_var($_POST['twitter'], FILTER_SANITIZE_STRING);
//     $facebook = filter_var($_POST['facebook'], FILTER_SANITIZE_STRING);
//     $instagram = filter_var($_POST['instagram'], FILTER_SANITIZE_STRING);
//     $github = filter_var($_POST['github'], FILTER_SANITIZE_STRING);
//     $google = filter_var($_POST['google'], FILTER_SANITIZE_STRING);
//     $youtube = filter_var($_POST['youtube'], FILTER_SANITIZE_STRING);
//     $linkedin = filter_var($_POST['linkedin'], FILTER_SANITIZE_STRING);

// 		$sql = "SELECT * FROM social_links WHERE uid=$uid";
// $res = mysqli_query($conn, $sql);
// $r = mysqli_fetch_assoc($res);
// $count = mysqli_num_rows($res);
// 		if($count == 1){
// 			//update data in usersmeta table
//       $usql = "UPDATE social_links SET website='$website', twitter='$twitter', facebook='$facebook', instagram='$instagram', github='$github', google='$google', youtube='$youtube', linkedin='$linkedin' WHERE uid=$uid";
// 			$ures = mysqli_query($conn, $usql) or die(mysqli_error($conn));
// 			if($ures){

//         $_SESSION['message'] = 'Profile saved';
//         $_SESSION['type'] = 'success';
// 		}else{
// 			//insert data in usersmeta table
//       $isql = "INSERT INTO social_links (website, twitter, facebook,instagram,github,google,youtube,linkedin,uid) VALUES ('$website', '$twitter','$facebook','$instagram','$github','$google','$youtube','$linkedin','$uid')";
// 			$ires = mysqli_query($conn, $isql) or die(mysqli_error($conn));
//       echo $isql;
// 			if($ires){
//         $_SESSION['message'] = 'Profile saved';
//         $_SESSION['type'] = 'success';
// 			}

// 		}
// 	}

// }

$sql = "SELECT * FROM social_links WHERE uid=$uid";
$res = mysqli_query($conn, $sql);
$r = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--  This file has been downloaded from bootdey.com @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
	<!--  If you want to help us go here https://www.bootdey.com/help-us -->
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
    <style type="text/css">
body{
    margin-top:20px;
    color: #1a202c;
    text-align: left;
    background-color: #e2e8f0;    
}
.main-body {
    padding: 15px;
}

.nav-link {
    color: #4a5568;
}
.card {
    box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;
}

.card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1rem;
}

.gutters-sm {
    margin-right: -8px;
    margin-left: -8px;
}

.gutters-sm>.col, .gutters-sm>[class*=col-] {
    padding-right: 8px;
    padding-left: 8px;
}
.mb-3, .my-3 {
    margin-bottom: 1rem!important;
}

.bg-gray-300 {
    background-color: #e2e8f0;
}
.h-100 {
    height: 100%!important;
}
.shadow-none {
    box-shadow: none!important;
}
.upload{
  width: 125px;
  position: relative;
  margin: auto;
}

.upload img{
  border-radius: 50%;
  border: 8px solid #DCDCDC;
}

.upload .round{
  position: absolute;
  bottom: 0;
  right: 0;
  background: #00B4FF;
  width: 32px;
  height: 32px;
  line-height: 33px;
  text-align: center;
  border-radius: 50%;
  overflow: hidden;
}

.upload .round input[type = "file"]{
  position: absolute;
  transform: scale(2);
  opacity: 0;
}

input[type=file]::-webkit-file-upload-button{
    cursor: pointer;
}

</style>
</head>
<body>
<div class="container">

      <!-- Breadcrumb -->
      <nav aria-label="breadcrumb" class="main-breadcrumb">
        <ol class="breadcrumb">
       
          <form action="settingstheme1?id=<?php echo $domain?>" method="post">
         
        </form>
        </ol>
      </nav>
      <!-- /Breadcrumb -->

      <div class="row gutters-sm">
        <div class="col-md-4 d-none d-md-block">
          <div class="card">
            <div class="card-body">
              <nav class="nav flex-column nav-pills nav-gap-y-1">
              <a href="../Dashboard.php"  class="nav-item nav-link has-icon  ">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><line x1="20" y1="12" x2="4" y2="12"></line><polyline points="10 18 4 12 10 6"></polyline></svg>Dashboard
                </a>
                <a href="#profile" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded active">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user mr-2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>Profile Information
                </a>
                <a href="#account" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings mr-2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>Account Settings
                </a>
                <a href="#security" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield mr-2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>Security
                </a>
                <!-- <a href="#notification" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-link mr-2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>Notification
                </a> -->
               
              </nav>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-header border-bottom mb-3 d-flex d-md-none">
              <ul class="nav nav-tabs card-header-tabs nav-gap-x-1" role="tablist">
                <li class="nav-item">
                  <a href="#profile" data-toggle="tab" class="nav-link has-icon active"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></a>
                </li>
                <li class="nav-item">
                  <a href="#account" data-toggle="tab" class="nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg></a>
                </li>
                <li class="nav-item">
                  <a href="#security" data-toggle="tab" class="nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg></a>
                </li>
                <!-- <li class="nav-item">
                  <a href="#notification" data-toggle="tab" class="nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg></a>
                </li> -->
                <!-- <li class="nav-item">
                  <a href="#billing" data-toggle="tab" class="nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg></a>
                </li> -->
              </ul>
            </div>
            <div class="card-body tab-content">
              <div class="tab-pane active" id="profile">
                <h6>YOUR PROFILE INFORMATION</h6>
                <hr>
                <form class="form" id = "form" action="" enctype="multipart/form-data" method="post">
      <div class="upload">
        <?php
        $id = $user["id"];
        $fname = $user["fname"];
        $img = $user["img"];
        ?>
        <img src="../assets/images/users/<?php echo $img; ?>" width = 125 height = 125 title="<?php echo $img; ?>">
        <div class="round">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <input type="hidden" name="fname" value="<?php echo $fname; ?>">
          <input type="file" name="img" id = "img" accept=".jpg, .jpeg, .png">
          <i class = "fa fa-camera" style = "color: #fff;"></i>
        </div>
      </div>
    </form>
    <form action="settingstheme1?id=<?php echo $domain?>" method="post">
                  <?php foreach($enabled as $key => $enable): ?>
                  <div class="form-group">
                    <label for="fullName">Username</label>
                    <input type="text" class="form-control" id="fullName" aria-describedby="fullNameHelp" value="<?php echo $enable['fname'];?>">
                    <!-- <small id="fullNameHelp" class="form-text text-muted">Your name may appear around here where you are mentioned. You can change or remove it at any time.</small> -->
                  </div>
                  <div class="form-group">
                    <label for="fullName">Email</label>
                    <input type="text" class="form-control" id="fullName" aria-describedby="fullNameHelp" readonly value="<?php echo $enable['email'];?> ">
                    <small id="fullNameHelp" class="form-text text-muted">To change your email, Go to the security tab.</small>
                  </div>
                  <!-- <div class="form-group">
                    <label for="url">Domain Name</label>
                    <input type="text" class="form-control" id="url"  readonly value="<?php echo $enable['domain'];?> ">
                  <small id="fullNameHelp" class="form-text text-muted">This is your Account Domain name and cannot be changed.</small>
                  </div> -->
                  <?php endforeach;?>
                 
                  <div class="form-group">
                    <label for="url">Website</label>
                    <input type="text" class="form-control" name="website" id="url"  value="<?php if(!empty($r['website'])){ echo $r['website']; }elseif(isset($website)){ echo $website; } ?>">
                  </div>
                  <hr>
                  <h6>Social Links</h6>
                  <div class="form-group">
                    <label for="url">Twitter</label>
                    <input type="text" class="form-control" id="url" name="twitter"  value="<?php if(!empty($r['twitter'])){ echo $r['twitter']; }elseif(isset($twitter)){ echo $twitter; } ?>">
                  </div>
                  <div class="form-group">
                    <label for="url">Facebook</label>
                    <input type="text" class="form-control" id="url" name="facebook"  value="<?php if(!empty($r['facebook'])){ echo $r['facebook']; }elseif(isset($facebook)){ echo $facebook; } ?>">
                  </div>
                  <div class="form-group">
                    <label for="url">Github</label>
                    <input type="text" class="form-control" id="url" name="github" value="<?php if(!empty($r['github'])){ echo $r['github']; }elseif(isset($github)){ echo $github; } ?>">
                  </div>
                  <div class="form-group">
                    <label for="url">LinkedIn</label>
                    <input type="text" class="form-control" id="url" name="linkedin" value="<?php if(!empty($r['linkedin'])){ echo $r['linkedin']; }elseif(isset($linkedin)){ echo $linkedin; } ?>">
                  </div>
                  <div class="form-group">
                    <label for="url">Google+</label>
                    <input type="text" class="form-control" id="url" name="google"  value="<?php if(!empty($r['google'])){ echo $r['google']; }elseif(isset($google)){ echo $google; } ?>">
                  </div>
                  <div class="form-group">
                    <label for="url">Instagram</label>
                    <input type="text" class="form-control" id="url" name="instagram" value="<?php if(!empty($r['instagram'])){ echo $r['instagram']; }elseif(isset($instagram)){ echo $instagram; } ?>">
                  </div>
                  <div class="form-group">
                    <label for="url">YouTube</label>
                    <input type="text" class="form-control" id="url" name="youtube" value="<?php if(!empty($r['youttube'])){ echo $r['youtube']; }elseif(isset($youtube)){ echo $youtube; } ?>">
                  </div>
                 
                  <hr>
                  <div class="form-group small text-muted">
                    All of the fields on this page are optional and can be deleted at any time, and by filling them out, you're giving us consent to share this data wherever your user profile appears.
                  </div>
                  <button type="submit" name="socials" class="btn btn-success">Update Profile</button>
                  <button type="reset" class="btn btn-light">Reset Changes</button>
                </form>
              </div>
              <div class="tab-pane" id="account">
                <h6>ACCOUNT SETTINGS</h6>
                <hr>
                <form action="settingstheme1?id=<?php echo $domain?>" method="post">
                  <!-- <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" aria-describedby="usernameHelp" placeholder="Enter your username" value="kennethvaldez">
                    <small id="usernameHelp" class="form-text text-muted">After changing your username, your old username becomes available for anyone else to claim.</small>
                  </div>
                  <hr> -->
                  <div class="form-group">
                    <label class="d-block text-danger">Delete Account</label>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <p class="text-muted font-size-sm">Once you delete your account, there is no going back. Please be certain. </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-danger" name="delete"  type="submit">Delete Account</button>
      </div>
    </div>
  </div>
</div>

                    <p class="text-muted font-size-sm">Once you delete your account, there is no going back. Please be certain.</p>
                  </div>
                  <button type="button"  class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete Account</button>
                </form>
              </div>
              <div class="tab-pane" id="security">
                <h6>SECURITY SETTINGS</h6>

                      <!--===================================PASSWORD---==========================================-->
                <hr>
                <form>
                  <div class="form-group">
                    <label class="d-block">Change Password</label>
                    <input type="text" class="form-control" placeholder="Enter your old password">
                    <input type="text" class="form-control mt-1" placeholder="New password">
                    <input type="text" class="form-control mt-1" placeholder="Confirm new password">
                  </div>
                  <button class="btn btn-info" type="button">Change Password</button>
                </form>
                <hr>
                      <!--===================================END---==========================================-->

                      <!--===================================PIN CODE---==========================================-->
               <?php
                    ///////////////////CHECKING IF PIN IS ENABLED///
                    $sql = "SELECT * FROM users WHERE id='$uid'";
                    $result = mysqli_query($conn, $sql);
                    $enabled = mysqli_fetch_all($result, MYSQLI_ASSOC);
                
                    $active = $enabled[0]['active'];    
                    $activity_logs = $enabled[0]['activity_logs'];  
                    $email = $enabled[0]['email'];        
?>
                    
              
                      <!--===================================END PIN CODE---==========================================-->


                      <!--===================================EMAIL CHANGE---==========================================-->
                    
                      <form action="settingstheme1?id=<?php echo $domain?>" method="post">
                  <?php

function hideEmailAddress($email)
{
    $em   = explode("@",$email);
    $name = implode(array_slice($em, 0, count($em)-1));
    $len  = floor(strlen($name)/2);
    return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);   
}
$email = $email;
  

                    ?>
                  <div class="form-group">
                    <label class="d-block">Change Email</label>
                    <p>Please enter your full email address and verify.</p>
                    <input type="email"  class="form-control mt-1"  value="<?php echo hideEmailAddress($email);?>">
                    <input type="email" name="oldemail" class="form-control mt-1" hidden  value="<?php echo $email;?>">
                    <input type="email" name="newemail" class="form-control mt-1" placeholder="Confirm Email">
                  </div>
                  <button class="btn btn-info" name="verify" type="submit">Verify Email</button>
                </form>
                <hr>
                      <!--===================================END---==========================================-->
                      

                <!--===================================TWO FACTOR AUTHENTICATION---==========================================-->
                      <form action="<?php echo $domain?>" method="post">
                  <div class="form-group">
                    <label class="d-block">Two Factor Authentication <span class="badge badge-pill badge-success">
                    <?php 
                        if ($active == '0'){
                            echo "Disabled";}
                        else
                        {
                            echo "Enabled";
                        }   
                            ?>
                    </span></label>
                    <p class="small text-muted mt-2">Two-factor authentication adds an additional layer of security to your account by requiring more than just a password to log in. When enabled each and everytime you login a one time pin(OTP) will be sent to your email in order to verify and approve the login request.</p>
                    <?php 
                        if ($active == '0'){
                            echo "<button class='btn btn-info' type='submit' name='enable'> Enable two-factor authentication </button>";}
                        else
                        {
                            echo "<button class='btn btn-info' type='submit' name='disable'> Disable two-factor authentication </button>";}
                        
                            ?>
                    

                  </div>
                </form>
                <hr>
      <!--===================================END TWO FACTOR AUTHENTICATION---==========================================-->


            <!--===================================ACTIVITY LOGS/ SESSIONS---==========================================-->
            <?php
                    ///////////////////CHECKING SESIONS///
                    $sql = "SELECT * FROM session_login WHERE uid='$uid'";
                    $result = mysqli_query($conn, $sql);
                    $sessions = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    $browser = $sessions[0]['browser']; 
                    $version = $sessions[0]['version']; 
                    $layout = $sessions[0]['layout']; 
                    $os = $sessions[0]['os'];     
                    $description = $sessions[0]['description']; 
                    $manufacturer = $sessions[0]['manufacturer']; 
                    $device_name = $sessions[0]['device_name']; 
?>
                                 <form action="<?php echo $domain?>" method="post">
                  <div class="form-group mb-0">
                  
                    <p class="font-size-sm text-secondary"></p>
                    <form>
                  <div class="form-group">
                    <label class="d-block">Sessions / Activity Logs  <span class="badge badge-pill badge-success">
                        
                    <?php 
                        if ($activity_logs == '0'){
                            echo "Disabled";}
                        else
                        {
                            echo "Enabled";
                        }   
                            ?></span></label>
                        <p class="small text-muted mt-2">This is a list of devices that have logged into your account. Revoke any sessions that you do not recognize.</p>
                                 <?php 
                        if ($activity_logs == '0'){
                            echo "<button class='btn btn-info' type='submit' name='enablelogs'> Enable Activity Logs</button>";}
                        else
                        {
                            echo "<button class='btn btn-info' type='submit' name='disablelogs'> Disable Activity Logs</button>";}
                        
                            ?>

                  </div>
                </form>
             <?php 
               if ($activity_logs == '0'){
                echo "<p class='small text-muted mt-2'>Please enable Activity Logs in order to see your session activity</p>"; 
                 }
                    else{                
                 echo "
                 <table class='table border bg-white'>
                 <thead>
                     <tr>
                         <th>Device</th>
                         <th>OS</th>
                         <th>Date-Time</th>
                         <th></th>
                     </tr>
                 </thead>
                                ";?>
                                <?php 
                                 $sql = "SELECT * FROM session_login WHERE uid='$uid'";
                                 $result = mysqli_query($conn, $sql);
                               
                                 if (mysqli_num_rows($result) > 0) {
                                  // output data of each row
                                  while($row = mysqli_fetch_assoc($result)) {

                                    $desc = $row['description'];
                                    $oss = $row['os'];
                                    $browser = $row['browser'];
                                    $time = $row['time_log'];
                                    ?>
<?php echo "
                 <tbody>
                     <tr>
                         <th scope='col'><i class='fe fe-globe fe-12 text-muted mr-2'></i>$desc</th>
                         <td>$oss</td>
                         <td>$time</td>
                       
                     </tr>
                           
                 </tbody>";
             }}}echo "</table>";
 			?>
               
             
                  </div>
                </form>
                      <!--===================================END SESSIONS---==========================================-->
              </div>
              
              <div class="tab-pane" id="notification">
                <h6>NOTIFICATION SETTINGS</h6>
                <hr>
                <form>
                  <div class="form-group">
                    <label class="d-block mb-0">Security Alerts</label>
                    <div class="small text-muted mb-3">Receive security alert notifications via email</div>
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck1" checked="">
                      <label class="custom-control-label" for="customCheck1">Email each time a vulnerability is found</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck2" checked="">
                      <label class="custom-control-label" for="customCheck2">Email a digest summary of vulnerability</label>
                    </div>
                  </div>
                  <div class="form-group mb-0">
                    <label class="d-block">SMS Notifications</label>
                    <ul class="list-group list-group-sm">
                      <li class="list-group-item has-icon">
                        Comments
                        <div class="custom-control custom-control-nolabel custom-switch ml-auto">
                          <input type="checkbox" class="custom-control-input" id="customSwitch1" checked="">
                          <label class="custom-control-label" for="customSwitch1"></label>
                        </div>
                      </li>
                      <li class="list-group-item has-icon">
                        Updates From People
                        <div class="custom-control custom-control-nolabel custom-switch ml-auto">
                          <input type="checkbox" class="custom-control-input" id="customSwitch2">
                          <label class="custom-control-label" for="customSwitch2"></label>
                        </div>
                      </li>
                      <li class="list-group-item has-icon">
                        Reminders
                        <div class="custom-control custom-control-nolabel custom-switch ml-auto">
                          <input type="checkbox" class="custom-control-input" id="customSwitch3" checked="">
                          <label class="custom-control-label" for="customSwitch3"></label>
                        </div>
                      </li>
                      <li class="list-group-item has-icon">
                        Events
                        <div class="custom-control custom-control-nolabel custom-switch ml-auto">
                          <input type="checkbox" class="custom-control-input" id="customSwitch4" checked="">
                          <label class="custom-control-label" for="customSwitch4"></label>
                        </div>
                      </li>
                      <li class="list-group-item has-icon">
                        Pages You Follow
                        <div class="custom-control custom-control-nolabel custom-switch ml-auto">
                          <input type="checkbox" class="custom-control-input" id="customSwitch5">
                          <label class="custom-control-label" for="customSwitch5"></label>
                        </div>
                      </li>
                    </ul>
                  </div>
                </form>
              </div>
           
            </div>
          </div>
        </div>
      </div>

    </div>

    <script type="text/javascript">
      document.getElementById("img").onchange = function(){
          document.getElementById("form").submit();
      };
    </script>
   

<script type="text/javascript"></script>
</body>
</html>