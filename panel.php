<?php
  include 'base.php';
  include 'core.php';

  // If not logged in, redirect to login page.
  if (empty($_SESSION['logged_in'])) {
    header('Location: .');
  } else {
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="apple-touch-icon-precomposed" href="images/TigerScore.png" />
    <link rel="apple-touch-icon" href="images/TigerScore.png" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />

    <title>TigerScore</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
</head>

<body>
    <?php include 'templates/nav.php'; ?>

    <div id="grade">
      <div id="close-grade" onclick="closeGrade()">✕</div>
      <div id="grade-content">
        <h2>Grading <span id="which-form">Teguk Il Jang</span></h2>
        <p>Refer to the guidelines on the wall if you do not know how to use this system.</p>
        <h1 id="grade-mistakes">
          <span id='grade-mistakes-content'>0</span> mistakes
          <br /><br />
          <span id='grade-pass'><button class='label label-danger' onclick='removeMistake()'>-</button>&nbsp;&nbsp;<button class='label label-success' id="grade-pass-button">Pass</button>&nbsp;&nbsp;<button class='label label-danger' style='margin-bottom: 5px;' onclick='addMistake()'>+</button></span>
        </h1>
      </div>
    </div>
    <!-- Main panel -->
    <section id="panel">
        <!-- Sidebar -->
        <div class="sidebar">
          <h2>STUDENTS</h2>
          <h3>SEARCH</h3>
          <form id="student" action="panel.php" method="get">
              <input name="search" type="text" class="form-control student-search" placeholder="Student Name" autocomplete="off">
              <input type="submit" class="login ss" placeholder="Student Name">
          </form>

          <h3>LIST</h3>
          <div class="sidebar-list">
            <?php
              $result = mysqli_query($connection, "SELECT * FROM `tests`");
              $counter = 1;

              // Echo each student's name on the sidebar
              while ($rows = mysqli_fetch_array($result)) {
                echo '<a href="panel.php?student=' . $rows['full_name'] . '" class="noa">';
                if ($counter == 1) {
                  if (isset($_GET['student']) && $rows['full_name'] == $_GET['student']) {
                    echo '<div class="plist" style="border-top: 1px solid #494944; color: orange;">';
                  } else {
                    echo '<div class="plist" style="border-top: 1px solid #494944">';
                  }
                } else {
                  if (isset($_GET['student']) && $rows['full_name'] == $_GET['student']) {
                    echo '<div class="plist" style="color: orange;">';
                  } else {
                    echo '<div class="plist">';
                  }
                }

                // Echo user's belt color
                echo'<span style="border-radius: 3px; ';

                if (strpos($rows['present_belt'], '_') !== false) {
                  echo 'background: linear-gradient(to bottom, ' . substr($rows['present_belt'], 0, strpos($rows['present_belt'], "_")) . ', black 40%, ' . substr($rows['present_belt'], strpos($rows['present_belt'], "_") + 1, strlen($rows['present_belt'])) . ' 50%, black 60%, ' . substr($rows['present_belt'], 0, strpos($rows['present_belt'], "_")) . ');';
                } else {
                  echo 'background-color: ' . $rows['present_belt'];
                }
                echo '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;' . $rows['full_name'] . '<br />';
                $paycheck = mysqli_query($connection, "SELECT * FROM `info` WHERE `full_name` = '" . $rows['full_name'] . "';");
                while ($p = mysqli_fetch_array($paycheck)) {
                  if ($p['paid'] == 'false') {
                    echo '<span class="label label-danger">not paid</span>';
                  } else if ($p['paid'] == 'unsure') {
                    echo '<span class="label label-warning">unsure</span>';
                  } else {
                    echo '<span class="label label-success">paid</span>';
                  }
                }
                echo "</div></a>";

                $counter ++;
              }
            ?>
          </div>
        </div>

        <!-- Panel content -->
        <div id="panel-content">
          <?php
            if (isset($_GET['search'])) {
              echo "<div class='sidebar-list full'>";
              // If instructor is searching, give search results
              $search = strtolower($_GET['search']);
              echo "<h2>SEARCH RESULTS FOR <span style='color: orange;'>" . strtoupper($search) . "</span></h2>";
              $result = mysqli_query($connection, "SELECT * FROM `tests`");

              $counter = 1;

              // If nothing is added in search bar, list all students in the database
              if (strlen($search) == 0) {
                while ($rows = mysqli_fetch_array($result)) {
                  echo '<a href="panel.php?student=' . $rows['full_name'] . '" class="noa">';
                  if ($counter == 1) {
                    echo '<div class="plist" style="border-top: 1px solid #494944">';
                  } else {
                    echo '<div class="plist">';
                  }

                  echo'<span style="border-radius: 3px; ';

                  if (strpos($rows['present_belt'], '_') !== false) {
                    echo 'background: linear-gradient(to bottom, ' . substr($rows['present_belt'], 0, strpos($rows['present_belt'], "_")) . ', black 40%, ' . substr($rows['present_belt'], strpos($rows['present_belt'], "_") + 1, strlen($rows['present_belt'])) . ' 50%, black 60%, ' . substr($rows['present_belt'], 0, strpos($rows['present_belt'], "_")) . ');';
                  } else {
                    echo 'background-color: ' . $rows['present_belt'];
                  }
                  echo '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;';
                  echo $rows['full_name'] . "</div></a>";

                  $counter ++;
                }

                return;
              }

              $counter = 1;

              // Otherwise, retrieve all names matching the search results
              while ($rows = mysqli_fetch_array($result)) {
                if (strpos(strtolower($rows['full_name']), $search) !== false) {
                  echo '<a href="panel.php?student=' . $rows['full_name'] . '" class="noa">';
                  if ($counter == 1) {
                    echo '<div class="plist" style="border-top: 1px solid #494944">';
                  } else {
                    echo '<div class="plist">';
                  }

                  echo'<span style="border-radius: 3px; ';

                  if (strpos($rows['present_belt'], '_') !== false) {
                    echo 'background: linear-gradient(to bottom, ' . substr($rows['present_belt'], 0, strpos($rows['present_belt'], "_")) . ', black 40%, ' . substr($rows['present_belt'], strpos($rows['present_belt'], "_") + 1, strlen($rows['present_belt'])) . ' 50%, black 60%, ' . substr($rows['present_belt'], 0, strpos($rows['present_belt'], "_")) . ');';
                  } else {
                    echo 'background-color: ' . $rows['present_belt'];
                  }
                  echo '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;';
                  echo $rows['full_name'] . "</div></a>";

                  $counter ++;
                }
              }

              if ($counter == 1) {
                echo 'No results found!';
              }
              echo "</div>";
              // If not searching, and a student is selected, display.
            } else if (isset($_GET['student'])) {
              $result = mysqli_query($connection, "SELECT * FROM `tests` WHERE `full_name` = '" . $_GET['student'] . "';");
              $result_check = mysqli_query($connection, "SELECT * FROM `tests` WHERE `full_name` = '" . $_GET['student'] . "';");

              $forms = false;
              $breaking = false;
              $sparring = false;

              $completed = true;

              while ($rows = mysqli_fetch_array($result_check)) {
                foreach ($rows as $k => $v) {
                  if ($v !== null && !is_numeric($k) && $v == 0 && $k !== "full_name" && $k !== "present_belt" && $k !== "latest_tester") {
                    $completed = false;
                  }
                }
              }

              if (!$completed) {
                // Echo each of the requirement sections
                while ($rows = mysqli_fetch_array($result)) {
                  foreach ($rows as $k => $v) {
                    // Echo title for each, just once
                    if ($v !== null && !is_numeric($k)) {
                      if (!$forms && substr($k, 0, 5) == "forms") {
                        echo "<div class='forms'>
                                <h2>FORMS</h2>";
                        $forms = true;
                      }
                      if (!$breaking && substr($k, 0, 8) == "breaking") {
                        if ($forms) {
                          echo "</div>";
                        }
                        echo "<div class='breaking'>
                                <h2>BREAKING</h2>";
                        $breaking = true;
                      }
                      if (!$sparring && substr($k, 0, 8) == "sparring") {
                        if (($forms && !$breaking) || (!$forms && $breaking) || ($forms && $breaking)) {
                          echo "</div>";
                        }
                        echo "<div class='sparring'>
                                <h2>SPARRING</h2>";
                        $sparring = true;
                      }

                      // Echo requirements in specific form
                      if ($k !== "full_name" && $k !== "present_belt") {
                        if (substr($k, 0, 5) == "forms") {
                          if ($v == 0) {
                            echo "<table style='width: 100%;'>
                                    <td>
                                      <h4 style='display: inline-block; text-align: left; float: left;'>
                                        <span class='label label-primary'>" . $test_requirements[$k] . "</span>
                                      </h4>
                                    </td>
                                    <td>
                                      <h4 style='display: inline-block; text-align: right; float: right;'>
                                        <button class='label label-default' id='undo_" . $k . "' onclick='undo(\"" . $k . "\")' style='display: none;'>Undo</button>
                                        <button class='label label-success' id='pass_" . $k . "' onclick='grade(\"" . $k . "\")'>Grade</button>
                                      </h4>
                                    </td>
                                  </table>";
                          } else if ($v == 1) {
                            echo "<table style='width: 100%;'>
                                    <td>
                                      <h4 style='display: inline-block; text-align: left; float: left;'>
                                        <span class='label label-primary'>" . $test_requirements[$k] . "</span>
                                      </h4>
                                    </td>
                                    <td>
                                      <h4 style='display: inline-block; text-align: right; float: right;'>
                                        <button class='label label-default' id='undo_" . $k . "' onclick='undo(\"" . $k . "\")'>Undo</button>
                                        <button class='label label-success' id='pass_" . $k . "' onclick='grade(\"" . $k . "\")'>✓</button>
                                      </h4>
                                    </td>
                                  </table>";
                          }
                        }

                        if (substr($k, 0, 8) == "breaking") {
                          if ($v == 0) {
                            echo "<table style='width: 100%;'>
                                    <td>
                                      <h4 style='display: inline-block; text-align: left; float: left;'>
                                        <span class='label label-primary'>" . $test_requirements[$k] . "</span>
                                      </h4>
                                    </td>
                                    <td>
                                      <h4 style='display: inline-block; text-align: right; float: right;'>
                                        <button class='label label-default' id='undo_" . $k . "' onclick='undo(\"" . $k . "\")' style='display: none;'>Undo</button>
                                        <button class='label label-success' id='pass_" . $k . "' onclick='pass(\"" . $k . "\")'>Pass</button>
                                      </h4>
                                    </td>
                                  </table>";
                          } else if ($v == 1) {
                            echo "<table style='width: 100%;'>
                                    <td>
                                      <h4 style='display: inline-block; text-align: left; float: left;'>
                                        <span class='label label-primary'>" . $test_requirements[$k] . "</span>
                                      </h4>
                                    </td>
                                    <td>
                                      <h4 style='display: inline-block; text-align: right; float: right;'>
                                        <button class='label label-default' id='undo_" . $k . "' onclick='undo(\"" . $k . "\")'>Undo</button>
                                        <button class='label label-success' id='pass_" . $k . "' onclick='pass(\"" . $k . "\")'>✓</button>
                                      </h4>
                                    </td>
                                  </table>";
                          }
                        }

                        if (substr($k, 0, 8) == "sparring") {
                          if ($v == 0) {
                            echo "<table style='width: 100%;'>
                                    <td>
                                      <h4 style='display: inline-block; text-align: left; float: left;'>
                                        <span class='label label-primary'>" . $test_requirements[$k] . "</span>
                                      </h4>
                                    </td>
                                    <td>
                                      <h4 style='display: inline-block; text-align: right; float: right;'>
                                        <button class='label label-default' id='undo_" . $k . "' onclick='undo(\"" . $k . "\")' style='display: none;'>Undo</button>
                                        <button class='label label-success' id='pass_" . $k . "' onclick='pass(\"" . $k . "\")'>Pass</button>
                                      </h4>
                                    </td>
                                  </table>";
                          } else if ($v == 1) {
                            echo "<table style='width: 100%;'>
                                    <td>
                                      <h4 style='display: inline-block; text-align: left; float: left;'>
                                        <span class='label label-primary'>" . $test_requirements[$k] . "</span>
                                      </h4>
                                    </td>
                                    <td>
                                      <h4 style='display: inline-block; text-align: right; float: right;'>
                                        <button class='label label-default' id='undo_" . $k . "' onclick='undo(\"" . $k . "\")'>Undo</button>
                                        <button class='label label-success' id='pass_" . $k . "' onclick='pass(\"" . $k . "\")'>✓</button>
                                      </h4>
                                    </td>
                                  </table>";
                          }
                        }
                      }
                    }
                  }
                }
              }
            } else {
              // If not searching and no student is selected, nothing happens.
              echo "<p>Select a student from the sidebar or search the student's name.</p>";
            }
           ?>
           </div>
           <!-- Save buttons and latest tester -->
           <?php if (isset($_GET['student'])) { ?>
             <div class="latest-instructor">
               <b>Tester</b> - <?php $result = mysqli_query($connection, "SELECT * FROM `tests` WHERE `full_name` = '" . $_GET['student'] . "';"); while ($rows = mysqli_fetch_array($result)) { echo $rows['latest_tester']; } ?>
             </div>
           <?php } ?>
        </div>
    </section>

    <script src="js/core.js"></script>
    <script>
      var formBeingGraded = "";
      var mistakes = 0;

      function addMistake() {
        var content = document.getElementById("grade-mistakes-content");
        var passButton = document.getElementById("grade-pass-button");
        mistakes ++;

        content.innerHTML = mistakes;
        if (mistakes >= 5) {
          passButton.style.visibility = "hidden";
        } else {
          passButton.style.visibility = "visible";
        }
      }

      function removeMistake() {
        var content = document.getElementById("grade-mistakes-content");
        var passButton = document.getElementById("grade-pass-button");

        if (mistakes > 0) {
          mistakes --;
        }

        content.innerHTML = mistakes;
        if (mistakes >= 5) {
          passButton.style.visibility = "hidden";
        } else {
          passButton.style.visibility = "visible";
        }
      }

      function pass(skill) {
        // Frontend stuff
        var passButton = document.getElementById("pass_" + skill);
        passButton.innerHTML = "✓";

        var undoButton = document.getElementById("undo_" + skill);
        undoButton.style.display = "inline-block";

        // Save to Database
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "save.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var request = "";
        request += skill + "=1&requested=1&full_name=" + '<?php echo $_GET['student']; ?>';
        xhttp.send(request);
      }

      function grade(skill) {
        if (document.getElementById("pass_" + skill).innerHTML == "✓") {
          return;
        }
        // Frontend stuff
        document.getElementById("grade").style.display = "block";
        formBeingGraded = skill;
        document.getElementById("which-form").innerHTML = forms[formBeingGraded];
      }

      function closeGrade() {
        document.getElementById("grade").style.display = "none";
        document.getElementById("grade-pass-button").style.visibility = "visible";
        mistakes = 0;
        document.getElementById("grade-mistakes-content").innerHTML = "0";
        formBeingGraded = "";
      }

      document.getElementById("grade-pass-button").onclick = function() {
        if (mistakes < 5) {
          pass(formBeingGraded);
          closeGrade();
        }
      }

      function undo(skill) {
        // Frontend stuff
        var passButton = document.getElementById("pass_" + skill);

        var undoButton = document.getElementById("undo_" + skill);
        undoButton.style.display = "none";

        if (skill.indexOf('forms') !== -1) {
          passButton.innerHTML = "Grade";
        } else {
          passButton.innerHTML = "Pass";
        }

        // Save to Database
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "save.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var request = "";
        request += skill + "=0&requested=1&full_name=" + '<?php echo $_GET['student']; ?>';
        xhttp.send(request);
      }

      var panelContent = document.getElementById("panel-content");
      if (panelContent.innerHTML.trim() == "") {
        <?php
          $result = mysqli_query($connection, "SELECT * FROM `info` WHERE `full_name` = '" . $_GET['student'] . "';");
          $testing_for = "";
          $belt_size = 0;

          while ($row = mysqli_fetch_array($result)) {
            $testing_for = $row['testing_for'];
            $belt_size = $row['belt_size'];
          }
        ?>
        panelContent.innerHTML = "<h4 style='text-align: center;'><span class='label label-primary'><?php echo $_GET['student']; ?></span> has passed their exam and can recieve their <span class='label label-default'>size <?php echo $belt_size; ?></span> <span  class='label label-danger'><?php echo strtolower($belt_names[$testing_for]); ?></span> !</h4>";
      }
    </script>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <!-- Allow links to be clicked -->
    <script>(function(a,b,c){if(c in b&&b[c]){var d,e=a.location,f=/^(a|html)$/i;a.addEventListener("click",function(a){d=a.target;while(!f.test(d.nodeName))d=d.parentNode;"href"in d&&(d.href.indexOf("http")||~d.href.indexOf(e.host))&&(a.preventDefault(),e.href=d.href)},!1)}})(document,window.navigator,"standalone")</script>
</body>
</html>

<?php } ?>
