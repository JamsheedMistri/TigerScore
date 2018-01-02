<?php require_once("utils.php"); ?>
<!DOCTYPE html>
<html lang="en" id="html">
<head>
  <title>TigerScore</title>

  <?php require_once("templates/headers.php"); ?>
  <link href="assets/css/testing_form.css" rel="stylesheet">
</head>

<body>
  <section id="form">
    <?php
    if (isset($_GET['from_app'])) {
      ?>
      <style>
      #form {
        padding: 50px 0 0 50px;
      }
    </style>
    <h5><a href="."><i class="fa fa-chevron-left"></i> Back to TigerScore</a></h5>
    <br>
    <?php
  }
  ?>
  <div id="actual_testing_form">
    <input name="first_name" type="text" maxlength="20" placeholder="Student First Name" style="width: 20em;"/>
    <input name="last_name" type="text" maxlength="20" placeholder="Student Last Name" style="width: 20em;"/>
    <input name="middle_initial" type="text" style="width: 11em;" maxlength="3" placeholder="Student Middle Initial"/>
    <input name="age" type="text" style="width: 8em;" maxlength="3" placeholder="Student Age"/>
    <select name="gender" style="width: 11em;">
      <option value="" disabled selected>Student Gender</option>
      <option value="male">Male</option>
      <option value="female">Female</option>
      <option value="other">Other</option>
    </select>
    <select name="present_belt" style="width: 25em;">
      <option value="" disabled selected>Present Belt</option>
      <?php
      $belts = getData("config/belts.json");
      foreach ($belts as $belt => $options) {
        echo '<option value="'.$belt.'">'.$options['name'].' ($'.$options['price'].')</option>';
      }
      ?>
    </select>

    <select name="testing_for" style="width: 25em;">
      <option value="" disabled selected>Testing For...</option>
      <?php
      $belts = getData("config/belts.json");
      foreach ($belts as $belt => $options) {
        echo '<option value="'.$belt.'">'.$options['name'].'</option>';
      }
      ?>
    </select>
    <select name="belt_size" style="width: 7em;">
      <option value="" disabled selected>Belt Size</option>
      <option value="0">0</option>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
    </select>
    <input name="home_phone" type="tel" maxlength="30" placeholder="Parent/Guardian Home Phone" style="width: 20em;"/>
    <input name="cell_phone" type="tel" maxlength="30" placeholder="Parent/Guardian Cell Phone" style="width: 20em;"/>
    <input name="email" type="email" maxlength="50" placeholder="Parent/Guardian Email" style="width: 20em;"/>
    <label>
      <input class="label__checkbox" type="checkbox" id="consent" />
      <span class="label__text">
        <span class="label__check">
          <i class="fa fa-check icon"></i>
        </span>
      </span>
    </label>
    <span class="consent-label">Parental Consent</span>
    <br />
    <br />
    <input type="submit" value="Submit" />
  </div>
</section>

<?php require_once("templates/scripts.php"); ?>
<script src="assets/js/testing_form.js"></script>
</body>
</html>
