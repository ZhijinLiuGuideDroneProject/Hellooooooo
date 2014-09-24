<!DOCTYPE html>
<html lang="en">
  <head>

<script type='text/javascript' src='js/importScript.js'></script>

<?php
include "php/homeHeader.php";
?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hellooooooo!</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>

  <body>

<style>

#login {
  position: absolute;
  top: 25%;
  left: 47%;
  margin-top: -50px;
  margin-left: -100px;
  background-color: rgba(255, 255, 255, 0.5);
  padding-left: 25px;
  padding-right: 25px;
  padding-bottom: 10px;
  border-radius: 15px;
  box-shadow: 3px 3px 6px #888888;

}

</style>

<div style="width:100%;">

<center>
<div class="login" id="login">

  <center>
  <form method="post" action="php/login.php" name="login">
  <h2 style="text-align:center">Hellooooooo!</h2> 
    <div style="text-align:center"><input type="text" name="email" size="30" placeholder="Username" required></div><p>
    <div style="text-align:center"><input type="password" name="password" size="30" placeholder="Password" required></div><br>

  <center><button class="btn btn-lg btn-primary btn-block" type="submit" value="Login" name="login" style="width: 50%;">Login</button></center>
   <br>
   <a href="#">Forgotten your password?</a><br>
    <a href="pages/registerPage.php">Or Register Here!</a><br>
    </p>


  </form>

</center>
</div>
</center>
</div>


  </body>
</html>