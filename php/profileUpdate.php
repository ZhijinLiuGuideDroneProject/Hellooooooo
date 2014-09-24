<?php
	if(!isset($_SESSION)) {
		session_start();
	}
	function updateProfile(){
		$profileUpdate=mysql_query("UPDATE User
			SET user_firstname=trim('$_POST[firstname]'),user_surname=trim('$_POST[surname]'),
			user_gender='$_POST[gender]',user_study=trim('$_POST[study]'),user_work=trim('$_POST[work]')
			WHERE user_id=$_SESSION[user_id]")
			or die("Update failed");
	}

	function update(){

		if(!empty($_POST["year"]) && !empty($_POST["month"]) && !empty($_POST["day"])){

			$birthdayUpdate=mysql_query("UPDATE User
			SET user_birthday='$_POST[year]-$_POST[month]-$_POST[day]'
			WHERE user_id=$_SESSION[user_id]")
			or die("Birthday update failed");

			updateProfile();
		
		}
		else{
			updateProfile();
		}

	}
	function updatePassword(){
		$passwordUpdate=mysql_query("UPDATE Account 
			SET user_password=md5('$_POST[password1]')
			WHERE user_id=$_SESSION[user_id]")
			or die("Password update failed");
	}

	function updatePhoto(){

		$photo=addslashes(file_get_contents($_FILES['photo']['tmp_name']));
		$photo_name=addslashes($_FILES['photo']['name']);
		$photo_size=getimagesize($_FILES['photo']['tmp_name']);

		if(!$_FILES['photo']['name']==''){

			if($photo_size==FALSE){
				echo "<script>notImage();history.back();</script>";
			}

			else{
				$photoUpload=mysql_query("UPDATE User 
					SET user_photo='$photo'
					WHERE user_id=$_SESSION[user_id]")
					or die("Problem uploading");

				return $photoUpload;

			}	
		}
		else{

			return true;
		
		}
	}
?>

<script type="text/javascript">
	function passwordIdentification(){
		alert("Please check it again!\nThe passwords you have typed are not identical!");
	}

	function success(){

		alert("Update successfully");
	}

	function homeFeedPage(){
		window.location.href = "../pages/homeFeed.php";
	}

	function notImage(){
		alert("Please upload an image.");
	}

</script>

<?php
	include "connection.php";

	if(!empty($_POST["password1"]) && !empty($_POST["password2"])){

		if($_POST["password1"]==$_POST["password2"]){
			if(updatePhoto()){
				update();
				updatePassword();
				updatePhoto();
				echo "<script>success();homeFeedPage();</script>";
			}
		}
		else{
			echo "<script>passwordIdentification();history.back();</script>";
		}
	}
	else{
		if(updatePhoto()){
			update();
			updatePhoto();
			echo "<script>success();homeFeedPage();</script>";
		}
		
	}
	mysql_close();
?>