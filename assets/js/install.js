$("form").keyup(function() {
	if ($("#school_name").val() !== "" && $("#incoming_email").val() !== "" && $("#outgoing_email").val() !== "" && $("#instructor_password").val() !== "" && $("#master_password").val() !== "") {
		if ($("#step-2-submit").hasClass("disabled")) {
			$("#step-2-submit").removeClass("disabled");
		}
	} else {
		if (!$("#step-2-submit").hasClass("disabled")) {
			$("#step-2-submit").addClass("disabled");
		}
	}
});

$("#step-2-submit").click(function() {
	if ($("#step-2-submit").hasClass("disabled")) {
		return false;
	}
});