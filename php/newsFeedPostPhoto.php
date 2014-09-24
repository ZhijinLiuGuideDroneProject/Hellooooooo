<?php
	if(!isset($_SESSION)) {
		session_start();
	}

	include "connection.php";

	$photoID=$_GET["photoID"];
	$userID=$_GET["userID"];
	
		$image=mysql_query("SELECT id,post_photo FROM Post
			WHERE post_id=$userID AND id=$photoID");

		$imageFetch=mysql_fetch_array($image);

		header("Content-type: image/jpeg");

		echo $imageFetch["post_photo"];

	mysql_close($connection);
?>
