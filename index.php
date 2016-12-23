<?php
  include 'config.php';

  if (!isset($configured)) {
    header("Location: install.php");
  } else {
    include 'base.php';

    $result = mysqli_query($connection, "SELECT * FROM `accounts`");

    // If logged in, redirect to panel.
    if (!empty($_SESSION['logged_in'])) {
      header('Location: panel.php');
    }
    else if (isset($_POST['name']) && isset($_POST['password'])) {
      while ($row = mysqli_fetch_array($result)) {
        // If logging in and password is correct, log in user
        if (md5($_POST['password']) == $row['password']) {
          $_SESSION['logged_in'] = 1;
          $_SESSION['name'] = $_POST['name'];
          header('Location: panel.php');
        } else {
          // If password incorrect, redirect to login page.
          header('Location: .');
        }
      }
    }
?>

<!DOCTYPE html>
<html lang="en">
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

    <title>TigerScore</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
</head>

<body>
    <?php include 'templates/nav.php'; ?>

    <section id="welcome">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <img src="images/TigerScoreTrans.png" width="30%"></img>
                    <h1>Log In</h1>
                    <form action="." method="post">
                      <input name="name" type="text" class="inp" placeholder="Instructor Name"/>
                      <input name="password" type="password" class="inp" placeholder="Password"/>
                      <input name="submit" type="submit" class="login" value="Log In"/>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <!-- Allow links to be clicked -->
    <script>(function(a,b,c){if(c in b&&b[c]){var d,e=a.location,f=/^(a|html)$/i;a.addEventListener("click",function(a){d=a.target;while(!f.test(d.nodeName))d=d.parentNode;"href"in d&&(d.href.indexOf("http")||~d.href.indexOf(e.host))&&(a.preventDefault(),e.href=d.href)},!1)}})(document,window.navigator,"standalone")</script>
</body>
</html>
<?php } ?>
