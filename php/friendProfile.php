<?php
if(!isset($_SESSION)){
    session_start();
}

  $friendEmail=$_GET['name'];

  $_SESSION["friend_email"]=$friendEmail;

  /* Get the information of the friends. */
  function friendFetch(){

    $friend=mysql_query("SELECT user_firstname,user_surname,user_birthday,user_gender,user_study,user_work,user_email FROM User,Account
          WHERE User.user_id=(SELECT user_id FROM Account WHERE user_email='$_SESSION[friend_email]')
          AND user_email='$_SESSION[friend_email]'") or die("<p>Friend fetch failed.</p>");

    $friendFetch=mysql_fetch_array($friend);

    return $friendFetch;
}
  
  /* To judge if they are friends. */
  function relation(){

    $relation=mysql_query("SELECT user,friend FROM Friend
        WHERE (user=(SELECT user_id FROM Account WHERE user_email='$_SESSION[user_email]')
        AND friend=(SELECT user_id FROM Account WHERE user_email='$_SESSION[friend_email]'))
        OR (user=(SELECT user_id FROM Account WHERE user_email='$_SESSION[friend_email]')
        AND friend=(SELECT user_id FROM Account WHERE user_email='$_SESSION[user_email]'))") 
        or die("<p>Find relation failed</p>");

    $relationNum=mysql_num_rows($relation);

    return $relationNum;
  }

  /* To judge if the user has sent a request to the friend. */
  function userRequestFetch(){

    $userRequest=mysql_query("SELECT user,friend FROM Friend
              WHERE user=(SELECT user_id FROM Account WHERE user_email='$_SESSION[user_email]')
              AND friend=(SELECT user_id FROM Account WHERE user_email='$_SESSION[friend_email]')") 
              or die("<p>user request failed.</p>");

      $userRequestFetch=mysql_fetch_array($userRequest);

      return $userRequestFetch;
  }

  /* To judge if the friend has sent a request to the user. */
  function friendRequestFetch(){

      $friendRequest=mysql_query("SELECT user,friend FROM Friend
                WHERE user=(SELECT user_id FROM Account WHERE user_email='$_SESSION[friend_email]')
                AND friend=(SELECT user_id FROM Account WHERE user_email='$_SESSION[user_email]')") 
                or die("<p>Friend request failed</p>");

      $friendRequestFetch=mysql_fetch_array($friendRequest);

      return $friendRequestFetch;;
  }

  /* To see that what circle the friend belong to. */
  function getCircle(){

    include "../php/circleObtainment.php";

    return $getCircleFetch;

  }

  /* To crete a view containing all the users who are related to that friend/User. */
  function view(){

    $view=mysql_query("CREATE VIEW FriendsFriend AS
      SELECT user AS id FROM Friend WHERE
      (friend=(SELECT user_id FROM Account WHERE user_email='$_SESSION[friend_email]')
        AND NOT user=(SELECT user_id FROM Account WHERE user_email='$_SESSION[user_email]'))
      UNION ALL
      SELECT friend AS id FROM Friend WHERE 
      (user=(SELECT user_id FROM Account WHERE user_email='$_SESSION[friend_email]')
        AND NOT friend=(SELECT user_id FROM Account WHERE user_email='$_SESSION[user_email]'))")
      or die("Your friend is a hermit!");
      
    return $view;
  }

  /* Get the information of the friend's/user's friends. */
  function getFriendsFriend($friendsFriendID){

    $friendsFriend=mysql_query("SELECT user_firstname,user_surname,user_study,user_work,user_email FROM user,Account
      WHERE User.user_id=Account.user_id AND User.user_id=$friendsFriendID") or die("Friend's friend fetch failed.");

    $friendsFriendFetch=mysql_fetch_array($friendsFriend);

    return $friendsFriendFetch;

  }

  /* The popup window which well display user's/friend's friends. */
  function popupWindow(){

    echo '<div id="popupWindow" class="popupWindowStyle">';
      echo '<div>';
        echo '<a href="javascript:history.back();" title="Close" class="close">X</a>';

        if(view()){

          $friendsFriendID=mysql_query("SELECT id FROM FriendsFriend
            GROUP BY id
            HAVING COUNT(*)=2");

          if(mysql_num_rows($friendsFriendID)>0){

            while($friendsFriendIDFetch=mysql_fetch_array($friendsFriendID)){

              $display=getFriendsFriend($friendsFriendIDFetch["id"]);

              if($display){
              echo "<center>";
              echo ("<a href='friendProfilePage.php?name=".$display['user_email']."'>".$display['user_firstname']." ".$display['user_surname']."</a><br>");
                echo "$display[user_work]<br>";
                echo "$display[user_study]<br>";
                echo "<a href='friendProfilePage.php?name=".$display['user_email']."'><button>View Profile!</button></a>";
              echo "</center>";
              }

              else{
                echo "<p>Display error.</p>";
              }
            } 
          }
          else{
            echo "<p>Your friend has no friends.</p>";
          }
        }

    $dropView=mysql_query("DROP VIEW FriendsFriend");
      echo '</div>';
    echo '</div>';

  }

  /* The block which displays the user/friend profile page. */
  function echoSideBar(){
    $friendFetch=friendFetch();
    echo "<div id='leftcolumn'>";
      echo '<div class="innertube">';
        echo '<table>';
          echo '<tr id="username">';
            echo '<th>';

                echo "$friendFetch[user_firstname] $friendFetch[user_surname]";

            echo '</th>';
          echo '</tr>';
          echo '<tr>';
            echo '<td>';
              echo '<center><img src="../img/profileimg.png" style="padding: 10px;" width=150px></center>';
            echo '</td>';
          echo '</tr>';

          echo '<tr>';
            echo '<td height=250px>';

              echo "$friendFetch[user_birthday]<br>";
              echo "$friendFetch[user_gender]<br>";
              echo "$friendFetch[user_work]<br>";
              echo "$friendFetch[user_study]<br>";

              // If they are friends.
              if(relation()==2){

                echo "<form method='post' action='../php/friendDelete.php'>";
                echo "<button type='submit'>Unfriend</button>";
                echo "</form>";

                // Show the friend's circle.
                $getCircle=getCircle();
                $getFriendCircle=$getCircle["circle"];
                $circleRemove=array('No circle','Study','Work','Family');
                $circleRemove=array_diff($circleRemove, array($getFriendCircle));
                $circleSelection=array_values($circleRemove);
                
                echo "<form method='post' action='../php/circleUpdate.php'>";
                echo "<p>Circles: <select name='circle' onchange='this.form.submit()'>";
                echo "<option selected>".$getFriendCircle."</option>";
                echo "<option value='$circleSelection[0]'>$circleSelection[0]</option>";
                echo "<option value='$circleSelection[1]'>$circleSelection[1]</option>";
                echo "<option value='$circleSelection[2]'>$circleSelection[2]</option>";
                echo "</select>";

              }
              
            echo '</td>';
          echo '</tr>';

        echo '</table>';
      echo '</div>';
    echo '</div>';
  }

  function echoNavigationBar(){
    echo '<div id="profilemenu" style="position: fixed; ">';
      echo '<div class="innertube" style="text-align:center;">';
        echo '<div class="btn-group btn-group-justified">';
          echo '<div class="btn-group">';
            echo '<a class="btn" type="button" class="btn btn-default" style="border-right:1px solid gray" href="about.php">About</a>';
          echo '</div>';
          echo '<div class="btn-group">';
            echo '<a class="btn" type="button" class="btn btn-default" style="border-right:1px solid gray" href="photos.php">Photos</a>';
          echo '</div>';
          echo '<div class="btn-group">';
            echo '<a class="btn" type="button" class="btn btn-default" style="border-right:1px solid gray" href="#popupWindow">Friends</a>';
          echo '</div>';
          echo '<div class="btn-group">';
            echo '<a class="btn" type="button" class="btn btn-default" href="circles.php">Circles</a>';
          echo '</div>';
        echo '</div>';
      echo '</div>';
    echo '</div>';
  }

  /* Display the feed block when they are friends. */
  function echoFeed(){
    echo '<div id="contentcolumn">';
      echo '<div id="column-scroll">';

        echo '<div class="innertube">';
          echo '<center>This is the profile page.';
          echo '<a href="editProfile.php">Update personal details.</a></center>';

          echo '<div id="profilefeed">';
            echo '<center>This div will contain the feed of the user.';

              echo '<script>';
              echo 'var string = "";';
                echo 'for (var i = 0; i < 50; i++) {';
                  echo 'string += "blah blah<p>"';
                  echo '}';
                echo 'document.write(string);';
              echo '</script>';

            echo '</center>';
          echo '</div>';
        echo '</div>';
      echo '</div>';
  echo '</div>';
  }

  /* Display the feed block when the request/confirm button when they are not friends. */
  function echoBlankFeed(){
    $friendFetch=friendFetch();
    echo '<div id="contentcolumn">';
      echo '<div id="column-scroll">';
        echo '<div class="innertube">';
          echo '<div id="profilefeed">';
            echo '<center>You are not friends.<br>';

            if(userRequestFetch()){
              echo "<button type='button' disabled>Request sent</button>";
            } 
            else{
              if(friendRequestFetch()){
                echo "<p>$friendFetch[user_firstname] $friendFetch[user_surname] has sent you a request.</p>";
                echo "<form method='post' action='../php/friendAcceptance.php'>";
                echo "<button type='submit' name='confirm'>Confirm</button>";
                echo "<button type='submit' name='reject'>Reject</button>";
                echo "</form>";
            }
              else{
                echo "<form method='post' action='../php/friendRequest.php'>";
                echo "<button type='submit'>Request</button>";
                echo "</form>";
              }
            }

            echo "</center>";
          echo '</div>';
        echo '</div>';
      echo '</div>';
  echo '</div>';
  }

?>