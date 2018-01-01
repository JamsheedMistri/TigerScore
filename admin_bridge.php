<?php
require_once("utils.php");
if (!isset($_SESSION['master'])) {
	// Authenticate user
	header("Location: .");
} else {
	if (isset($_POST['new_requirement'])) {
		// Add curriculum requirement
		$type = $_POST['type'];
		if (strpos($_POST['id'], ' ') !== false) {
			alert("The ID must not contain any spaces!", "admin.php?curriculum&edit=".$type);
			die();
		} else if ($_POST['id'] == "" || $_POST['name'] == "") {
			alert("Please fill out all fields!", "admin.php?curriculum&edit=".$type);
			die();
		}
		addCurriculum($type, $_POST['id'], $_POST['name']);
		alert("Success!", "admin.php?curriculum&edit=".$type);

		addToLog("[Admin] ".$_SESSION['master']." created a new requirement in the \"$type\" category called ".$_POST['id'].".");
	} else if (isset($_GET['delete_requirement'])) {
		// Delete curriculum requirement
		$type = $_GET['type'];
		removeCurriculum($_GET['type'], $_GET['delete']);
		alert("Success!", "admin.php?curriculum&edit=".$type);

		addToLog("[Admin] ".$_SESSION['master']." deleted the \"".$_GET['delete']."\" requirement.");
	} else if (isset($_POST['belt_add'])) {
		// Add belt
		if (strpos($_POST['id'], ' ') !== false) {
			alert("The ID must not contain any spaces!", "admin.php?belts");
			die();
		} else if ($_POST['id'] == "" || $_POST['name'] == "" || $_POST['price'] == "") {
			alert("Please fill out all fields!", "admin.php?belts");
			die();
		}
		
		$opts = getData("config/belts.json");
		if (array_key_exists($_POST['id'], $opts)) {
			alert($_POST['id']." is already a belt ID! Please try again with a different ID.", "admin.php?belts");
			return;
		}
		$opts[$_POST['id']] = [
			"name" => $_POST['name'],
			"price" => (int)$_POST['price'],
			"requirements" => [
				"forms" => [],
				"sparring" => [],
				"breaking" => [],
				"other" => []
			]
		];

		setData("config/belts.json", $opts);
		alert("Success!", "admin.php?belts");

		addToLog("[Admin] ".$_SESSION['master']." created a new belt called ".$_POST['name']." with the ID ".$_POST['id'].".");
	} else if (isset($_GET['belts_delete'])) {
		// Delete belt
		$opts = getData("config/belts.json");
		unset($opts[$_GET['delete']]);
		setData("config/belts.json", $opts);
		alert("Success!", "admin.php?belts");

		addToLog("[Admin] ".$_SESSION['master']." delted the ".$_GET['delete']." belt.");
	} else if (isset($_POST['belt_add_requirement'])) {
		// Add requirement to a belt
		$belt = $_POST['belt_add_requirement'];
		$type = substr($_POST['requirement_name'], 0, strpos($_POST['requirement_name'], "_"));
		$requirement = substr($_POST['requirement_name'], strpos($_POST['requirement_name'], "_") + 1);

		$current = getData("config/belts.json");
		$current[$belt]['requirements'][$type][$requirement] = false;
		setData("config/belts.json", $current);

		// Add this requirement to each unpassed current tester
		$tests = getData("data/tests.json");
		foreach ($tests as $test_key => $test_value) {
			if ($test_value['passed']) continue;
			if ($test_value['present_belt'] == $belt) {
				$tests[$test_key]['requirements'][$type][$requirement] = false;
			}
		}
		setData("data/tests.json", $tests);

		alert("Success!", "admin.php?belts&belt=".$belt);

		addToLog("[Admin] ".$_SESSION['master']." added $requirement to $belt.");
	} else if (isset($_GET['belt_delete_requirement'])) {
		// Delete a requirement from a belt
		$belt = $_GET['belt_delete_requirement'];
		$type = $_GET['type'];
		$requirement = $_GET['delete'];

		$current = getData("config/belts.json");
		unset($current[$belt]['requirements'][$type][$requirement]);
		setData("config/belts.json", $current);

		// Delete this requirement from each unpassed current tester
		$tests = getData("data/tests.json");
		foreach ($tests as $test_key => $test_value) {
			if ($test_value['passed']) continue;
			if ($test_value['present_belt'] == $belt) {
				unset($tests[$test_key]['requirements'][$type][$requirement]);
			}
		}
		setData("data/tests.json", $tests);

		alert("Success!", "admin.php?belts&belt=".$belt);

		addToLog("[Admin] ".$_SESSION['master']." deleted $requirement from $belt");
	} else if (isset($_POST['belt_edit_price'])) {
		// Edit the price of a belt
		$belt = $_POST['belt_edit_price'];
		$price = $_POST['price'];

		$current = getData("config/belts.json");
		$current[$belt]['price'] = (int)$price;

		setData("config/belts.json", $current);
		alert("Success!", "admin.php?belts&belt=".$belt);

		addToLog("[Admin] ".$_SESSION['master']." changed the price of $belt belt to \$$price.");
	} else if (isset($_POST['password_change'])) {
		// Change the instructor OR master password
		$type = $_POST['password_change'];

		$current = getData("config/tigerscore.json");
		if (password_verify($_POST['current_password'], $current[$type."_password"])) {
			if ($_POST['new_password'] == $_POST['confirm_password']) {
				$current[$type."_password"] = password_hash($_POST["new_password"], PASSWORD_DEFAULT);
				setData("config/tigerscore.json", $current);
				alert("Success!", "admin.php?passwords");
			} else {
				alert("Your two new passwords do not match! Please try again.", "admin.php?passwords");
				die();
			}
		} else {
			alert("Your current password is incorrect. Please try again!", "admin.php?passwords");
			die();
		}

		addToLog("[Admin] ".$_SESSION['master']." changed the password.");
	} else if (isset($_POST['settings'])) {
		// Edit settings
		$school_name = $_POST['school_name'];
		$incoming_email = $_POST['incoming_email'];
		$outgoing_email = $_POST['outgoing_email'];

		if ($school_name == "" || $outgoing_email == "" || $incoming_email == "") {
			alert("Please fill out all fields!", "admin.php?settings");
			die();
		} else {
			$current = getData("config/tigerscore.json");
			$current['school_name'] = $school_name;
			$current['incoming_email'] = $incoming_email;
			$current['outgoing_email'] = $outgoing_email;
			setData("config/tigerscore.json", $current);

			alert("Success!", "admin.php?settings");
		}
		addToLog("[Admin] ".$_SESSION['master']." edited the settings for emails.");
	} else if (isset($_GET['reset_tigerscore'])) {
		// Reset the entire thing to factory condition
		resetTigerscore();
	} else if (isset($_POST['update_receipt'])) {
		// Change the receipt message that users are sent
		$current = getData("config/tigerscore.json");
		$current['receipt'] = $_POST['data'];
		setData("config/tigerscore.json", $current);

		echo "success";

		addToLog("[Admin] ".$_SESSION['master']." changed the receipt email.");
	} else if (isset($_POST['update_payment_validation_email'])) {
		// Change the payment validation email receipt that is sent to the users when the master validates their payment
		$current = getData("config/tigerscore.json");
		$current['payment_validation_email'] = $_POST['data'];
		setData("config/tigerscore.json", $current);

		echo "success";

		addToLog("[Admin] ".$_SESSION['master']." changed the payment validation email.");
	} else {
		// Handle bad requests to this document
		header("Location: admin.php");
	}
}
?>