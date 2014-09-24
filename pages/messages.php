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

    <title>Hellooooooo! - Messages</title>

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
#header {
    background: #c2c2c2;
    height: 50px
}

#wrapper {
    width: 100%;
}

#left {
    background: #d7d7d7;
    position: absolute; /* IMPORTANT! */
    width: 25%;
    height: 100%;
}

#right {
    position: relative;
    width: 70%;
    background-color: rgba(255, 255, 255, 0.5);
    float: right;
    margin-right: 10px;
}

#sidebar {
    background-color: rgba(255, 255, 255, 0.5);
    width: 100%;
    margin-left: 10px;
}

.clear {
    clear: both
}

#footer {
    background: #c2c2c2
}

</style>

<script type="text/javascript">
$(document).ready(function () {

    var length = $('#left').height() - $('#sidebar').height() + $('#left').offset().top;

    $(window).scroll(function () {

        var scroll = $(this).scrollTop();
        var height = $('#sidebar').height() + 'px';

        if (scroll < $('#left').offset().top) {

            $('#sidebar').css({
                'position': 'absolute',
                'top': '0'
            });

        } else if (scroll > length) {

            $('#sidebar').css({
                'position': 'absolute',
                'bottom': '0',
                'top': 'auto'
            });

        } else {

            $('#sidebar').css({
                'position': 'fixed',
                'top': '0',
                'height': height
            });
        }
    });
});

</script>

<div id="wrapper">

  <div id="left">

    <div id="sidebar">

      Sidebar Content<p>
      Sidebar Content<p>
      Sidebar Content<p>
            Sidebar Content<p>
    </div>

  </div>

  <div id="right">

    This is the text of the main part of the page. fjdgjoidfjigjiojiojio
            <script>
        var string = "";
          for (var i = 0; i < 50; i++) {
            string += "blah blah<p>"
          }

          document.write(string);
        </script>

  </div>

  <div class="clear"></div>

</div>



</div>


  </body>
</html>