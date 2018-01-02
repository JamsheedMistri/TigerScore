<?php
require_once("utils.php");
if (!isset($_SESSION['instructor']) && !isset($_SESSION['master'])) {
	header("Location: .");
} else {
	$logged_in_instructor = isset($_SESSION['instructor']) ? $_SESSION['instructor'] : $_SESSION['master'];
	if (isset($_POST['toggle_requirement'])) {
		$student = $_POST['student'];
		$type = $_POST['type'];
		$requirement = $_POST['requirement'];

		$tests = getData("data/tests.json");

		if ($tests[$student]['requirements'][$type][$requirement]) {
			$tests[$student]['requirements'][$type][$requirement] = false;
		} else {
			$tests[$student]['requirements'][$type][$requirement] = true;
		}

		setData("data/tests.json", $tests);

		addToLog($logged_in_instructor." toggled ".getData("data/tests.json")[$student]['first_name']." ".getData("data/tests.json")[$student]['last_name']."'s requirement for ".getData("config/curriculum/$type.json")[$requirement].".");
	} else if (isset($_POST['check_if_all_passed_for_type'])) {
		$student = $_POST['student'];
		$type = $_POST['type'];

		$all_passed = true;
		foreach (getData("data/tests.json")[$student]['requirements'][$type] as $requirement => $passed) {
			if (!$passed) {
				$all_passed = false;
				break;
			}
		}
		if ($all_passed) echo "yes";
		else echo "no";
	} else if (isset($_POST['check_if_all_passed'])) {
		$student = $_POST['student'];
		$requirements = getData("data/tests.json")[$student]['requirements'];

		$all_passed = true;
		foreach ($requirements as $type => $value) {
			foreach ($value as $key => $passed) {
				if (!$passed) {
					$all_passed = false;
					break;
				}
			}
		}
		if ($all_passed) echo "yes";
		else echo "no";
	} else if (isset($_POST['pass_student'])) {
		$current = getData("data/tests.json");
		$current[$_POST['pass_student']]['passed'] = true;
		setData("data/tests.json", $current);

		addToLog($logged_in_instructor." passed ".getData("data/tests.json")[$_POST['pass_student']]['first_name']." ".getData("data/tests.json")[$_POST['pass_student']]['last_name'].".");
	} else if (isset($_POST['update_tester'])) {
		$current = getData("data/tests.json");
		$current[$_POST['update_tester']]['latest_tester'] = isset($_SESSION['master']) ? $_SESSION['master'] : $_SESSION['instructor'];
		setData("data/tests.json", $current);
	} else if (isset($_POST['update_last5'])) {
		$current = getData("data/last5.json");
		$new = [$_POST['update_last5']];
		$count = 1;
		foreach ($current as $i) {
			if ($count >= 5) break;
			if ($i == $_POST['update_last5']) continue;
			$new[] = $i;
			$count ++;
		}
		setData("data/last5.json", $new);
	} else {
		header("Location: .");
	}
}