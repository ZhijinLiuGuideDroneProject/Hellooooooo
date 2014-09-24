<html>
<head>

  <script type='text/javascript' src='../Libraries/jquery-1.9.1.js'></script>
<?php
  include "../php/header.php";

  list($year,$month,$day)=explode("-",$userProfileFetch["user_birthday"]);

?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="../css/bootstrap.css" rel="stylesheet">
    <script type='text/javascript' src='../Libraries/jquery-1.11.0.min.js'></script>
    <script type='text/javascript' src='../js/bootstrap.min.js'></script>

    
<title>Hellooooooo! - Edit Profile</title>
</head>
<body>

<div style="text-align:center;" id="editProfile-style">
  <div style="padding-left:30px; padding-right:30px;">
  <center>
    <br>
    <br>
    <h3><font color="gray">Edit Profile</font></h3>
  <form method="post" action="../php/profileUpdate.php" name="updateProfile" enctype="multipart/form-data">

    <table>
        <tr>
          <td style="text-align: right; padding-right: 7px;">
            First Name:
          </td>
          <td>
            <input type="text" name="firstname" value="<?= $userProfileFetch['user_firstname'] ?>"><p>
          </td>
        </tr>

        <tr>
          <td style="text-align: right; padding-right: 7px;">
            Surname: 
          </td>
          <td>
            <input type="text" name="surname" size="20" value="<?= $userProfileFetch['user_surname'] ?>"><p>
          </td>
        </tr>       

    </table>

    <div>
      <?php
        if($userProfileFetch["user_gender"]=='Male'){
          echo '<input type="radio" name="gender" value="Male" checked> Male';
          echo '  <input type="radio" name="gender" value="Female"> Female<p>';
        }
        else{
          echo '<input type="radio" name="gender" value="Male"> Male';
          echo '  <input type="radio" name="gender" value="Female" checked> Female<p>';
        }
      ?>
    </div>

    
      <div id="dob">
        <script> 
        function yearList() {
            var year="<?php echo $year; ?>";
            var yearString = '';
            yearString += '<select required name="year">';
            yearString += '<option disabled selected stle="display: none;">'+year+'</option>';

            for (var i = 2014; i > 1900; i--) {
                yearString += '<option value="' + i + '"">' + i + '</option>';
            }

            yearString += '</select>';

            return yearString;
        }

        function monthList() {
            var month="<?php echo $month; ?>";
            var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"];

            var monthString = '';
            monthString += '<select required name="month">';
            monthString += '<option disabled selected style="display:none;">'+month+'</option>';

            for (var j = 0; j < months.length; j++) {

                if (j <= 8) {
                    monthString += '<option value="0' + (j+1) + '">' + months[j] + '</option>';
                } else {
                    monthString += '<option value="' + (j+1) + '">' + months[j] + '</option>';
                }
            }

            monthString += '</select>';
            return monthString;
        }

        function dayList() {
          var day="<?php echo $day; ?>";
            var dayString = '';
            dayString += '<select required name="day">';
            dayString += '<option disabled selected stle="display: none;">'+day+'</option>';

            for (var i = 1; i < 32; i++) {

                if (i < 10) {
                    dayString += '<option value="0' + i + '">' + i + '</option>';
                } else {
                    dayString += '<option value="' + i +'">' + i + '</option>';
                }
            }

            dayString += '</select>';

            return dayString;
        } 

            
        document.getElementById("dob").innerHTML= "Date of Birth: " + yearList() + monthList() + dayList();

        </script>
      </div>
      <br>

      <div class="row">
        <input type="text" name="study" value="<?= $userProfileFetch['user_study'] ?>">
        <input type="text" name="work" size="20" value="<?= $userProfileFetch['user_work'] ?>">
        <br>
     </div>

      <br>
      <p><font color="gray">Please upload your profile photo</font></p>
      <input type="file" name="photo">
      <br>

<!--ASK FOR CURRENT AS WELL?-->
      <table>

        <tr>
          <td style="text-align: right; padding-right: 7px;">
            New Password:  
          </td>
          <td>
            <input type="password" name="password1" size="30" placeholder="Password"><p>
          </td>
        </tr>

        <tr>
          <td style="text-align: right; padding-right: 7px;">
            Re-enter Password: 
          </td>
          <td>
            <input type="password" name="password2" size="30" placeholder="Re-enter Password"><p>
          </td>
        </tr> 

      </table>  

      <font color="gray"><i>Passwords must be at least 6 characters long, and contain one or more numbers. </i></font><p>

      <p>

      <input class="btn btn-lg btn-primary btn-block" type="submit" value="Update" name="reditProfile" style="width: 20%;">

  </form>
  </center>
</div>
</div>

</body>
</html>