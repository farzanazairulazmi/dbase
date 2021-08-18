<?php
if ($_SESSION["uid"] == ""){
	header("Location: /dbase/", true, 301);
	exit();
}
?>