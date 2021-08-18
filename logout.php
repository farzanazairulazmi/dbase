<?php
// Start the session
session_start();
include 'includes/connection.php';
?>

<!DOCTYPE html>
<!--[if !IE]><!-->
<html lang="en-US">
<!--<![endif]-->

<head>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta charset="UTF-8">
<script type="text/javascript" src="js/jquery.js"></script>
<title><?php include 'includes/title.php';?></title>


<!-- RSS -->
<link rel="alternate" type="application/rss+xml" title="#" href="#" />


<!-- Favicon -->
<link rel="shortcut icon" href="images/favicon.ico"/>


<!-- Google Font -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans%7CLato' rel='stylesheet' type='text/css'>


<!-- Primary CSS -->
<link rel="stylesheet" href="style.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/_mobile.css" type="text/css" media="all" />

</head>
<body>

<?php

//table log - start
$activity = "logout";
function getUserIpAddr()
 {
      $ipaddress = '';
      if (getenv('HTTP_CLIENT_IP'))
          $ipaddress = getenv('HTTP_CLIENT_IP');
      else if(getenv('HTTP_X_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
      else if(getenv('HTTP_X_FORWARDED'))
          $ipaddress = getenv('HTTP_X_FORWARDED');
      else if(getenv('HTTP_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_FORWARDED_FOR');
      else if(getenv('HTTP_FORWARDED'))
          $ipaddress = getenv('HTTP_FORWARDED');
      else if(getenv('REMOTE_ADDR'))
          $ipaddress = getenv('REMOTE_ADDR');
      else
          $ipaddress = 'UNKNOWN';

      return $ipaddress;
 }

//insert db dbase_log		
$sql4 = "INSERT INTO dbase_log (userid,ip_address,activity)
        VALUES ('".$_SESSION["sqno"]."','".getUserIpAddr()."','".$activity."')";	


if (mysqli_query($conn, $sql4)) {
    //$id_perincian = mysqli_insert_id($conn);
} else {
    echo "Error insert record: " . mysqli_error($conn);
}

// remove all session variables
// session_unset(); 
unset($_SESSION["uid"]);
// destroy the session 
// session_destroy(); 

header("Location: /dbase/", true, 301);
exit();
?>


</body>
</html>