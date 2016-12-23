<?php
  include 'base.php';
  include 'core.php';

  if (!isset($_GET['validate'])) {
    header("Location: .");
  }

  $result = mysqli_query($connection, "SELECT * FROM `info`;");

  while ($row = mysqli_fetch_array($result)) {
    if (md5($row['full_name']) == $_GET['validate']) {
      mysqli_query($connection, "UPDATE `info` SET `paid` = 'true' WHERE `full_name` = '" . $row['full_name'] . "';");
      echo '<script language="javascript">';
      echo 'var answer = confirm ("Success!"); if (answer) { close(); } else { close(); }';
      echo '</script>';
    }
  }

?>
