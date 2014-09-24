<?php

	$host="localhost";
	$username="test";
	$password="test";
	$database="Hellooooooo";
	
	$connection=mysql_connect("$host","$username","$password");
	$selection=mysql_select_db("$database");
	if(!$connection||!$selection){
		echo"Connected failed! ";
	}

?>