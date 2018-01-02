<?php
require_once("utils.php");
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	if ($_GET['payment_validation_string'] == getData("data/tests.json")[$id]["payment_validation_string"]) {
		$current = getData("data/tests.json");
		$current[$id]['payment_validated'] = true;
		setData("data/tests.json", $current);

		alert("Successfully validated payment for ".getData("data/tests.json")[$id]['first_name']." ".getData("data/tests.json")[$id]['last_name']."!", ".");

		$user = getData("data/tests.json")[$id];

		// Payment validation email
		$payment_validation = "<!DOCTYPE html><html><body>".getData("config/tigerscore.json")['payment_validation_email']."</body></html>";
		$payment_validation = str_replace("%%school_name%%", getData("config/tigerscore.json")['school_name'], $payment_validation);
		$payment_validation = str_replace("%%first_name%%", $user['first_name'], $payment_validation);
		$payment_validation = str_replace("%%middle_initial%%", $user['middle_initial'], $payment_validation);
		$payment_validation = str_replace("%%last_name%%", $user['last_name'], $payment_validation);
		$payment_validation = str_replace("%%new_belt%%", getData("config/belts.json")[$user['testing_for']]['name'], $payment_validation);
		$payment_validation = str_replace("%%old_belt%%", getData("config/belts.json")[$user['present_belt']]['name'], $payment_validation);
		$payment_validation = str_replace("%%new_belt_price%%", "$".getData("config/belts.json")[$user['present_belt']]['price'], $payment_validation);
		$payment_validation = wordwrap($payment_validation, 70, "\r\n");

		$payment_validation_headers = 'From: "'.getData("config/tigerscore.json")['school_name'].'" <'.getData("config/tigerscore.json")['outgoing_email'].'>' . "\r\n" . 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
		mail($user['email'], "Exam Payment Confirmation", $payment_validation, $payment_validation_headers);

		addToLog("The payment for ".$user['first_name']." ".$user['last_name']." was validated.");
	} else {
		alert("Incorrect validation string.", ".");
	}
} else {
	header("Location: .");
}
?>