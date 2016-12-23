<?php
  include 'config.php';

  if (!isset($configured)) {
?>
  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="user-scalable=1.0,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
    <meta name="format-detection" content="telephone=no">

    <link rel="apple-touch-icon-precomposed" href="images/TigerScore.png" />
    <link rel="apple-touch-icon" href="images/TigerScore.png" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />

    <title>TigerScore &bull; Install</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
  </head>
  <body>
    <?php include 'templates/nav.php'; ?>

    <section class="install-container">
      <h2>Install TigerScore<span style="float: right; color: orange;">Step <?php if (!isset($_GET['step'])) { echo "1"; } else { echo $_GET['step']; } ?></span></h2>
      <?php
       if (!isset($_GET['step'])) {
      ?>
      <h3>Requirements</h3>
      <ul>
        <li>PHP</li>
        <li>SQL database with a username and password combination that has read/write permissions for the database</li>
        <li>Read/write permissions for files in this directory</li>
        <li>Any sort of mail server that is compatible with the PHP mail() function</li>
      </ul>

      <h3>Suggestions</h3>
      <ul>
        <li>If you already have a website for your academy, you may want to consider installing this in a subdirectory of the site (such as <b>/tigerscore/</b>)</li>
        <li>If you do not know how to install this yourself, or if you are having issues, the creator of this software can install it for you for $5, <a href="mailto:jmistri7@gmail.com">just email him</a>!</li>
      </ul>

      <a class="btn btn-primary" href="install.php?step=2"><h4>Acknowledge and Continue</h4></a>
      <?php
        } else {
          if ($_GET['step'] == '2') {
            ?>
            <h3>Database Configuration</h3>
            <form action="install.php?step=3" method="post">
              <p>Database Address <span style="color: red">*</span></p>
              <input name="address" id="db-address" type="text" class="inp" placeholder="127.0.0.1" />
              <p>Database User <span style="color: red">*</span></p>
              <input name="user" id="db-user" type="text" class="inp" placeholder="user" />
              <p>Database Password <span style="color: red">*</span></p>
              <input name="password" id="db-password" type="password" class="inp" placeholder="password" />
              <p>Database Name <span style="color: red">*</span></p>
              <input name="name" id="db-name" type="text" class="inp" placeholder="name" />
              <br />
              <input type="submit" id="db-submit" class="btn btn-primary inp-submit disabled" />
            </form>
            <?php
          } else if ($_GET['step'] == '3') {
            echo "<h3>Database Configuration</h3> <div class='log'>";
            $address = $_POST['address'];
            $user = $_POST['user'];
            $password = $_POST['password'];
            $name = $_POST['name'];
            echo "> Log - please read. If any text it red, the database initialization failed, so please click the link provided and go back.<br />";
            $connection = @mysqli_connect($address, $user, $password, $name);
            if (!$connection) {
              die('<span style="color: red">> Unable to connect to database: ' . mysqli_connect_error() . '. <a href="install.php?step=2">Please try again by clicking me</a>.</span>');
            } else {
              echo '> Successfully connected to database. <a href="install.php?step=4">Click me to continue</a>.';
              $base = fopen("base.php", "w");
              $text = '<?php' . "\n" . 'session_start();' . "\n" . 'include "config.php";' . "\n" . '$host = "' . $address . '";' . "\n" . '$username = "' . $user . '";' . "\n" . '$password = "' . $password . '";' . "\n" . '$database = "' . $name . '";' . "\n" . '$connection = mysqli_connect($host, $username, $password, $database) or die("Unable to connect to database! :(");' . "\n" . '?>';
              fwrite($base, $text);
              fclose($base);
            }
            echo "</div>";
          } else if ($_GET['step'] == '4') {
            ?>
            <h3>Database Installation and Configuration Part 2</h3>
            <form action="install.php?step=5" method="post">
              <p>Site Name <span style="color: red">*</span></p>
              <input name="site-name" id="site-name" type="text" class="inp" placeholder="TigerScore" />
              <p>Incoming Email Address (when a student registers, you will get an email to this account) <span style="color: red">*</span></p>
              <input name="email" id="email" type="text" class="inp" placeholder="your@email.com" />
              <p>Password (used for all instructors to log in) <span style="color: red">*</span></p>
              <input name="password" id="password" type="password" class="inp" placeholder="password" />
              <br />
              <input type="submit" id="submit" class="btn btn-primary inp-submit disabled" />
            </form>
            <?php
          } else if ($_GET['step'] == '5') {
            echo "<h3>Database Configuration</h3>";
            $site_name = $_POST['site-name'];
            $email = $_POST['email'];
            $site_password = md5($_POST['password']);

            require_once("base.php");

            $accounts = mysqli_query($connection, "CREATE TABLE `accounts` (`site_name` varchar(255), `email` varchar(255), `password` text);");
            $inhabit = mysqli_query($connection, "INSERT INTO `accounts` (`site_name`, `email`, `password`) VALUES ('$site_name', '$email', '$site_password');");
            $info = mysqli_query($connection, "CREATE TABLE `info` (`full_name` varchar(100) NOT NULL, `age` int(11) DEFAULT NULL, `gender` text, `belt_size` int(11) NOT NULL, `present_belt` text, `testing_for` text, `home_phone` text, `cell_phone` text, `paid` text NOT NULL, PRIMARY KEY (`full_name`) );");
            $tests = mysqli_query($connection, "CREATE TABLE `tests` ( `full_name` varchar(255) NOT NULL, `present_belt` varchar(255) NOT NULL, `forms_example` int(1) DEFAULT NULL, `breaking_example` int(1) DEFAULT NULL, `sparring_example` int(1) DEFAULT NULL, `latest_tester` varchar(255) NOT NULL DEFAULT 'nobody', PRIMARY KEY (`full_name`) );");

            // Keshav, if you see this, sup.
            echo '<a class="btn btn-primary inp-submit" href="install.php?step=6">Success! Continue to last step.</a>';
          } else if ($_GET['step'] == '6') {
            function echoTestingFormURL() {
              echo substr('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 0, -18)."form.php";
            }
            $configfile = fopen("./config.php", "w");
            $text = '<?php $configured = true; ?>';
            fwrite($configfile, $text);
            fclose($configfile);
            ?>
              <h3>Successfully Installed TigerScore!</h3>
              <p>Congratulations! TigerScore is successfully set up. You will not be able to view this install page again. From now on, this page will not exist. Please take a screenshot of it if you find the information here valuable.</p>
              <p>If you wish to make changes to the belts, prices, or skills, you will have to manually edit core.php, core.js, form.php, and the database. A feature will be added to the admin panel soon where this is done from a UI. If you are installing this on a personal computer for developing for Tiger Martial Arts, please ask Jamsheed for the new config file and database.</p>
              <p>If you want to access the testing form in its own page, you can access it at </p><xmp><?php echoTestingFormURL(); ?></xmp><p>Or you can embed on another site by pasting this code: </p><xmp><iframe src="<?php echoTestingFormURL(); ?>" width="300px" height="700px"></iframe></xmp>
              <a class="btn btn-danger inp-submit" href=".">Finish</a>
        <?php
          }
        }
      ?>
    </section>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <?php
      if (isset($_GET['step'])) {
        if ($_GET['step'] == '2') {
          ?>
          <script>
            $("#db-submit").click(function() {
              if ($("#db-submit").hasClass("disabled")) {
                return false;
              }
            });

            $("form").keyup(function() {
              if ($("#db-address").val() !== "" && $("#site").val() !== "" && $("#db-password").val() !== "" && $("#db-name").val() !== "") {
                if ($("#db-submit").hasClass("disabled")) {
                  $("#db-submit").removeClass("disabled");
                }
              } else {
                if (!$("#db-submit").hasClass("disabled")) {
                  $("#db-submit").addClass("disabled");
                }
              }
            });
          </script>
          <?php
        } else if ($_GET['step'] == '4') {
          ?>
          <script>
            $("#submit").click(function() {
              if ($("#submit").hasClass("disabled")) {
                return false;
              }
            });

            $("form").keyup(function() {
              if ($("#site-name").val() !== "" && $("#email").val() !== "" && $("#password").val()) {
                if ($("#submit").hasClass("disabled")) {
                  $("#submit").removeClass("disabled");
                }
              } else {
                if (!$("#submit").hasClass("disabled")) {
                  $("#submit").addClass("disabled");
                }
              }
            });
          </script>
          <?php
        }
      }
      ?>

    <!-- Allow links to be clicked -->
    <script>(function(a,b,c){if(c in b&&b[c]){var d,e=a.location,f=/^(a|html)$/i;a.addEventListener("click",function(a){d=a.target;while(!f.test(d.nodeName))d=d.parentNode;"href"in d&&(d.href.indexOf("http")||~d.href.indexOf(e.host))&&(a.preventDefault(),e.href=d.href)},!1)}})(document,window.navigator,"standalone")</script>
  </body>
  </html>
<?php
  } else {
    header("Location: .");
  }

?>
