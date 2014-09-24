<?php
if(!isset($_SESSION)){
    session_start();
}

	include "connection.php";

    $getCircle=mysql_query("SELECT circle FROM Friend
      WHERE user=$_SESSION[user_id]
      AND friend=$_SESSION[friend_id]");

    $getCircleFetch=mysql_fetch_array($getCircle);

    mysql_close();

?>