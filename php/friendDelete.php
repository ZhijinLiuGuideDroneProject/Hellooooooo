<?php
if(!isset($_SESSION)){
    session_start();
}
		include "connection.php";

		if(isset($_POST['confirm'])){
			$friendDelete=mysql_query("DELETE FROM Friend
				WHERE (user=$_SESSION[user_id]
				AND friend=$_SESSION[friend_id])
			OR (user=$_SESSION[friend_id]
				AND friend=$_SESSION[user_id])");

			if($friendDelete){
				echo "<script>history.back();</script>";
			}
			else{
				echo "Deletion failed ";
			}
		}

		if(isset($_POST['cancel'])){

			echo "<script>window.location.href = '../pages/friendProfilePage.php?name=".$_SESSION["friend_id"]."';</script>";

		}


		mysql_close();	
?>