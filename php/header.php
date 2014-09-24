<?php
  if(!isset($_SESSION)){
    session_start();
  }
?>
<!--Navigation Bar-->
  <nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
  <div class="container">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="homeFeed.php">  
      Hellooooooo! 
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      <li><a href="friendRequestPage.php">

        <?php

        include "connection.php";

        $friendRequest=mysql_query("SELECT user FROM Friend
          WHERE friend=$_SESSION[user_id]
          AND user NOT IN (SELECT friend FROM Friend WHERE user=$_SESSION[user_id])");

        $notificationAmount=mysql_num_rows($friendRequest);

        ############ NOTIFICATION BADGE ##########

        #if ($notificationAmount > 0) {
          
          echo "<span class='badge'>" . $notificationAmount . "</span>";
        #}

        mysql_close($connection);
        ?>

      </a></li>


        <li class="active">
          <?php

            include "userProfile.php";

            echo "<a href='../pages/profile.php'>$userProfileFetch[user_firstname] $userProfileFetch[user_surname]</a>";

          ?>

        </li>

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="profile.php#popupWindow">Your Friends</a></li>
            <li><a href="photos.php">Your Photos</a></li>
            <li><a href="circles.php">Your Circles</a></li>
            <li class="divider"></li>
            <li><a href="activityLog.php">Your Activity Log</a></li>
          </ul>
        </li>        


        <li><a href="chat.php?name=0">Inbox
          <script type="text/javascript">
          </script>
        </a></li>

      </ul>
      
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings<b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="editProfile.php">Edit Profile</a></li>
            <li class="divider"></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>

      <form class="navbar-form navbar-right" role="search" method="post" action="../php/searchContent.php">
        <div class="form-group">
            <input type="text" class="form-control" name="searchBar" placeholder="Search your friends" required>
            <button type="submit" class="btn btn-default" value="Search" name="search">Search</button>
        </div>
        <!--input type="image" src="img/search.png" width="5%" height="5%" class="btn btn-default"-->
      </form>

      </ul>



  </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</div>
</nav>