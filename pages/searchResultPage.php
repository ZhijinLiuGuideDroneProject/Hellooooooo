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
    
<link href="../css/bootstrap.css" rel="stylesheet">

    <title>Hellooooooo! - Search Results</title>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

<style>


</style>

  </head>
  <body>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type='text/javascript' src='../js/bootstrap.min.js'></script>

<div class="page" data-role="page">

<div style="margin-left: 30%;"><h2>Search Results</h2></div>

<!--Entire list-->
<div id="search-result-list">
  <table>
    <?php
      include "../php/searchResult.php";
      include "../php/photoSize.php";

      if(mysql_num_rows($search)>0){
      while($display=mysql_fetch_array($search)){

      echo "<tr><td>";
      echo "<div class='searchResult'>";
      echo "<div class='profile-box'>";
      echo "<div id='box-displaypic'>";
      $userPhotoSize=userPhotoSize($display["user_id"]);

         if($userPhotoSize>0){
           echo "<center><img src='../php/profilePhoto.php?id=".$display["user_id"]."' style='height:104px; padding:10px;'></center>";
         }
         else{
           echo '<center><img src="../img/profileimg.png" style="padding: 10px;" width=90px></center>';
         }

      echo "</div>";
      echo "<div id='box-text'>";
      echo ("<a href='friendProfilePage.php?name=".$display['user_id']."'>".$display['user_firstname']." ".$display['user_surname']."</a><br>");
      echo "$display[user_work]<br>";
      echo "$display[user_study]<br>";
      echo "<a href='friendProfilePage.php?name=".$display['user_id']."'><button class='btn' id='box-button' type='button' >View Profile!</button></a>";
      echo "</div></div>";
      echo "</div>";
      echo "</td></tr>";
    }

  }
  else{
    $message="No such results!";
    echo "<script type='text/javascript'>alert('".$message."');history.back();</script>";
  }

    ?>

  </table>
  </div>
</div>
</div>

</body>
</html>