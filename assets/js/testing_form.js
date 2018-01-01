$('input[type="submit"]').click(function() {
	var first_name = $('[name="first_name"]').val();
	var middle_initial = $('[name="middle_initial"]').val();
	var last_name = $('[name="last_name"]').val();
	var age = $('[name="age"]').val();
	var gender = $('[name="gender"]').val();
	var belt_size = $('[name="belt_size"]').val();
	var present_belt = $('[name="present_belt"]').val();
	var testing_for = $('[name="testing_for"]').val();
	var home_phone = $('[name="home_phone"]').val();
	var cell_phone = $('[name="cell_phone"]').val();
	var email = $('[name="email"]').val();
	var consent = document.getElementById("consent").checked;

	if (first_name == "") {
		alert("Please fill in a first name!");
		return;
	}
	if (middle_initial == "") {
		alert("Please fill in a middle initial!");
		return;
	}
	if (last_name == "") {
		alert("Please fill in a last name!");
		return;
	}
	if (age == "") {
		alert("Please fill in an age!");
		return;
	}
	if (gender == null) {
		alert("Please fill in a gender!");
		return;
	}
	if (present_belt == null) {
		alert("Please fill in a present belt!");
		return;
	}
	if (testing_for == null) {
		alert("Please fill in a belt you are testing for!");
		return;
	}
	if (belt_size == null) {
		alert("Please fill in a belt size!");
		return;
	}
	if (home_phone == "") {
		alert("Please fill in a home phone!");
		return;
	}
	if (cell_phone == "") {
		alert("Please fill in a cell phone!");
		return;
	}
	if (email == "") {
		alert("Please fill in an email!");
		return;
	}
	if (!consent) {
		alert("Please check the consent checkbox!");
		return;
	}

	$.post("testing_bridge.php", {"first_name": first_name, "middle_initial": middle_initial, "last_name": last_name, "age": age, "gender": gender, "belt_size": belt_size, "present_belt": present_belt, "testing_for": testing_for, "home_phone": home_phone, "cell_phone": cell_phone, "email": email}, function(response) {
		if (response == "success") alert("Your form was submitted successfully! Your receipt has been emailed to you.");
		else alert("Something went wrong and your form was not submitted. Please try again later. If this problem persists, please contact us.");
		$("#actual_testing_form").css("display", "none");
	});
});