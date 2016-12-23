<?php
  // Making an alert function for PHP for easy JavaScript access
  function alert($message, $link) {
    echo '<script language="javascript">';
    echo 'var answer = confirm ("' . $message . '"); if (answer) { window.location.replace("' . $link . '"); } else { window.location.replace("' . $link . '"); }';
    echo '</script>';
  }

  // Belts list translating its short name to its display name.
  $belt_names = array(
    "white" => "White Belt",
    "black" => "Black Belt"
  );

  $prices = array(
    "white" => '$10',
    "black" => '$100'
  );

  // Test requirements list translating its short name to its display name.
  $test_requirements = array(
    "forms_example" => "Example Form",
    "breaking_example" => "Example Break",
    "sparring_example" => "Example Sparring Skill"
  );

  // Requirements for each belt.
  $belt_requirements = array(
    "white" => array(
      "forms_example"
    ),
    "black" => array(
      "forms_example",
      "breaking_example",
      "sparring_example"
    )
  );
 ?>
