<?php

  if(!isset($_SESSION)){
      session_start();
  }

  function postOrNot(){
    $postOrNot=mysql_query("SELECT post_id FROM Post WHERE post_id=$_SESSION[user_id]");

    return $postOrNot;
  }

  function getPost(){

    $getPost=mysql_query("SELECT id,post_id,post_time,post_photo,post_comment,user_firstname,user_surname FROM Post,User
      WHERE post_id=$_SESSION[user_id] AND post_id=user_id GROUP BY post_time DESC");

    return $getPost;
  }

  /* Echo my friends in each block. */
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

  /* The block which displays the user/friend profile page. */
  function echoSideBar(){
    include "../php/userProfile.php";
    echo '<div id="leftcolumn">';
    echo '<div class="innertube">';
    echo '<table>';
      echo '<tr id="username">';
        echo '<th>';

          echo "&nbsp; $userProfileFetch[user_firstname] $userProfileFetch[user_surname]";

        echo '</th>';
      echo '</tr>';

      echo '<tr>';
        echo '<td>';

        $userPhotoSize=userPhotoSize($_SESSION["user_id"]);

         if($userPhotoSize>0){
           echo "<center><img src='../php/profilePhoto.php?id=".$_SESSION["user_id"]."' style='width:150px; padding:10px;'></center>";
         }
         else{
           echo '<center><img src="../img/profileimg.png" style="padding: 10px;" width=150px></center>';
         }
        echo '</td>';
      echo '</tr>';

      echo '<tr>';
        echo '<td height=250px>';
 
        echo "&nbsp; $userProfileFetch[user_birthday]</br>";
        echo "&nbsp; $userProfileFetch[user_gender]</br>";
        echo "&nbsp; $userProfileFetch[user_study]</br>";
        echo "&nbsp; $userProfileFetch[user_work]</br>";

        echo '</td>';
        echo '</tr>';

    echo '</table>';
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
          echo '<div class="btn-group">';
            echo '<a class="btn" type="button" class="btn btn-default" href="circles.php">Circles</a>';
          echo '</div>';
        echo '</div>';
      echo '</div>';
    echo '</div>';
  }

  function echoBlankFeed(){
    echo '<div id="contentcolumn">';
      echo '<div id="column-scroll">';

        echo '<div class="innertube" style="height:421px;">';
          echo '<center>You can share your life with your friends.';

          echo '<div id="profilefeed">';
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
            $userPhotoSize=userPhotoSize($_SESSION["user_id"]);
            echo "<div class='userProfile' style='margin-left:20ex; margin-top:-30px'>";
            while($getPostFetch=mysql_fetch_array($getPost)){

             if($getPostFetch){
              echo '<div id="newsFeedBlock">';
                echo '<div style="text-align: -webkit-left;">';
                
                  // The div for user_photo
                  echo '<div class="user_photo">';
                    if($userPhotoSize>0){

                     echo "<img src='../php/profilePhoto.php?id=".$_SESSION["user_id"]."' style='width:50px;'>";
      
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

                            $postPhotoSize=postPhotoSize($_SESSION["user_id"],$photoID);
                            // If the photo size is bigger than 0, which means there is a photo in the database.
                            if($postPhotoSize>0){
                              echo '<img src="../php/newsFeedPostPhoto.php?userID='.$_SESSION["user_id"].'&photoID='.$photoID.'" style="width:250px">';
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

  /* The popup window which well display user's/friend's friends. */
  function friendPopupWindow(){

    echo '<div id="popupWindow" class="popupWindowStyle">';
      echo '<div>';
        echo '<div class="closeBar">';
          echo '<a href="javascript:history.back();" title="Close" class="close">X</a>';
        echo '</div>';
        echo '<div class="contentBlock">';

        include "../php/usersFriend.php";
        $myFriendID=getMyFriendID();


          if(mysql_num_rows($myFriendID)>0){

              $firstname=array();
              $surname=array();
              $work=array();
              $study=array();
              $ID=array();

            while($myFriendIDFetch=mysql_fetch_array($myFriendID)){

               $display=getMyFriendProfile($myFriendIDFetch["id"]);

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
        

    $dropView=mysql_query("DROP VIEW FriendsFriend");
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

        <!-- Bootstrap -->
  <link href="../css/bootstrap.css" rel="stylesheet">
  <link href="../css/friendProfilePage.css" rel="stylesheet">
  <link href="../css/feedStyle.css" rel="stylesheet"> 
  <link href="../css/popupWindow.css" rel="stylesheet"> 
  <script type='text/javascript' src='../js/bootstrap.min.js'></script>
  <title>Hellooooooo!</title>

</head>
<body>

<?php
  include "../php/connection.php";
  include "../php/photoSize.php";
  $postOrNot=postOrNot();
  if(mysql_num_rows($postOrNot)>0){
    friendPopupWindow();
    echoNavigationBar();
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
    echo '<div class="page" id="maincontainer" data-role="page">';
    echo '<div id="contentwrapper">';

    echoSideBar();
    echoBlankFeed();
    
    echo '</div>';
    echo '</div>';
  }
?>
</body>
</html>