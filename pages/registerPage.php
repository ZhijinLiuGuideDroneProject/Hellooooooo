<html>
<head>

    <link href="../css/bootstrap.css" rel="stylesheet">
    <script type='text/javascript' src='../Libraries/jquery-1.11.0.min.js'></script>
    <script type='text/javascript' src='../js/bootstrap.min.js'></script>
    <!--script type="text/javascript" src="js/qTipScript.js"></script-->
    <!--script type='text/javascript' src='../Libraries/jquery-1.11.0.min.js'></script-->
    <!--script type 'text/javascript' src='Libraries/combodate/moment.min.2.0.0.js'></script--> 
    <!--script src="../Libraries/combodate/combodate.js"></script--> 

<?php
include "../php/registerHeader.php";
?>
    
<title>Hellooooooo!</title>
</head>

<body>


<div style="text-align:center;" data-role="content" id="register-style">

<div style="padding-left:30px; padding-right:30px;">
<div class="btn-group btn-group-justified">
  <div class="btn-group">
    <button type="button" class="btn btn-default" style="background-color: #D8D8D8;"><b>1. Create Account</b></button>
  </div>
  <div class="btn-group">
    <button type="button" class="btn btn-default" disabled>2. Profile Details</button>
  </div>
</div>
</div>

<p>

<form method="post" action="../php/register.php" name="registration">

  <h3 style="text-align:center;"><font color="gray">1. Create Account</font></h3> <p>

    <!--label style="display:block;text-align:center">First name:</label-->

    <!-- Name Input -->
    <!-- class="form-control" -->
    <div class="row">
        <input type="text" name="firstname" placeholder="First Name" required>
        <input type="text" name="surname" size="20" placeholder="Surname" required><p>
    </div>

    <div>
        <input type="radio" name="gender" value="Male" required value="1">Male
        <input type="radio" name="gender" value="Female">Female<p>
    </div>
    <p>

    <div id="dob">
        <script> 

        function yearList() {
            var yearString = '';
            yearString += '<select required name="year">';
            yearString += '<option disabled selected stle="display: none;">YYYY</option>';

            for (var i = 2014; i > 1900; i--) {
                yearString += '<option value="' + i + '"">' + i + '</option>';
            }

            yearString += '</select>';

            return yearString;
        }

        function monthList() {
            var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"];

            var monthString = '';
            monthString += '<select required name="month">';
            monthString += '<option disabled selected style="display:none;">MM</option>';

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
            var dayString = '';
            dayString += '<select required name="day">';
            dayString += '<option disabled selected stle="display: none;">DD</option>';

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
    <p>
    </div>

       
        <!--option>2014</option>
        <option>2013</option>
    </select>
    <select required>
        <option disable selected style="display:none;">MM</option>
        <option>Jan</option>
        <option>Feb</option>
    </select>
    <select required>
        <option disable selected style="display:none;">DD</option>
        <option>01</option>
        <option>02</option>
    </select><p-->    



    <!--input type="text" id="date" data-format="DD-MM-YYYY" data-template="D MMM YYYY" name="date" value="09-01-2013" required>
    <script>

        $('input').combodate({
            minYear: 1975,
            maxYear: 2013,
            minuteStep: 10
        });   

        $(function(){
        $('#date').combodate();    
        });
    </script><p-->

    <!-- Email Input -->
    <input type="email" name="email" size="47" placeholder="E-mail" required><br>
    <font color="gray"><i>This e-mail will be used to log into your account.</i></font><p>

    <!-- Password Input -->
    <input type="password" name="password1" size="30" placeholder="Password" required><br> 


    <font color="gray"><i>Passwords must be at least 6 characters long, and contain one or more numbers.</i></font><p>
    <input type="password" name="password2" size="30" placeholder="Re-enter Password" required><p>
    

    <!--label style="display:block;text-align:center">Gender:</label>
    <div style="text-align:center"><input type="text" name="gender" size="30"></div>
    <label style="display:block;text-align:center">Age:</label>
    <div style="text-align:center"><input type="text" name="age" size="30"--></div-->

    <!--label style="display:block;text-align:center">Study:</label>
    <div style="text-align:center"><input type="text" name="study" size="30"></div>
    <label style="display:block;text-align:center">Work:</label>
    <div style="text-align:center"><input type="text" name="work" size="30"></div-->
    <br>
  <center><input class="btn btn-lg btn-primary btn-block" type="submit" value="Next" name="register" style="width: 20%;"></center></p>
  </form>



</div>
</div>

</body>
</html>