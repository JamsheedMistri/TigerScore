<?php
  include 'base.php';
  include 'core.php';

  // If not logged in, do not allow injection
  if (empty($_SESSION['logged_in'])) {
    header('Location: .');
  } else {
    // For each reqeust, update database
    if (isset($_POST['requested'])) {
      foreach ($_POST as $x => $y) {
        if ($x !== "requested" && $x !== "full_name") {
          $sql = "UPDATE `tests` SET `" . $x . "` = " . $y . " WHERE `full_name` = '" . $_POST['full_name'] . "';";
          mysqli_query($connection, $sql);
        }
      }
      $sql = "UPDATE `tests` SET `latest_tester` = '" . $_SESSION['name'] . "' WHERE `full_name` = '" . $_POST['full_name'] . "';";
      mysqli_query($connection, $sql);
    }
  }
?>
