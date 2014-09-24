<?php
	
	if(!isset($_SESSION)) {
		session_start();
	}

	function userPhotoSize($ID){

	include "connection.php";

	$size=mysql_query("SELECT OCTET_LENGTH(user_photo) FROM User
		WHERE user_id = $ID");

	$sizeFetch=mysql_fetch_array($size);

	$imageSize=$sizeFetch["OCTET_LENGTH(user_photo)"];

	return $imageSize;

 }

 	function postPhotoSize($userID,$photoID){

 	include "connection.php";

 	$size=mysql_query("SELECT OCTET_LENGTH(post_photo) FROM Post
		WHERE post_id = $userID AND id=$photoID");

	$sizeFetch=mysql_fetch_array($size);

	$imageSize=$sizeFetch["OCTET_LENGTH(post_photo)"];

	return $imageSize;

 	}
?>