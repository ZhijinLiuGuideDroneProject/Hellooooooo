<?php
if(!isset($_SESSION)){
    session_start();
}
	include "connection.php";

	if(isset($_POST['confirm'])){
		$accept=mysql_query("INSERT INTO Friend(user,friend)
		VALUES ('$_SESSION[user_id]','$_SESSION[friend_id]')");

		if($accept){
			echo "<script>history.back();</script>";
		}
		else{
			echo "comfirmation failed!";
		}
	}

	if(isset($_POST['reject'])){
		$reject=mysql_query("DELETE FROM Friend
		WHERE user=$_SESSION[friend_id]
		AND friend=$_SESSION[user_id]");

		if($reject){
			echo "<script>history.back();</script>";
		}
		else{
			echo "Rejection failed!";
		}
	}

	mysql_close($connection);
?>