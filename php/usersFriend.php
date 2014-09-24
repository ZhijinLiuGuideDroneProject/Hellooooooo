<?php

	if(!isset($_SESSION)){
      session_start();
  	}

  	  /* Get the ID of the user's friends. */
 	function getMyFriendID(){

	    $myFriendID=mysql_query("SELECT * FROM ((SELECT friend AS id FROM Friend WHERE user=$_SESSION[user_id])
	      UNION ALL (SELECT user AS id FROM Friend WHERE friend=$_SESSION[user_id])) AS MyFriend GROUP BY id HAVING COUNT(*)=2");

	    return $myFriendID;
 	}

 	  /* Get the profile of the user's friends.*/
  	function getMyFriendProfile($ID){

	    $myFriendProfile=mysql_query("SELECT user_id,user_firstname,user_surname,user_study,user_work FROM User
	      WHERE user_id=$ID");

	    $myFriendProfileFetch=mysql_fetch_array($myFriendProfile);

	    return $myFriendProfileFetch;
  	}
?>