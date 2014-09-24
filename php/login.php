<?php
if(!isset($_SESSION)){
    session_start();
}
?>

<script type="text/javascript">
	function loginFailure(){
		alert("Please check your acount or password!");
	}

	function homeFeedPage(){
		window.location.href = "../pages/homeFeed.php";
	}

</script>

<?php
	include "connection.php";

	$email=mysql_query("SELECT user_email FROM Account WHERE user_email=trim('$_POST[email]')");
	$emailFetch=mysql_fetch_array($email);

	if($emailFetch){
		$password=mysql_query("SELECT user_password FROM Account WHERE user_password=md5('$_POST[password]') AND user_email=trim('$_POST[email]')");
		$passwordFetch=mysql_fetch_array($password);
			
       	if($passwordFetch){

       		//$_SESSION["user_email"]=$emailFetch["user_email"];

       		// user_id store in the session.
       		$ID=mysql_query("SELECT user_id FROM Account WHERE user_email='$emailFetch[user_email]'");
       		$IDFetch=mysql_fetch_array($ID);
       		$_SESSION["user_id"]=$IDFetch["user_id"];
       		
       		//setcookie("login",$emailCheck["user_email"],time()+(60*60*24*30));
       		echo "<script>homeFeedPage();</script>"; 			
        }
       	else{
        	echo "<script>loginFailure();history.back();</script>";
        }			
	}

	else{
		echo "<script>loginFailure();history.back();</script>";
	}
	mysql_close();

?>