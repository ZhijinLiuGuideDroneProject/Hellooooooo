<?php
	if(!isset($_SESSION)) {
		session_start();
	}

	function update($photo){
		$photoUpload=mysql_query("UPDATE User 
			SET user_photo='$photo'
			WHERE user_id=$_SESSION[user_id]")
			or die("Problem uploading");

		$profileUpdate=mysql_query("UPDATE User
			SET user_study=trim('$_POST[study]'),user_work=trim('$_POST[work]')
			WHERE user_id=$_SESSION[user_id]");

		if($profileUpdate && $photoUpload){
			$message="Thank you!";
			echo "<script>alert('".$message."');window.location.href = '../pages/homeFeed.php';</script>";
		}
		else{
			echo "Update fail!";
		}
	}

	include "connection.php";

	$file=$_FILES['photo']['tmp_name'];

	$photo=addslashes(file_get_contents($_FILES['photo']['tmp_name']));
	$photo_name=addslashes($_FILES['photo']['name']);
	$photo_size=getimagesize($_FILES['photo']['tmp_name']);

	if(!$_FILES['photo']['name']==''){

		if($photo_size==FALSE){
			$message="Please upload an image.";
			echo "<script>alert('".$message."');history.back();</script>";
		}
		
		else{
			update($photo);
		}
	}
	else{
		update();
	}
	mysql_close();

?>