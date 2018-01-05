<?php
session_start();

function getData($path) {
	return json_decode(file_get_contents($path), true);
}

function setData($path, $opts) {
	file_put_contents($path, json_encode($opts));
}

function resetTigerScore() {
	file_put_contents("config/curriculum/breaking.json", "{}");
	file_put_contents("config/curriculum/forms.json", "{}");
	file_put_contents("config/curriculum/other.json", "{}");
	file_put_contents("config/curriculum/sparring.json", "{}");
	file_put_contents("config/belts.json", "{}");
	file_put_contents("config/tigerscore.json", '{"configured": false}');
	file_put_contents("data/tests.json", "{}");
	file_put_contents("data/last10.json", "[]");
	file_put_contents("data/log.json", "[]");

	$_SESSION = [];
	session_destroy();
	alert("Successfully reset TigerScore!", ".");
}

function configureTigerScore($opts) {
	$array = [
		"configured" => true,
		"website_root" => $opts["website_root"],
		"school_name" => $opts["school_name"],
		"incoming_email" => $opts["incoming_email"],
		"outgoing_email" => $opts["outgoing_email"],
		"instructor_password" => password_hash($opts["instructor_password"], PASSWORD_DEFAULT),
		"master_password" => password_hash($opts["master_password"], PASSWORD_DEFAULT),
		"receipt" => "<h1>%%school_name%% Exam Registration Confirmation</h1><p>Greetings!</p>We have received your exam registration for %%first_name%% to test for %%new_belt%%. Please bring your exam payment of %%new_belt_price%% to %%school_name%%. The exam fee covers the test for forms/sparring including the materials for board breaking and a new belt rank.</p><p>Thank You,<br>%%school_name%%</p>",
		"payment_validation_email" => "<h1>%%school_name%% Payment Confirmation</h1><p>Greetings!</p><p>Thank you for your payment of %%new_belt_price%% for %%first_name%%'s %%new_belt%% exam. Have a great day!</p><p>%%school_name%%</p>"
	];

	setData("config/tigerscore.json", $array);

	addToLog("TigerScore was configured.");
}

function addCurriculum($type, $id, $name) {
	if ($type !== "breaking" && $type !== "forms" && $type !== "other" && $type !== "sparring") {
		return;
	}

	$opts = getData("config/curriculum/".$type.".json");
	if (array_key_exists($id, $opts)) {
		alert($id." is already an ID! Please try again with a different ID.", "admin.php?edit=".$type);
		return;
	}
	$opts[$id] = $name;

	setData("config/curriculum/".$type.".json", $opts);
}

function removeCurriculum($type, $id) {
	if ($type !== "breaking" && $type !== "forms" && $type !== "other" && $type !== "sparring") {
		return;
	}

	$opts = getData("config/curriculum/".$type.".json");
	unset($opts[$id]);

	setData("config/curriculum/".$type.".json", $opts);

	// Delete the requirement from each of the belts that contain it
	$belts = getData("config/belts.json");

	foreach ($belts as $belt_key => $belt_value) {
		foreach ($belt_value['requirements'][$type] as $req_key => $req_value) {
			if ($req_key == $id) {
				unset($belts[$belt_key]['requirements'][$type][$id]);
			}
		}
	}

	setData("config/belts.json", $belts);

	// Delete the requirement from each of the tests that contain it
	$tests = getData("data/tests.json");
	foreach ($tests as $test_key => $test_value) {
		foreach ($test_value['requirements'][$type] as $req_key => $req_value) {
			if ($req_key == $id) {
				unset($tests[$test_key]['requirements'][$type][$id]);
			}
		}
	}

	setData("data/tests.json", $tests);
}

function alert($message, $link) {
	echo '<script language="javascript">';
	echo 'var answer = confirm ("'.$message.'"); if (answer) { window.location.replace("'.$link.'"); } else { window.location.replace("'.$link.'"); }';
	echo '</script>';
}

function isConfigured() {
	return getData("config/tigerscore.json")["configured"];
}

function drawBelt($id) {
	if (strpos($id, '_') !== false) {
		$color = substr($id, 0, strpos($id, "_"));
		$stripe = substr($id, strpos($id, "_") + 1);

		if ($color == "yellow") {
			$color = "#ffe100";
		}

		if ($color == "brown") {
			$color = "#894909";
		}

		if ($stripe == "yellow") {
			$stripe = "#ffe100";
		}

	    return '<div class="belt" style="background: '.$color.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div style="background: '.$stripe.';"></div></div>';
	} else {
		if ($id == "yellow") {
			$id = "#ffe100";
		}

		if ($id == "brown") {
			$id = "#894909";
		}

		return '<div class="belt" style="background: '.$id.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>';
	}
}

function drawStudent($id) {
	$student_data = getData("data/tests.json")[$id];
	return drawBelt($student_data['present_belt'])."&nbsp;&nbsp;".$student_data['first_name']." ".$student_data['last_name'];
}

function addToLog($message) {
	$current = getData("data/log.json");
	$current[] = $message;
	setData("data/log.json", $current);
}

function updateLast10($id) {
	$current = getData("data/last10.json");
	$new = [$id];
	$count = 1;
	foreach ($current as $i) {
		if ($count >= 10) break;
		if ($i == $id) continue;
		$new[] = $i;
		$count ++;
	}
	setData("data/last10.json", $new);
}