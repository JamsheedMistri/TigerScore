<!DOCTYPE html>
<html lang="en" id="html">
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <meta name="viewport" content="user-scalable=1.0,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
      <meta name="apple-mobile-web-app-capable" content="yes">
      <meta name="format-detection" content="telephone=no">

      <title>TigerScore</title>

      <link href="css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
      <link href="css/main.css" rel="stylesheet">
      <link href="css/checkbox.css" rel="stylesheet">
  </head>

  <body>
      <section id="form">
          <div class="container">
              <div class="row">
                  <div class="col-lg-12 text-center">
                    <br />
                      <!-- <form action="validate.php" method="post"> -->
                        <input name="first_name" type="text" class="inp form-inp" maxlength="20" placeholder="Student First Name" style="width: 20em;"/>
                        <input name="last_name" type="text" class="inp form-inp" maxlength="20" placeholder="Student Last Name" style="width: 20em;"/>
                        <input name="middle_initial" type="text" class="inp form-inp" style="width: 11em;" maxlength="3" placeholder="Student Middle Initial"/>
                        <input name="age" type="text" class="inp form-inp" style="width: 8em;" maxlength="3" placeholder="Student Age"/>
                        <select name="gender" class="inp form-inp minimal" style="width: 11em;">
                          <option value="" disabled selected>Student Gender</option>
                          <option value="male">Male</option>
                          <option value="female">Female</option>
                          <option value="other">Other</option>
                        </select>
                        <input name="belt_size" type="text" class="inp form-inp" style="width: 11em;" maxlength="3" placeholder="Student Belt Size"/>
                        <select name="present_belt" class="inp form-inp minimal" style="width: 35em;">
                          <option value="" disabled selected>Present Belt</option>
                          <option value="white">White Belt</option>
                          <option value="white_yellow">White Belt With Yellow Stripe</option>
                          <option value="white_orange">White Belt With Orange Stripe</option>
                          <option value="white_purple">White Belt With Purple Stripe</option>
                          <option value="white_green">White Belt With Green Stripe</option>
                          <option value="white_blue">White Belt With Blue Stripe</option>
                          <option value="yellow">Yellow (Adult Only)</option>
                          <option value="yellow_white">Yellow Belt With White Stripe</option>
                          <option value="yellow_orange">Yellow Belt  With Orange Stripe</option>
                          <option value="orange">Orange Belt</option>
                          <option value="orange_black">Orange Belt With Black Stripe</option>
                          <option value="purple">Purple Belt</option>
                          <option value="purple_black">Purple Belt With Black Stripe</option>
                          <option value="green">Green Belt</option>
                          <option value="green_black">Green Belt With Black Stripe</option>
                          <option value="blue">Blue Belt</option>
                          <option value="blue_black">Blue Belt With Black Stripe</option>
                          <option value="brown">Brown Belt</option>
                          <option value="brown_black">Brown Belt With Black Stripe</option>
                          <option value="red">Red Belt</option>
                          <option value="red_black">Red Belt With Black Stripe</option>
                          <option value="black">Black Belt (testing for a plastic stripe)</option>
                          <option value="" disabled>Black Belt (testing for next degree - ask Master Hung for payment info)</option>
                        </select>

                        <select name="testing_for" class="inp form-inp minimal" style="width: 35em;">
                          <option value="" disabled selected>Testing For...</option>
                          <option value="white">White Belt ($45)</option>
                          <option value="white_yellow">White Belt With Yellow Stripe ($45)</option>
                          <option value="white_orange">White Belt With Orange Stripe ($45)</option>
                          <option value="white_purple">White Belt With Purple Stripe ($45)</option>
                          <option value="white_green">White Belt With Green Stripe ($45)</option>
                          <option value="white_blue">White Belt With Blue Stripe ($45)</option>
                          <option value="yellow">Yellow (Adult Only ($45))</option>
                          <option value="yellow_white">Yellow Belt With White Stripe ($45)</option>
                          <option value="yellow_orange">Yellow Belt  With Orange Stripe ($45)</option>
                          <option value="orange">Orange Belt ($45)</option>
                          <option value="orange_black">Orange Belt With Black Stripe ($55)</option>
                          <option value="purple">Purple Belt ($55)</option>
                          <option value="purple_black">Purple Belt With Black Stripe ($65)</option>
                          <option value="green">Green Belt ($65)</option>
                          <option value="green_black">Green Belt With Black Stripe ($65)</option>
                          <option value="blue">Blue Belt ($65)</option>
                          <option value="blue_black">Blue Belt With Black Stripe ($65)</option>
                          <option value="brown">Brown Belt ($65)</option>
                          <option value="brown_black">Brown Belt With Black Stripe ($85)</option>
                          <option value="red">Red Belt ($85)</option>
                          <option value="red_black">Red Belt With Black Stripe ($125)</option>
                          <option value="black">Plain Black Belt ($150)</option>
                          <option value="black_purple">Black Belt With Any Degree Intermediate Purple Stripe ($65)</option>
                          <option value="black_brown">Black Belt With Any Degree Intermediate Brown Stripe ($85)</option>
                          <option value="" disabled>Black Belt With Any Degree (ask Master Hung for payment info)</option>
                        </select>
                        <input name="home_phone" type="text" class="inp form-inp" maxlength="30" placeholder="Parent/Guardian Home Phone" style="width: 20em;"/>
                        <input name="cell_phone" type="text" class="inp form-inp" maxlength="30" placeholder="Parent/Guardian Cell Phone" style="width: 20em;"/>
                        <input name="email" type="text" class="inp form-inp" maxlength="50" placeholder="Parent/Guardian Email" style="width: 20em;"/>
                        <div class="checkbox">
                            <label style="font-size: 2.5em">
                                <input name="consent" type="checkbox" value="consent">
                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                            </label>
                        </div>
                        <label class="lbl" for="consent">Parental Consent</label>
                        <br />
                        <br />
                        <input onclick="submit();" type="submit" class="login form-sbmt" value="Submit" style="width: 20em;"/>
                  </div>
              </div>
          </div>
      </section>

      <script src="js/jquery.js"></script>
      <script src="js/bootstrap.min.js"></script>

      <script>
        function submit() {
          var first_name = document.getElementsByName('first_name');
          var middle_initial = document.getElementsByName('middle_initial');
          var last_name = document.getElementsByName('last_name');
          var age = document.getElementsByName('age');
          var gender = document.getElementsByName('gender');
          var belt_size = document.getElementsByName('belt_size');
          var present_belt = document.getElementsByName('present_belt');
          var testing_for = document.getElementsByName('testing_for');
          var home_phone = document.getElementsByName('home_phone');
          var cell_phone = document.getElementsByName('cell_phone');
          var email = document.getElementsByName('email');
          var consent = document.getElementsByName('consent');

          if (first_name[0].value !== "" &&
              last_name[0].value !== "" &&
              age[0].value !== "" &&
              gender[0].value !== "" &&
              belt_size[0].value !== "" &&
              present_belt[0].value !== "" &&
              testing_for[0].value !== "" &&
              home_phone[0].value !== "" &&
              cell_phone[0].value !== "" &&
              email[0].value !== "" &&
              consent[0].value !== "") {
                var xhttp = new XMLHttpRequest();
                xhttp.open("POST", "validate.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                var request = "first_name=" + first_name[0].value + "&" + "middle_initial=" + middle_initial[0].value + "&" + "last_name=" + last_name[0].value + "&" + "age=" + age[0].value + "&" + "gender=" + gender[0].value + "&" + "belt_size=" + belt_size[0].value + "&" + "present_belt=" + present_belt[0].value + "&" + "testing_for=" + testing_for[0].value + "&" + "home_phone=" + home_phone[0].value + "&" + "cell_phone=" + cell_phone[0].value + "&" + "email=" + email[0].value;
                xhttp.send(request);
                alert("Your form was submitted successfully! Please bring your payment as soon as possible! Your receipt has been emailed to you.");
                document.getElementById("html").style.display = "none";

              } else {
                var neededField = "fill out ";
                if(first_name[0].value == ""){
                  neededField += "First Name";
                 } else if(last_name[0].value !== ""){
                  neededField += "Last Name";
                 } else if(age[0].value == ""){
                  neededField += "Age";
                 } else if(gender[0].value == ""){
                  neededField += "Gender";
                 } else if(belt_size[0].value == ""){
                  neededField += "Belt Size";
                 } else if(present_belt[0].value == ""){
                  neededField += "Present Belt";
                 } else if(testing_for[0].value == ""){
                  neededField += "Belt Testing for";
                 } else if(home_phone[0].value == ""){
                  neededField += "Home Phone";
                 } else if(cell_phone[0].value == ""){
                  neededField += "Cell Phone";
                 } else if(email[0].value == ""){
                  neededField += "Email";
                 } else if(consent[0].value == ""){
                  neededField = "give Parental Consent";
                 }
                   
                alert("Your form was NOT submitted because you did not " + neededField + ".");
              }
        }
      </script>
  </body>
</html>
