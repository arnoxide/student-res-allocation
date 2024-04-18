<?php  
//export.php  
require_once '../database/authcontroller.php';
$output = '';
if(isset($_POST["export"]))
{
 $query = "SELECT * FROM users";
 $result = mysqli_query($conn, $query);
 if(mysqli_num_rows($result) > 0)
 {
  $output .= '
   <table class="table" bordered="1">  
                    <tr>  
                         <th>First Name</th>  
                         <th>Last Name</th>  
                         <th>Email</th>  
       <th>Date registered</th>
                    </tr>
  ';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
    <tr>  
                         <td>'.$row["fname"].'</td>  
                         <td>'.$row["lname"].'</td>  
                         <td>'.$row["email"].'</td>  
                         <td>'.$row["time_registered"].'</td>  
    
                    </tr>
   ';
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=users.xls');
  echo $output;
 }
}
?>