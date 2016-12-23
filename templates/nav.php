<?php include 'config.php'; ?>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="."><?php if (isset($configured)) { require_once("base.php"); $read = mysqli_query($connection, "SELECT * FROM `accounts`;"); while ($row = mysqli_fetch_array($read)) { echo $row['site_name']; } } else { echo "TigerScore"; } ?></a>
            <?php if (!empty($_SESSION['logged_in'])) { ?>
              <ul class="nav navbar-nav">
                <li>
                    <a href="panel.php">Testing Panel</a>
                </li>
            </ul>
            <?php } ?>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <?php if (!empty($_SESSION['logged_in'])) { echo '<a href="logout.php">Log Out of Instructor ' . $_SESSION['name'] . '\'s Account</a>'; } else if (isset($configured)) { echo '<a href=".">Log In</a>'; } ?>
                </li>
            </ul>
        </div>
    </div>
</nav>
