<?php
if(!isset($_SESSION)){
    session_start();
}

	include "connection.php";
	$message = $_GET['message'];
	echo $message;

	$sendMessage=mysql_query("INSERT INTO Message(sender,receiver, date, message)
		VALUES ('$_SESSION[user_id]','$_SESSION[receiver]',now(),'$message')");

	if($sendMessage){
	}
	else{
		echo "Messagev send failed";
	}

	mysql_close();
?>