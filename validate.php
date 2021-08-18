<?php 
	// Start the session
	session_start();
	
	include 'includes/connection.php';
	
	$username =  strip_tags(trim($_POST["username"]));
	$password = strip_tags(trim($_POST["password"]));

	
	$sql = "SELECT username,password FROM step_dbase_users WHERE username = '".$username."' and password = '".md5($password)."' and flag = 0";
	$result = $conn->query($sql);

	// Mysql_num_row is counting table row
	$count = $result->num_rows;

	// If result matched $mc_mv_uid, table row must be 1 row
	if($count==1){

		$sql2 = "SELECT uid,username,nama_penuh FROM step_dbase_users WHERE username = '".$username."'";
		$result2 = mysqli_query($conn, $sql2);
			if (mysqli_num_rows($result2) > 0) {
				while($row2 = mysqli_fetch_assoc($result2)) {
					$_SESSION["uid"] = $row2["uid"];
					
					// Leave Application session used //
					$_SESSION["username"] = $row2["username"];
					$_SESSION['userLogged'] = $row2["nama_penuh"];

				}
			}

		//table log - start
		$activity = "login";
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

		//insert db step_dbase_log		
		$sql4 = "INSERT INTO step_dbase_log (userid,ip_address,activity)
		VALUES ('".$_SESSION["uid"]."','".getUserIpAddr()."','".$activity."')";	
		//exit;
		
		if (mysqli_query($conn, $sql4)) {
			//$id_perincian = mysqli_insert_id($conn);
		} else {
			echo "Error insert record: " . mysqli_error($conn);
		}

		
		$datetime = date("Y-m-d H:i:s");		
		$sql3 = "UPDATE step_dbase_users SET tmstamp = '".$datetime."' ".
		   "WHERE username = '".$username."'";
		   
		if (mysqli_query($conn, $sql3)) {
			header("location:rekod/home.php");
		}else {
			echo "Error updating record: " . mysqli_error($conn);
		}

		header("location:rekod/home.php");
			
	}else{
		header("location:index.php?err=1");
	}

	mysqli_close($conn);	
?>
