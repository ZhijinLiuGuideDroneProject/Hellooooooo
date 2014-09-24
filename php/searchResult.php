<?php
	if(!isset($_SESSION)){
	    session_start();
	}

	include "connection.php";

	$search=mysql_query("SELECT user_photo,user_id,user_firstname,user_surname,user_birthday,user_gender,user_study,user_work FROM User
		WHERE (user_firstname=trim('$_SESSION[searchBar]') OR user_surname=trim('$_SESSION[searchBar]')
		OR user_study=trim('$_SESSION[searchBar]') OR user_work=trim('$_SESSION[searchBar]')
		OR user_id=(SELECT user_id FROM Account WHERE user_email=trim('$_SESSION[searchBar]')))");

	mysql_close();
?>