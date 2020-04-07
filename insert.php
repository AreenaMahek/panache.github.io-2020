<?php
$username = $_POST['username'];
$email = $_POST['email'];
$phonecode = $_POST['phonecode'];
$phone = $_POST['phone'];
$password = $_POST['password'];
if (!empty($username) ||  !empty($email) || !empty($phonecode) || !empty($phone) || !empty($password) ) {
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "panache";
    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_error()) {
     die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
     $SELECT = "SELECT email From register Where email = ? Limit 1";
     $INSERT = "INSERT Into register (username, email, phonecode, phone, password) values(?, ?, ?, ?, ?)";
     //Prepare statement
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $stmt->bind_result($email);
     $stmt->store_result();
     $rnum = $stmt->num_rows;
     if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
     $stmt->bind_param('sssis', $username, $email,  $phonecode, $phone, $password);
      $stmt->execute();
     header("location: login.php");
     } else {
      echo  "Someone already registered using this email \n Register Again";
     }
     $stmt->close();
     $conn->close();
    }
} else {
 echo "All field are required";
 die();
}
?>
