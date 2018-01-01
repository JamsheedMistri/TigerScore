<?php
require_once("utils.php");
if (isset($_POST['first_name'])) {
	$current = getData("data/tests.json");
	$first_name = $_POST['first_name'];
	$middle_initial = $_POST['middle_initial'];
	$last_name = $_POST['last_name'];
	$age = $_POST['age'];
	$gender = $_POST['gender'];
	$belt_size = $_POST['belt_size'];
	$present_belt = $_POST['present_belt'];
	$testing_for = $_POST['testing_for'];
	$home_phone = $_POST['home_phone'];
	$cell_phone = $_POST['cell_phone'];
	$email = $_POST['email'];

	$id = strtolower($first_name."_".$middle_initial."_".$last_name);
	$payment_validation_string = uniqid();

	$current[$id] = [
		"first_name" => $first_name,
		"middle_initial" => $middle_initial,
		"last_name" => $last_name,
		"age" => $age,
		"gender" => $gender,
		"belt_size" => $belt_size,
		"present_belt" => $present_belt,
		"testing_for" => $testing_for,
		"home_phone" => $home_phone,
		"cell_phone" => $cell_phone,
		"email" => $email,
		"requirements" => getData("config/belts.json")[$present_belt]['requirements'],
		"passed" => false,
		"latest_tester" => "nobody",
		"payment_validated" => false,
		"payment_validation_string" => $payment_validation_string
	];

	setData("data/tests.json", $current);

	// Receipt email
	$receipt = "<!DOCTYPE html><html><body>".getData("config/tigerscore.json")['receipt']."</body></html>";
	$receipt = str_replace("%%school_name%%", getData("config/tigerscore.json")['school_name'], $receipt);
	$receipt = str_replace("%%first_name%%", $first_name, $receipt);
	$receipt = str_replace("%%middle_initial%%", $middle_initial, $receipt);
	$receipt = str_replace("%%last_name%%", $last_name, $receipt);
	$receipt = str_replace("%%new_belt%%", getData("config/belts.json")[$testing_for]['name'], $receipt);
	$receipt = str_replace("%%old_belt%%", getData("config/belts.json")[$present_belt]['name'], $receipt);
	$receipt = str_replace("%%new_belt_price%%", "$".getData("config/belts.json")[$present_belt]['price'], $receipt);
	$receipt = wordwrap($receipt, 70, "\r\n");

    $receipt_headers = 'From: "'.getData("config/tigerscore.json")['school_name'].'" <'.getData("config/tigerscore.json")['outgoing_email'].'>' . "\r\n" . 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
    mail($email, "Your Belt Exam Confirmation", $receipt, $receipt_headers);

    // Confirmation email
	$confirmation = "<!DOCTYPE html>
	<html>
		<body>
			<h1>New Testing Form Submission</h1>
			<p>
				<b>Name</b>: $first_name $middle_initial $last_name<br>
				<b>Age</b>: $age<br>
				<b>Gender</b>: $gender<br>
				<b>Belt Size</b>: $belt_size<br>
				<b>Present Belt</b>: ".getData("config/belts.json")[$present_belt]['name']."<br>
				<b>Testing For</b>: ".getData("config/belts.json")[$testing_for]['name']."<br>
				<b>Home Phone</b>: $home_phone<br>
				<b>Cell Phone</b>: $cell_phone<br>
				<b>Email</b>: $email<br>
				<b>Date</b>: ".date('l jS \of F Y h:i:s A')."<br>
				<b>Payment Validation</b>: <a href='".getData("config/tigerscore.json")['website_root']."/validate_payment.php?id=$id&payment_validation_string=$payment_validation_string'>click here</a><br>
			</p>
		</body>
	</html>";
	$confirmation = wordwrap($confirmation, 70, "\r\n");

    $confirmation_headers = 'From: "TigerScore" <'.getData("config/tigerscore.json")['outgoing_email'].'>' . "\r\n" . 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
    mail(getData("config/tigerscore.json")['incoming_email'], "New Testing Form", $confirmation, $confirmation_headers);

	echo "success";

	addToLog("$first_name $last_name has submitted a testing form for their $testing_for test.");
}
?>