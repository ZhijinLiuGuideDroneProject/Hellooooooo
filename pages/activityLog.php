<?php
if(!isset($_SESSION)){
    session_start();
}
  include "../php/connection.php";
?>

<html lang="en">
  <head>

<script type='text/javascript' src='../Libraries/jquery-1.9.1.js'></script>
<script type='text/javascript' src='../js/bootstrap.min.js'></script>
<?php
include "../php/header.php";
?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
<link href="../css/bootstrap.css" rel="stylesheet">

    <title>Hellooooooo! - Activity Log</title>

  </head>
  <body>


<style type="text/css">

  #activitylog {
    background-color: rgba(255, 255, 255, 0.5);
    margin-left: 10%;
    margin-right: 10%;
    margin-bottom: 20px;
    padding-top: 10px;
  }

</style>

<div class="page" data-role="page">

  <h3 style="margin-left: 10%;">Activity Log</h3>

<div id="activitylog">
  <center>
  <table>

  <?php
    function friendAdd() {
      include "../php/connection.php";
      $friend = mysql_query("SELECT user_id, user_firstname, user_surname FROM User WHERE user_id IN (SELECT friend FROM friend WHERE user = $_SESSION[user_id])") or die("<p>Could not fetch activity.</p>");
        $arrayFriend = array();
        while ($friendFetch = mysql_fetch_array($friend)) {
            array_push($arrayFriend, $friendFetch);
        }
       return $arrayFriend;
    }

    $friendAdd = friendAdd();

    # Not used here in example: but in order of date
    $date = "2014-03-21 14:42:43";

    if (count($friendAdd) == 0) {
      echo "You have no friend activities to show.";
    } else {

    foreach ($friendAdd AS $i) { 
      echo "<tr><td>";
      echo "You became friends with " . $i["user_firstname"] . " " . $i["user_surname"] . ".<br>";
      echo "<font color='gray' size='1'><p style='text-align: right;'>" . "Day " . $date . "</p></font><p>";
      echo "<hr></td></tr>";
    }
  }

  ?>

</table>
</centeR>

</div>



</div>


  </body>
</html>