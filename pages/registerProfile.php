<html>
<head>

    <link href="../css/bootstrap.css" rel="stylesheet">
    <script type='text/javascript' src='../Libraries/jquery-1.11.0.min.js'></script>
    <script type='text/javascript' src='../js/bootstrap.min.js'></script>

<?php
include "../php/registerHeader.php";
?>

    
<title>Hellooooooo!</title>
</head>
<body>

<div style="text-align:center;" data-role="content" id="register-style">

<div class="btn-group btn-group-justified">
  <div class="btn-group">
    <button type="button" class="btn btn-default" disabled>1. Create Account</button>
  </div>
  <div class="btn-group">
    <button type="button" class="btn btn-default" style="background-color: #D8D8D8;"><b>2. Profile Details</b></button>
  </div>
</div>

<p>
    <!--TODO change when creating new edit profile page-->
    <form method="post" action="../php/registerProfileUpdate.php" enctype="multipart/form-data">
	<h3 style="text-align:center;"><font color="gray">2. Create Profile</font></h3> <p>

    <!--label style="display:block;text-align:center">First name:</label-->

    <!-- Name Input -->
    <!-- class="form-control" -->
    <div class="row">
        <input type="text" name="study" placeholder="Study" required>
        <input type="text" name="work" size="20" placeholder="Work" required>
        <p>
    </div>

    <center>
        <p>
        <p>
        <font color="gray">Please upload your profile photo</font></p>
        <input style="width: 17%" type="file" name="photo">
        <br>
        </center>
	<center>
    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Finish!" name="register" style="width: 30%;">

  </p>
    <a href="homeFeed.php">Or skip</a>
    </center>
	</form>

</div>


</body>
</html>