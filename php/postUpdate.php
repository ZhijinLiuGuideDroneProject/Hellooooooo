<?php
	if(!isset($_SESSION)) {
		session_start();
	}

	function postUpdate(){
		include "connection.php";

		$post=mysql_query("INSERT INTO Post(post_id,post_time,post_comment)
				VALUES('$_SESSION[user_id]',now(),'$_POST[post_comment]')")
				or die("Post failed");

		$message="Post successfully";
		echo "<script type='text/javascript'>alert('".$message."');window.location.href = '../pages/homeFeed.php';</script>";

		mysql_close($connection);
	}

	function postPhotoUpdate($post_photo){

		include "connection.php";

		$postPhoto=mysql_query("INSERT INTO Post(post_id,post_time,post_comment,post_photo)
				VALUES('$_SESSION[user_id]',now(),'$_POST[post_comment]','$post_photo')")
				or die("Post failed");


		$message="Post successfully";
		echo "<script type='text/javascript'>alert('".$message."');window.location.href = '../pages/homeFeed.php';</script>";


		mysql_close($connection);

	}

	if(!$_FILES['post_photo']['name']==''){
		$post_photo=addslashes(file_get_contents($_FILES['post_photo']['tmp_name']));
		$post_photo_name=addslashes($_FILES['post_photo']['name']);
		$post_photo_size=getimagesize($_FILES['post_photo']['tmp_name']);

		if($post_photo_size==FALSE){

			$message="Please upload an image.";
			echo "<script type='text/javascript'>alert('".$message."');history.back();</script>";

		}
		else{
			if($_FILES['post_photo']['size']>2097152){

				$message = 'File too large. File must be less than 2 megabytes.'; 
				echo '<script type="text/javascript">alert("'.$message.'");history.back();</script>';

			}
			else{

				postPhotoUpdate($post_photo);
			}

		}
	}
	else{
		postUpdate();
	}
?>