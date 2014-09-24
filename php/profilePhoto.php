<?php

	include "connection.php";

	$id=$_GET["id"];

	$image=mysql_query("SELECT user_photo FROM User
		WHERE user_id=$id");

	$imageFetch=mysql_fetch_array($image);

	header("Content-type: image/jpeg");

	echo $imageFetch["user_photo"];

	mysql_close($connection);
?>
