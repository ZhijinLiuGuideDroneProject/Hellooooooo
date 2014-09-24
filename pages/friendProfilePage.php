<?php
if(!isset($_SESSION)){
    session_start();
}

  $friendID=$_GET['name'];

  $_SESSION["friend_id"]=$friendID;

  /* To know that if the user's friend has ever post anything. */
  function postOrNot(){
    $postOrNot=mysql_query("SELECT post_id FROM Post WHERE post_id=$_SESSION[friend_id]");

    return $postOrNot;
  }

  /* Get the post of the user's friend. */
  function getPost(){

    include "../php/connection.php";

    $getPost=mysql_query("SELECT id,post_id,post_time,post_photo,post_comment,user_firstname,user_surname FROM Post,User
      WHERE post_id=$_SESSION[friend_id] AND post_id=user_id GROUP BY post_time DESC");

    return $getPost;
  }

  /* Get the information of the friends. */
  function friendFetch(){

    $friend=mysql_query("SELECT user_firstname,user_surname,user_birthday,user_gender,user_study,user_work FROM User
          WHERE user_id=$_SESSION[friend_id]") or die("<p>Friend fetch failed.</p>");

    $friendFetch=mysql_fetch_array($friend);

    return $friendFetch;
}
  
  /* To judge if they are friends. */
  function relation(){

    $relation=mysql_query("SELECT user,friend FROM Friend
        WHERE (user=$_SESSION[user_id]
        AND friend=$_SESSION[friend_id])
        OR (user=$_SESSION[friend_id]
        AND friend=$_SESSION[user_id])") ;

    $relationNum=mysql_num_rows($relation);

    return $relationNum;
  }

  /* To judge if the user has sent a request to the friend. */
  function userRequestFetch(){

    $userRequest=mysql_query("SELECT user,friend FROM Friend
              WHERE user=$_SESSION[user_id]
              AND friend=$_SESSION[friend_id]");

      $userRequestFetch=mysql_fetch_array($userRequest);

      return $userRequestFetch;
  }

  /* To judge if the friend has sent a request to the user. */
  function friendRequestFetch(){

      $friendRequest=mysql_query("SELECT user,friend FROM Friend
                WHERE user=$_SESSION[friend_id]
                AND friend=$_SESSION[user_id]");

      $friendRequestFetch=mysql_fetch_array($friendRequest);

      return $friendRequestFetch;;
  }

  function echoBlock($num,$firstname,$surname,$work,$study,$ID,$br){
    $userPhotoSize=userPhotoSize($ID[$num]);
    echo "<div class='profile-box'>";
    echo "<div id='box-displaypic'>";
    if($userPhotoSize>0){
           echo "<img src='../php/profilePhoto.php?id=".$ID[$num]."' style='height:104px; padding:10px;'>";
         }
         else{
           echo '<img src="../img/profileimg.png" style="padding: 10px;" width=90px>';
         }

    echo "</div>";
    echo "<div id='box-text'>";
    echo "<a href='friendProfilePage.php?name=".$ID[$num]."'>". $firstname[$num]. " " . $surname[$num] . "</a><br>";
    echo $work[$num] . $br . $study[$num] . $br;
    echo "<a href='friendProfilePage.php?name=".$ID[$num]."'><button class='btn' id='box-button' type='button' name='Accept'>View Profile</button></a>";
    echo "</div></div>";

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
      (friend=$_SESSION[friend_id]
        AND NOT user=$_SESSION[user_id])
      UNION ALL
      SELECT friend AS id FROM Friend WHERE 
      (user=$_SESSION[friend_id]
        AND NOT friend=$_SESSION[user_id])")
      or die("Your friend is a hermit!");
      
    return $view;
  }

  /* Get the information of the friend's/user's friends. */
  function getFriendsFriend($friendsFriendID){

    $friendsFriend=mysql_query("SELECT user_photo,user_id,user_firstname,user_surname,user_study,user_work FROM user
      WHERE user_id=$friendsFriendID") or die("Friend's friend fetch failed.");

    $friendsFriendFetch=mysql_fetch_array($friendsFriend);

    return $friendsFriendFetch;

  }

  function unfriendPopupWindow(){
    echo "<div class='unfriend'>";
      echo '<div id="unfriendConfirmation" class="popupWindowStyle">';
        echo '<div>';
          echo '<div class="closeBar">';
            echo '<a href="javascript:history.back();" title="Close" class="close">X</a>';
          echo '</div>';

          echo '<div class="contentBlock">';
          echo "<form method='post' action='../php/friendDelete.php'>";
            echo "<button class='btn' id='box-button' type='submit' name='cancel' style='width:80px'>Cancel</button>&nbsp;";
            echo "<button class='btn' id='box-button' type='submit' name='confirm' style='width:80px'>Confirm</button>";
            echo "</form>";
          echo '</div>';

        echo '</div>';
      echo '</div>';
    echo '</div>';
  }

  /* The popup window which well display user's/friend's friends. */
  function friendPopupWindow(){

    echo '<div id="popupWindow" class="popupWindowStyle">';
      echo '<div>';
        echo '<div class="closeBar">';
          echo '<a href="javascript:history.back();" title="Close" class="close">X</a>';
        echo '</div>';
        echo '<div class="contentBlock">';
        if(view()){

          $friendsFriendID=mysql_query("SELECT id FROM FriendsFriend
            GROUP BY id
            HAVING COUNT(*)=2");

          if(mysql_num_rows($friendsFriendID)>0){

              $firstname=array();
              $surname=array();
              $work=array();
              $study=array();
              $ID=array();

            while($friendsFriendIDFetch=mysql_fetch_array($friendsFriendID)){

              $display=getFriendsFriend($friendsFriendIDFetch["id"]);

                if($display){

                $firstname[]=$display["user_firstname"];
                $surname[]=$display["user_surname"];
                $work[]=$display["user_work"];
                $study[]=$display["user_study"];
                $ID[]=$display["user_id"];
              }
            }
                
                echo '<div id="friend-result-list">';
                echo '<table>';

                $frndtotal = count($ID);
                $br = "<br>";
                
                #if greater than 0, and odd number
                if (($frndtotal > 0) && (($frndtotal%2) != 0)) {
                  #up to the max even number
                  for ($i = 0; $i < $frndtotal; $i++) { 

                    if ($i == $frndtotal) { #if last item
                      echo "<tr><td>";
                      echoBlock($frndtotal,$firstname,$surname,$work,$study,$ID,$br);
                      echo '</td></tr>';

                    } elseif (($i == 0) || (($i%2) == 0)) {  # if 0 (1st item), even

                      echo "<tr>";
                      echo "<td>";
                      echoBlock($i,$firstname,$surname,$work,$study,$ID,$br);
                      echo '</td>';

                    } elseif (($i%2) != 0) { #if even: right side
                      echo "<td>";
                      echoBlock($i,$firstname,$surname,$work,$study,$ID,$br);
                      echo '</td>';
                      echo "</tr>";
                    }
                  
                  }

                } else {

                    for ($i = 0; $i < $frndtotal; $i++) { 

                      if (($i == 0) || (($i%2) == 0)) {  # if 0 (1st item), even

                      echo "<tr>";
                      echo "<td>";
                      echoBlock($i,$firstname,$surname,$work,$study,$ID,$br);
                      echo '</td>';

                    } elseif (($i%2) != 0) { #if even: right side
                      echo "<td>";
                      echoBlock($i,$firstname,$surname,$work,$study,$ID,$br);
                      echo '</td>';
                      echo "</tr>";
                      }

                    }

                  }
                echo '</table>';
                echo '</div>';
          }
          else{
            echo "<center><p>No friends to display.</p></center>";
          }
        }

        $dropView=mysql_query("DROP VIEW FriendsFriend");

        echo '</div>';
      echo '</div>';
    echo '</div>';

  }

  /* The block which displays the user/friend profile page. */
  function echoSideBar(){
    $friendFetch=friendFetch();
    echo "<div id='leftcolumn'>";
      echo '<div class="innertube">';
      echo '<div id="leftcolumn-text>';
        echo '<table>';
          echo '<tr id="username">';
            echo '<th>';

                echo "&nbsp; $friendFetch[user_firstname] $friendFetch[user_surname]";

            echo '</th>';
          echo '</tr>';
          echo '<tr>';
            echo '<td>';
              $userPhotoSize=userPhotoSize($_SESSION["friend_id"]);

               if($userPhotoSize>0){
                 echo "<center><img src='../php/profilePhoto.php?id=".$_SESSION["friend_id"]."' style='width:150px; padding:10px;'></center>";
               }
               else{
                 echo '<center><img src="../img/profileimg.png" style="padding: 10px;" width=150px></center>';
               }

          echo '</tr>';

          echo '<tr>';
            echo '<td height=250px>';

              echo "&nbsp; $friendFetch[user_birthday]<br>";
              echo "&nbsp; $friendFetch[user_gender]<br>";
              echo "&nbsp; $friendFetch[user_work]<br>";
              echo "&nbsp; $friendFetch[user_study]<br>";

              // If they are friends.
              if(relation()==2){

                // Show the friend's circle.
                $getCircle=getCircle();
                $getFriendCircle=$getCircle["circle"];
                $circleRemove=array('No circle','Study','Work','Family');
                $circleRemove=array_diff($circleRemove, array($getFriendCircle));
                $circleSelection=array_values($circleRemove);
                
                echo "<form method='post' action='../php/circleUpdate.php'>";
                echo "<p>&nbsp; Circles: <select name='circle' onchange='this.form.submit()'>";
                echo "<option selected>".$getFriendCircle."</option>";
                echo "<option value='$circleSelection[0]'>$circleSelection[0]</option>";
                echo "<option value='$circleSelection[1]'>$circleSelection[1]</option>";
                echo "<option value='$circleSelection[2]'>$circleSelection[2]</option>";
                echo "</select>";
                echo "<br>";
                echo "<br>";


                //echo "<form method='post' action='../php/friendDelete.php'>";
                echo "&nbsp; <a href='#unfriendConfirmation'>Unfriend?</a>";
                //echo "</form>";

              }
              
            echo '</td>';
          echo '</tr>';

        echo '</table>';
      echo '</div>';
    echo '</div>';
    echo '</div>';
  }

  function echoNavigationBar(){
    echo '<div id="profilemenu">';
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
        echo '</div>';
      echo '</div>';
    echo '</div>';
  }

  /* Display the feed block when they are friends. */
  function echoFeed(){
    echo '<div id="contentcolumn">';
      echo '<div id="column-scroll">';
        echo '<div class="innertube">';
          echo '<div id="profilefeed">';
            echo '<center>';

            $getPost=getPost();
            $userPhotoSize=userPhotoSize($_SESSION["friend_id"]);
              echo "<div class='userProfile' style='margin-left:20ex; margin-top:-30px'>";
                while($getPostFetch=mysql_fetch_array($getPost)){

                 if($getPostFetch){
              
                  echo '<div id="newsFeedBlock">';
                    echo '<div style="text-align: -webkit-left;">';
                    
                      // The div for user_photo
                      echo '<div class="user_photo">';
                        if($userPhotoSize>0){

                         echo "<img src='../php/profilePhoto.php?id=".$_SESSION["friend_id"]."' style='width:50px;'>";
          
                        }
                        else{
                          echo '<img src="../img/profileimg.png" style="width:50px;">';

                        }
                      echo '</div>';

                      // The div for post details
                      echo '<div class="post_detail">';
                        echo '<ul style="list-style:none;">';
                          // The div for the user's name
                          echo '<li>';
                            echo '<div class="user_name">';
                              echo "<a href='friendProfilePage.php?name=".$getPostFetch["post_id"]."'>". $getPostFetch["user_firstname"]. " " . $getPostFetch["user_surname"] . "</a><br>";
                            echo '</div>';
                          echo '</li>';

                          echo '<li style="padding-top:35px;">';
                            echo '<div class="photoCommentBorder">';

                              // The div for the post photo
                              echo '<div class="post_photo">';
                                $photoID=$getPostFetch["id"];

                                $postPhotoSize=postPhotoSize($_SESSION["friend_id"],$photoID);
                                // If the photo size is bigger than 0, which means there is a photo in the database.
                                if($postPhotoSize>0){
                                  echo '<img src="../php/newsFeedPostPhoto.php?userID='.$_SESSION["friend_id"].'&photoID='.$photoID.'" style="width:250px">';
                                }
                              echo '</div>';

                            // The div for the post comment
                              echo '<div class="post_comment">';
                                echo $getPostFetch["post_comment"];
                              echo '</div>';

                            echo '</div>';
                          echo '</li>';

                          // The div for the post time
                          echo '<li>';
                            echo '<div class="post_time">';
                              echo $getPostFetch["post_time"];
                            echo '</div>';
                          echo '</li>';
                        echo '</ul>';
                      echo '</div>';

                    echo '<div>';
                  echo '</div>';
                 }
                 else{
                  echo "Something wrong.";
                 }

                }
              echo "</div>";
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
              echo "<button class='btn' id='box-button' type='button' disabled>Request sent</button>";
              echo "<p>";
            } 
            else{
              if(friendRequestFetch()){
                echo "<p>$friendFetch[user_firstname] $friendFetch[user_surname] has sent you a request.</p>";
                echo "<form method='post' action='../php/friendAcceptance.php'>";
                echo "<button class='btn' id='box-button' type='submit' name='confirm' style='width:80px'>Confirm</button>&nbsp;";
                echo "<button class='btn' id='box-button' type='submit' name='reject' style='width:80px'>Reject</button>";
                echo "</form>";
            }
              else{
                echo "<form method='post' action='../php/userRequest.php'>";
                echo "<button class='btn' id='box-button' type='submit'>Request</button>";
                echo "<p>";
                echo "</form>";
              }
            }

            echo "</center>";
          echo '</div>';
        echo '</div>';
      echo '</div>';
  echo '</div>';
  }

  function echoNoPost(){
    echo '<div id="contentcolumn">';
      echo '<div id="column-scroll">';

        echo '<div class="innertube" style="height:317px;">';
          echo '<center>Your friend did not post anything.';

          echo '<div id="profilefeed">';
          echo '</div>';
        echo '</div>';
      echo '</div>';
  echo '</div>';
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
<script type='text/javascript' src='../Libraries/jquery-1.9.1.js'></script>

<?php
include "../php/header.php";
?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type='text/javascript' src='../js/bootstrap.min.js'></script>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/feedStyle.css" rel="stylesheet"> 
    <link href="../css/popupWindow.css" rel="stylesheet"> 
    <link href="../css/friendProfilePage.css" rel="stylesheet">   
    <title>Hellooooooo!</title>

</head>
<body>


<?php
    include "../php/connection.php";
    include "../php/photoSize.php";
    if($_SESSION['user_id']!=$_GET['name']){
      if(relation()==2){
        $postOrNot=postOrNot();
        if(mysql_num_rows($postOrNot)>0){
          friendPopupWindow();
          echoNavigationBar();
          unfriendPopupWindow();
          echo '<div class="page" id="maincontainer" data-role="page">';
          echo '<div id="contentwrapper">';

          echoSideBar();
          echoFeed();

          echo '</div>';
          echo '</div>';
          
        }
        else{
          friendPopupWindow();         
          echoNavigationBar();
          unfriendPopupWindow();
          echo '<div class="page" id="maincontainer" data-role="page">';
          echo '<div id="contentwrapper">';

          echoSideBar();
          echoNoPost();

          echo '</div>';
          echo '</div>';

        }
      }
      else{
          echo '<div class="page" id="maincontainer" data-role="page">';
          echo '<div id="contentwrapper">';

          echoSideBar();
          echoBlankFeed();

          echo '</div>';
          echo '</div>';
      }
    }
    else{
      echo "<script>window.location.href = 'profile.php';</script>";
    }
?>

</body>
</html>