<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>

	<center>

		<form method="post" action="XXX.php" enctype="multipart/form-data">
			<input type="file" name="photo">
			<input type="submit" value="Submit">
		</form>

		<?php
		 if($userPhotoSize>0){
           echo "<img src='../php/profilePhoto.php?id=".$_SESSION["user_id"]."'>";
         }
         else{
           echo '<img src="../img/profileimg.png">';
         }
		?>

	</center>

</body>
</html>