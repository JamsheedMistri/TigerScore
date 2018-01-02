$(".pass_button").click(function() {
	var button = $(this);
	var student = button.data("student");
	var type = button.data("type");
	var requirement = button.data("requirement");

	$.post("panel_bridge.php", {"toggle_requirement": null, "student": student, "type": type, "requirement": requirement}, function(response) {
		if (button.hasClass("passed")) {
			button.removeClass("passed");
			button.parent().find(".check").css("display", "none");
			button.html("Pass");
		}
		else {
			button.addClass("passed");
			button.parent().find(".check").css("display", "block");
			button.html("Undo");
		}
	});

	// Update the latest tester
	$.post("panel_bridge.php", {"update_tester": id}, function(response) {});
	// Update last5
	$.post("panel_bridge.php", {"update_last5": id}, function(response) {});
	
	// Check if everything passed for that type
	$.post("panel_bridge.php", {"check_if_all_passed_for_type": null, "student": student, "type": type}, function(response) {
		if (response == "yes") {
 			$("#sidebar").find('[data-type="' + type + '"]').append(' <span class="green"><i class="fa fa-check-square"></i> (Completed)</span>');
		} else {
			$("#sidebar").find('[data-type="' + type + '"]').html(ucfirst(type));
		}
	});
	// Check if they have passed EVERYTHING
	checkIfAllPassed();
});

$(".not_yet").click(function() {
	$("#modal-bg").css("display", "none");
});

$(".pass_student").click(function() {
	$.post("panel_bridge.php", {"pass_student": id}, function() {
		window.location.reload();
	});
});

$("#student_search").keyup(function() {
	var value = $("#student_search").val();
	var possibles = [];
	for (var key in studentList) {
		var name = studentList[key]['first_name'] + " " + studentList[key]['last_name'];
		if (name.toLowerCase().includes(value.toLowerCase()) && value !== "") possibles.push(key);
	}
	var current = "";
	for (var i = 0; i < possibles.length; i ++) {
		current += "<a href='?student_test&student=" + possibles[i] + "'><li>" + studentList[possibles[i]]['draw'] + "</li></a>";
	}
	if (current == "") current = "No results";
	$("#student_search_list").html(current);
});


$(document).ready(function() {
	if (shouldCheckIfPassed) checkIfAllPassed();
});

function checkIfAllPassed() {
	$.post("panel_bridge.php", {"check_if_all_passed": null, "student": id}, function(response) {
		if (response == "yes") {
			$("#modal-bg").css("display", "block");
			$("#modal-header").find("span").html(first_name);
		}
	});
}

function ucfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}