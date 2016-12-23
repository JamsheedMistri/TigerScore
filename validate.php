<?php
  include 'base.php';
  include 'core.php';

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $middle_initial = $_POST['middle_initial'];
    $full_name = "$first_name $middle_initial $last_name";
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $belt_size = $_POST['belt_size'];
    $present_belt = $_POST['present_belt'];
    $testing_for = $_POST['testing_for'];
    $home_phone = $_POST['home_phone'];
    $cell_phone = $_POST['cell_phone'];
    $email = $_POST['email'];

    function getEmail() {
      $read = mysqli_query($connection, "SELECT * FROM `accounts`;");
      while ($row = mysqli_fetch_array($read)) {
        return $row['email'];
      }
    }

    function getSiteName() {
      $read = mysqli_query($connection, "SELECT * FROM `accounts`;");
      while ($row = mysqli_fetch_array($read)) {
        return $row['site_name'];
      }
    }

    $incoming_email = getEmail();
    $site_name = getSiteName();
    $domain = $_SERVER['HTTP_HOST'];
    $tigerscore = substr('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 0, -19);

    $sql = "REPLACE INTO `info` (`full_name`, `gender`, `age`, `belt_size`, `present_belt`, `testing_for`, `home_phone`, `cell_phone`, `paid`) values ('$full_name', '$gender', '$age', '$belt_size', '$present_belt', '$testing_for', '$home_phone', '$cell_phone', 'false');";
    mysqli_query($connection, $sql);

    $message = '<!DOCTYPE html>
    <html style="font-family: &quot;Open Sans&quot;;background-color: white;">
        <body style="font-family: &quot;Open Sans&quot;;background-color: white;">
            <style>
                body, html {
                  font-family: "Open Sans";
                  background-color: white;
                }
                .container {
                  width: 80%;
                  margin-left: 10%;
                  margin-top: 5%;
                  box-shadow: 0 0 30px 5px black;
                }
                .header {
                  background-color: #30302e;
                  color: white;
                  padding: 10px 25px 10px 25px;
                }
                .content {
                  background-color: #4d4d48;
                  color: white;
                  padding: 10px 25px 10px 25px;
                }
                .go {
                  background-color: #79c15b;
                  padding: 12.5px;
                  text-decoration: none;
                  color: white;
                  border-radius: 3px;
                  font-weight: bold;
                }
                .go:hover {
                  color: gold;
                  padding: 15px;
                }
            </style>
            <div class="container" style="width: 80%;margin-left: 10%;margin-top: 5%;box-shadow: 0 0 30px 5px black;">
                <div class="header" style="background-color: #30302e;color: white;padding: 10px 25px 10px 25px;">
                    <h1><span style="color: orange">TigerScore</span> - New Testing Form</h1>
                </div>
                <div class="content" style="background-color: #4d4d48;color: white;padding: 10px 25px 10px 25px;">
                    <p>Hi!</p>
                    <p><b>' . $first_name . ' ' . $last_name . '</b> has just submitted a testing form. They are testing for <b>' . $belt_names[$testing_for] . '</b>, which costs <b>' . $prices[$testing_for] . '</b>. They have not paid yet. Once they pay, you can click the below button to verify that they have paid. To view if someone has paid already, you can click on their name on the control panel for TigerScore.</p>
                    <center>
                      <p>Please click here if they have paid:</p>
                      <a href="' . $tigerscore . 'payments.php?validate=' . md5($full_name) . '" class="go" style="background-color: #79c15b;padding: 12.5px;text-decoration: none;color: white;border-radius: 3px;font-weight: bold;">Verify Payment</a>
                    </center>
                    <p>Best Regards,<br>TigerScore</p>
                </div>
            </div>
        </body>
    </html>';
    $message = wordwrap($message, 70, "\r\n");

    $headers = 'From: "TigerScore" <tigerscore@' . $domain . '>' . "\r\n" . 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";

    mail($incoming_email, "New Testing Form", $message, $headers);

    $receipt = '<!DOCTYPE html>
    <html style="font-family: &quot;Open Sans&quot;;background-color: white;">
        <body style="font-family: &quot;Open Sans&quot;;background-color: white;">
            <style>
                body, html {
                  font-family: "Open Sans";
                  background-color: white;
                }
                .container {
                  width: 80%;
                  margin-left: 10%;
                  margin-top: 5%;
                  box-shadow: 0 0 30px 5px black;
                }
                .header {
                  background-color: #30302e;
                  color: white;
                  padding: 10px 25px 10px 25px;
                }
                .content {
                  background-color: #4d4d48;
                  color: white;
                  padding: 10px 25px 10px 25px;
                }
                .go {
                  background-color: #79c15b;
                  padding: 12.5px;
                  text-decoration: none;
                  color: white;
                  border-radius: 3px;
                  font-weight: bold;
                }
                .go:hover {
                  color: gold;
                  padding: 15px;
                }
            </style>
            <div class="container" style="width: 80%;margin-left: 10%;margin-top: 5%;box-shadow: 0 0 30px 5px black;">
                <div class="header" style="background-color: #30302e;color: white;padding: 10px 25px 10px 25px;">
                    <h1><span style="color: orange">' . $site_name . '</span> - Receipt</h1>
                </div>
                <div class="content" style="background-color: #4d4d48;color: white;padding: 10px 25px 10px 25px;">
                    <p>Hello, this email was delivered to you because your student, ' . $first_name . ', has just signed up for their testing form at ' . $site_name . ' to test for ' . $belt_names[$testing_for] . ', which costs ' . $prices[$testing_for] . '.</p>
                    <p>This is your receipt. Please keep it until your student has recieved their belt, in case there are any issues. <b>This does not mean that you have paid, it is just to show that you have signed up.</b> In order to pay for the examination, please bring your payment of ' . $prices[$testing_for] . ' to your academy as soon as possible.</p>
                    <p>Best Regards,<br>' . $site_name . '</p>
                </div>
            </div>
        </body>
    </html>';
    $receipt = wordwrap($receipt, 70, "\r\n");

    $recepit_headers = 'From: "' . $site_name . '" <testing@' . $domain . '>' . "\r\n" . 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";

    mail($email, "Your Receipt", $receipt, $recepit_headers);

    $inserts = 1;
    $test_insert = "REPLACE INTO `tests` (`full_name`, `present_belt`, ";
    foreach ($belt_requirements[$present_belt] as $requirement) {
      if ($requirement !== $belt_requirements[$present_belt][sizeof($belt_requirements[$present_belt]) - 1]) {
        $test_insert .= '`' . $requirement . '`, ';
        $inserts ++;
      } else {
        $test_insert .= '`' . $requirement . '`) values ("' . $full_name . '", "' . $present_belt . '", ';
        for ($i = 0; $i < $inserts; $i ++) {
          if ($i !== $inserts - 1) {
            $test_insert .= '0, ';
          } else {
            $test_insert .= '0);';
          }
        }
      }
    }

    mysqli_query($connection, $test_insert);
?>
