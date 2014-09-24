<?php
  if(!isset($_SESSION)) {
    session_start();
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
    <link href="../css/feedStyle.css" rel="stylesheet"> 
    <link href="../css/imgPop.css" rel="stylesheet">     
    <script type='text/javascript' src='../js/bootstrap.min.js'></script>
    <script type='text/javascript' src='../js/statusUpdate.js'></script>
    
</head>
<body>

<div class="page" data-role="page">

  <form method="post" action="../php/postUpdate.php" name="updatePost" enctype="multipart/form-data">
    <!-- The border of the post field-->
    <div id="statusBorder">
      <h3>&nbsp &nbsp &nbsp Say Hellooooooo!</h3>
      <!-- The post field including comment filed, upload button and submit button-->
      <div id="comment">
        <!-- The comment filed-->
        <div>
          <h3></h3>
          <textarea rows="10" name="post_comment" id="comment" placeholder="Say Hellooooooo! to your friends!" required></textarea>
        </div>
        <!-- The upload button-->
        <div class="file">
          <span class="glyphicon glyphicon-camera"><input type="file" name="post_photo" class="upload" onChange="readURL(this);"></span>
        </div>
        <!-- The preview of the iimage before upload. -->
        <center>
         <div id="imagePreview"></div>
        <center>
        <div>
          <input type="submit" name="submit" value="Post">
        </div>

      </div>
    </div>
  </form>

<?php

  function getPostID($myFriendIDFetch){

    $getPostID=mysql_query("SELECT post_id FROM Post,User
    WHERE post_id=$myFriendIDFetch GROUP BY post_time");

    $getPostIDFetch=mysql_fetch_array($getPostID);

    return $getPostIDFetch;
  }

  function getPost($postID){

    $getPost=mysql_query("SELECT id,post_id,post_time,post_photo,post_comment,user_firstname,user_surname FROM Post,User
      WHERE post_id IN ('".$postID."') AND post_id=user_id GROUP BY post_time DESC");

    return $getPost;
  }

  include "../php/connection.php";
  include "../php/photoSize.php";
  include "../php/usersFriend.php";

  // getMyFriendID() is including in php/usersFriend.php
  $myFriendID=getMyFriendID();

  // For calculating how many post for one specific user.
  $friendPostID=array();

  // For seeing the user's post in home feed.
  $friendPostID[]=$_SESSION["user_id"];

  while($myFriendIDFetch=mysql_fetch_array($myFriendID)){

    if($getPostIDFetch=getPostID($myFriendIDFetch["id"])){

      $friendPostID[]=$getPostIDFetch["post_id"];
    }
    
  }
  // Implode the array. Important!!
  $postID=implode("','",$friendPostID);

  //Call the get post function.
  $getPost=getPost($postID);

  echo "<div class='homeFeed' style='margin-left:35%;'>";
    while($getPostFetch=mysql_fetch_array($getPost)){
    
      // photoSize() is including in php/profilePhotoSize.php
      $userPhotoSize=userPhotoSize($getPostFetch["post_id"]);

      echo '<div id="newsFeedBlock">';
        echo '<div style="text-align: -webkit-left;">';
        
          // The div for user_photo
          echo '<div class="user_photo">';
            if($userPhotoSize>0){
              //echo '<img src="../php/newsFeedUserPhoto.php?name=$getPostFetch[post_id]" style="width:50px;">';
              echo "<img src='../php/profilePhoto.php?id=".$getPostFetch["post_id"]."' style='width:50px;'>";
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

                    $postPhotoSize=postPhotoSize($getPostFetch["post_id"],$getPostFetch["id"]);
                    if($postPhotoSize>0){
                      echo '<ul class="enlarge">';
                      echo '<img src="../php/newsFeedPostPhoto.php?userID='.$getPostFetch["post_id"].'&photoID='.$getPostFetch["id"].'" style="width:250px" alt="' . $getPostFetch["id"] . '">';
                      echo '<span><img src="../php/newsFeedPostPhoto.php?userID='.$getPostFetch["post_id"].'&photoID='.$getPostFetch["id"].'" alt="' . $getPostFetch["id"] . '">';
                      echo "<br/>" . $getPostFetch["post_comment"] . "</span>";
                      echo '</ul>';
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
  echo "</div>";
?>


</div>


  </body>
</html>