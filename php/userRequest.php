<?php
if(!isset($_SESSION)){
    session_start();
}

	include "connection.php";

	$userRequest=mysql_query("INSERT INTO Friend(user,friend)
		VALUES ('$_SESSION[user_id]','$_SESSION[friend_id]')");

	if($userRequest){
		echo "<script>history.back();</script>";
	}
	else{
		echo "Friend request failed";
	}

	mysql_close();
?>