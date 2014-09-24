<?php
if(!isset($_SESSION)){
    session_start();
}

	include "connection.php";

	$email=mysql_query("SELECT user_email FROM Account WHERE user_email='$_POST[email]'");
	$emailCheck=mysql_fetch_array($email);

	if(!$emailCheck){

		if($_POST["password1"]==$_POST["password2"]){	

			$userInsertion=mysql_query("INSERT INTO User(user_firstname,user_surname,user_gender,user_birthday)
				VALUES (trim('$_POST[firstname]'),trim('$_POST[surname]'),'$_POST[gender]','$_POST[year]-$_POST[month]-$_POST[day]')");

			$getInsertID=mysql_insert_id();

			$accountInsertion=mysql_query("INSERT INTO Account(user_email,user_password,user_id)
				VALUES (trim('$_POST[email]'),md5('$_POST[password1]'),'$getInsertID')");

			//$_SESSION["user_email"]=trim($_POST["email"]);

			// user_id store in the session.
       		$_SESSION["user_id"]=$getInsertID;


			if($userInsertion&&$accountInsertion){

				echo "<script>window.location.href = '../pages/registerProfile.php';</script>";
			}
			else if(!$userInsertion){
				echo "User insertion failed";
			}
			else if(!$accountInsertion){
				echo "Account insertion failed";
			}
		}
		else{
			$message="The passwords you have typed are not identical!";
			echo "<script>alert('".$message."');history.back();</script>";
		}
	}
	else{
		$message="This email has been registered!";
		echo "<script>alert('".$message."');history.back();</script>";
	}

	mysql_close();
?>