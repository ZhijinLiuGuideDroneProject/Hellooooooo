<?php
if(!isset($_SESSION)){
    session_start();
}

	include "connection.php";

	$circleUpdate=mysql_query("UPDATE Friend SET circle='$_POST[circle]'
		WHERE (user=$_SESSION[user_id]
		AND friend=$_SESSION[friend_id])")
		or die("Circle update failed");

	if($circleUpdate){
		echo "<script>history.back();</script>";
	}
	mysql_close();
?>