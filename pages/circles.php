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

  function familyCircle($myFriendIDImplode){

    $familyCircle = mysql_query("SELECT user,friend,circle,user_id,user_firstname,user_surname,user_study,user_work FROM User,Friend
        WHERE (user=$_SESSION[user_id] AND friend IN ('".$myFriendIDImplode."') AND circle='Family') AND (user_id IN ('".$myFriendIDImplode."')) AND user_id=friend");

    return $familyCircle;
  }

    function workCircle($myFriendIDImplode){

    $workCircle = mysql_query("SELECT user,friend,circle,user_id,user_firstname,user_surname,user_study,user_work FROM User,Friend
        WHERE (user=$_SESSION[user_id] AND friend IN ('".$myFriendIDImplode."') AND circle='Work') AND (user_id IN ('".$myFriendIDImplode."')) AND user_id=friend");

    return $workCircle;
  }

    function studyCircle($myFriendIDImplode){

    $studyCircle = mysql_query("SELECT user,friend,circle,user_id,user_firstname,user_surname,user_study,user_work FROM User,Friend
        WHERE (user=$_SESSION[user_id] AND friend IN ('".$myFriendIDImplode."') AND circle='Study') AND (user_id IN ('".$myFriendIDImplode."')) AND user_id=friend");

    return $studyCircle;
  }
?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
<link href="../css/bootstrap.css" rel="stylesheet">

    <title>Hellooooooo! - Circles</title>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type='text/javascript' src='../js/bootstrap.min.js'></script>

<div class="page" data-role="page">

<style>
  #circle-page {
    padding: 1px 10px 10px 10px;
    margin-left: 25%;
    margin-right: 25%;
    background-color: rgba(255, 255, 255, 0.5);
  }

</style>

  <script type="text/javascript">
    $('#myTab a').click(function (e) {
      e.preventDefault()
      $(this).tab('show')
    })

    $('#myTab a:first').tab('show')

  </script>

<div id="circle-page">

  <h3>Your Circles</h3>
  <ul class="nav nav-tabs">
    <li class="active"><a href="#family" data-toggle="tab">Family</a></li>
    <li><a href="#work" data-toggle="tab">Work</a></li>
    <li><a href="#study" data-toggle="tab">Study</a></li>
  </ul>
<p>

    <?php
      include "../php/connection.php";
      include "../php/usersFriend.php";
      include "../php/photoSize.php";
      $myFriendID=getMyFriendID();

      $myFriendIDArray=array();

      while($myFriendIDFetch=mysql_fetch_array($myFriendID)){

        // As it is AS "id" in the getMyFriendID function, so it is not $myFriendIDFetch["user_id"]!
        $myFriendIDArray[]=$myFriendIDFetch["id"];
      }
      
      $myFriendIDImplode=implode("','",$myFriendIDArray);
    ?>
<!-- Tab panes -->
<div class="tab-content">

      <!-- INBOX LIST -->
  <div class="tab-pane fade in active" id="family">
    <center>
    <table>
    <?php

      $familyCircle=familyCircle($myFriendIDImplode);
      
      while($familyCircleFetch=mysql_fetch_array($familyCircle)){

        $userPhotoSizeFamilyCircle=userPhotoSize($familyCircleFetch["user_id"]);

        echo "<tr><td>";
        if($userPhotoSizeFamilyCircle>0){
              //echo '<img src="../php/newsFeedUserPhoto.php?name=$getPostFetch[post_id]" style="width:50px;">';
              echo "<img src='../php/profilePhoto.php?id=".$familyCircleFetch["user_id"]."' width=20% style='padding-right: 2px;'>";
            }
            else{
              echo "<img src='../img/profileimg.png' width=20% style='padding-right: 2px;'>";
            }
        echo "<a href='friendProfilePage.php?name=".$familyCircleFetch["user_id"]."'>". $familyCircleFetch["user_firstname"]. " " . $familyCircleFetch["user_surname"] . "</a>";
        echo "<hr></td></tr>";
        }
    ?>

  </table>
</center>
  </div>

<!-- FRIEND LIST -->
  <div class="tab-pane fade" id="work">
    <center>
    <table>

      <?php 

        $workCircle=workCircle($myFriendIDImplode);
        
        while($workCircleFetch=mysql_fetch_array($workCircle)){

        $userPhotoSizeWorkCircle=userPhotoSize($workCircleFetch["user_id"]);

        echo "<tr><td>";
        if($userPhotoSizeWorkCircle>0){
              echo "<img src='../php/profilePhoto.php?id=".$workCircleFetch["user_id"]."' width=20% style='padding-right: 2px;'>";
            }
            else{
              echo "<img src='../img/profileimg.png' width=20% style='padding-right: 2px;'>";
            }
        echo "<a href='friendProfilePage.php?name=".$workCircleFetch["user_id"]."'>". $workCircleFetch["user_firstname"]. " " . $workCircleFetch["user_surname"] . "</a>";
        echo "<hr></td></tr>";
        }
      ?>
      
    </table>
  </center>

  </div>  

<!-- STUDY LIST -->
  <div class="tab-pane fade" id="study">
    <center>
    <table>

      <?php 

      $studyCircle=studyCircle($myFriendIDImplode);
        
        while($studyCircleFetch=mysql_fetch_array($studyCircle)){

        $userPhotoSizeStudyCircle=userPhotoSize($studyCircleFetch["user_id"]);

        echo "<tr><td>";
        if($userPhotoSizeStudyCircle>0){
              echo "<img src='../php/profilePhoto.php?id=".$studyCircleFetch["user_id"]."' width=20% style='padding-right: 2px;'>";
            }
            else{
              echo "<img src='../img/profileimg.png' width=20% style='padding-right: 2px;'>";
            }
        echo "<a href='friendProfilePage.php?name=".$studyCircleFetch["user_id"]."'>". $studyCircleFetch["user_firstname"]. " " . $studyCircleFetch["user_surname"] . "</a>";
        echo "<hr></td></tr>";
        }      

      ?>
      
    </table>
  </center>

  </div>  
  
</div>

</div>
</div>


  </body>
</html>