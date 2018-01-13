<?php
require_once("utils.php");
if (!isset($_SESSION['instructor']) && !isset($_SESSION['master'])) {
	header("Location: .");
} else {
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<?php require_once("templates/headers.php"); ?>
		<title>TigerScore &bull; Panel</title>
		<link href="assets/css/main.css" rel="stylesheet">
		<link href="assets/css/panel.css" rel="stylesheet">
	</head>
	<body>
		<?php include 'templates/nav.php'; ?>
		<div id="modal-bg">
			<div id="modal">
				<div id="modal-header"><span></span> has fullfilled all of their requirements</div>
				<div id="modal-content">Would you like to pass them? If you do not hit "Pass", they will not be marked as passed until you do so.</div>
				<div class="clickable pass_student">Pass Now</div>
				<div class="clickable not_yet">Not Yet</div>
			</div>
		</div>
		<section id="panel">
			<div id="sidebar">
				<?php
				if (isset($_GET['student_test'])) {
					?>
					<ul>
						<a href="?student_search" id="back_to_list"><li><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back to List</li></a>
						<a href="?student_test&student=<?php echo $_GET['student']; ?>"><li>Student Info</li></a>
					</ul>

					<h4>Exam</h4>
					<ul>
						<?php
						$student_id = $_GET['student'];
						$types = getData("data/tests.json")[$student_id]['requirements'];

						foreach ($types as $type => $requirements) {
							if (sizeof($requirements) == 0) continue;
							echo '<a href="?student_test&student='.$student_id.'&type='.$type.'"><li data-type="'.$type.'">'.ucfirst($type);
							$completely_passed = true;
							foreach ($requirements as $requirement => $passed) {
								if (!$passed) {
									$completely_passed = false;
									break;
								}
							}
							if ($completely_passed) {
								echo ' <span class="green"><i class="fa fa-check-square"></i> (Completed)</span>';
							}
							echo '</li></a>';
						}
						?>
					</ul>
					<?php
				} else {
					?>
					<h4>Students</h4>
					<ul>
						<a href="?student_search"><li>Search for students</li></a>
						<a href="?student_list"><li>List all students</li></a>
					</ul>
					<?php
				}
				?>
				<br><br><br><br><br><br><br><br>
				<h4>Last 10 Students</h4>
				<ul>
					<?php
					$last10 = getData("data/last10.json");

					for ($i = 0; $i < sizeof($last10); $i ++) {
						if ($i >= 10) break;
						echo '<a href="?student_test&student='.$last10[$i].'"><li>';
						echo drawStudent($last10[$i]);
						echo '</li></a>';
					}
					?>
				</ul>
			</div>
			<div id="content-container">
				<div id="content">
					<?php
					if (isset($_GET['student_search'])) {
						if (isset($_POST['query'])) {
							$query = $_POST['query'];
							?>
							<h3>Results for "<?php echo $query; ?>"</h3>
							<ul class="student_list">
								<?php
								$tests = getData("data/tests.json");
								foreach ($tests as $key => $test) {
									$full_name = strtolower($test['first_name']." ".$test['last_name']);
									if (strpos($full_name, strtolower($query)) !== false) {
										echo "<a href='?student_test&student=$key'><li>".drawStudent($key)."</li></a>";
									}
								}
								?>
							</ul>
							<?php
						} else {
							?>
							<h3>Search for a student</h3>
							<form action="panel.php?student_search" method="post">
								<input type="hidden" name="student_search" />
								<input type="text" id="student_search" name="query" placeholder="Type name here" autofocus />
								<input type="submit" id="student_search_submit" value="Submit" />
							</form>
							<?php
						}
					} else if (isset($_GET['student_list'])) {
						echo '<h3>List of all students</h3>';
						echo '<ul class="student_list">';
						foreach (getData("data/tests.json") as $student => $value) {
							echo '<a href="?student_test&student='.$student.'"><li>';
							echo drawStudent($student);
							echo '</li></a>';
						}
						echo '</ul>';
					} else if (isset($_GET['student_test'])) {
						$student_id = $_GET['student'];
						updateLast10($student_id);
						$student_data = getData("data/tests.json")[$student_id];
						$student_full_name = $student_data['first_name']." ".$student_data['last_name'];
						$student_first_name = $student_data['first_name'];
						if ($student_data['passed']) {
							?>
							<h2 class="orange">Test for <?php echo $student_full_name; ?></h2>
							<br>
							<h3 class="orange">Info</h3>
							<div class="info">
								<h5><b>Exam Completed (Passed)</b>:
									<?php 
									if ($student_data['passed']) {
										echo "<span class='green'>Yes</span>";
									} else {
										echo "<span class='red'>No</span>";
									}
									?>
								</h5>
								<h5><b>Belt Size</b>: <?php echo $student_data['belt_size']; ?></h5>
								<h5><b>Present Belt</b>: 
									<?php
									echo getData("config/belts.json")[$student_data['present_belt']]['name']." "; 
									echo drawBelt($student_data['present_belt']);
									?>
								</h5>
								<h5><b>Testing For</b>: 
									<?php
									echo getData("config/belts.json")[$student_data['testing_for']]['name']." "; 
									echo drawBelt($student_data['testing_for']);
									?>
								</h5>
								<h5><b>Age</b>:
									<?php
									$age = $student_data['age'];
									echo $age." ";
									if ($age < 8) {
										echo "(breaking: thin board)";
									} else if ($age < 13) {
										echo "(breaking: medium board)";
									} else {
										echo "(breaking: thick board)";
									}
									?>
								</h5>
								<h5><b>Gender</b>: <?php echo $student_data['gender']; ?></h5>
								<h5><b>Home Phone</b>: <?php echo $student_data['home_phone']; ?></h5>
								<h5><b>Cell Phone</b>: <?php echo $student_data['cell_phone']; ?></h5>
								<h5><b>Email</b>: <?php echo $student_data['email']; ?></h5>
								<h5><b>Latest Tester</b>: <?php echo $student_data['latest_tester']; ?></h5>
								<h5><b>Payment Validated</b>:
									<?php 
									if ($student_data['payment_validated']) {
										echo "<span class='green'>Yes</span>";
									} else {
										echo "<span class='red'>No</span>";
									}
									?>
								</h5>
							</div>
							<?php
						} else {
							?>
							<h2 class="orange">Testing <?php echo $student_full_name; ?></h2>
							<?php
							if (isset($_GET['type'])) {
								$type = $_GET['type'];
								$requirements = $student_data['requirements'][$type];

								echo '<div class="type_testing">';

								$first_done = false;
								foreach ($requirements as $requirement => $passed) {
									if (!$first_done) {
										$first_done = true;
										echo '<h4 id="first">';
									} else {
										echo '<h4>';
									}
									?>
									<span><?php echo getData("config/curriculum/$type.json")[$requirement]; ?></span>
									<div class="clickable pass_button <?php if ($passed) echo "passed"; ?>" data-student="<?php echo $student_id; ?>" data-type="<?php echo $type; ?>" data-requirement="<?php echo $requirement; ?>"><?php if ($passed) echo "Undo"; else echo "Pass"; ?></div>
									<div class="clickable check" <?php if ($passed) echo 'style="display: block"'; ?>><i class="fa fa-check"></i></div>
									<div style="clear: both"></div>
								</h4>
								<?php
							}
							echo '</div>';
						} else {
							?>
							<h5>Please select a skill to test on the left hand side to test <?php echo $student_first_name; ?>.</h5>

							<br>
							<h3 class="orange">Info</h3>
							<div class="info">
								<h5><b>Exam Completed (Passed)</b>:
									<?php 
									if ($student_data['passed']) {
										echo "<span class='green'>Yes</span>";
									} else {
										echo "<span class='red'>No</span>";
									}
									?>
								</h5>
								<h5><b>Belt Size</b>: <?php echo $student_data['belt_size']; ?></h5>
								<h5><b>Present Belt</b>: 
									<?php
									echo getData("config/belts.json")[$student_data['present_belt']]['name']." "; 
									echo drawBelt($student_data['present_belt']);
									?>
								</h5>
								<h5><b>Testing For</b>: 
									<?php
									echo getData("config/belts.json")[$student_data['testing_for']]['name']." "; 
									echo drawBelt($student_data['testing_for']);
									?>
								</h5>
								<h5><b>Age</b>:
									<?php
									$age = $student_data['age'];
									echo $age." ";
									if ($age < 8) {
										echo "(breaking: thin board)";
									} else if ($age < 13) {
										echo "(breaking: medium board)";
									} else {
										echo "(breaking: thick board)";
									}
									?>
								</h5>
								<h5><b>Gender</b>: <?php echo $student_data['gender']; ?></h5>
								<h5><b>Home Phone</b>: <?php echo $student_data['home_phone']; ?></h5>
								<h5><b>Cell Phone</b>: <?php echo $student_data['cell_phone']; ?></h5>
								<h5><b>Email</b>: <?php echo $student_data['email']; ?></h5>
								<h5><b>Latest Tester</b>: <?php echo $student_data['latest_tester']; ?></h5>
								<h5><b>Payment Validated</b>:
									<?php 
									if ($student_data['payment_validated']) {
										echo "<span class='green'>Yes</span>";
									} else {
										echo "<span class='red'>No</span>";
									}
									?>
								</h5>
							</div>
							<?php
						}
					}
				} else {
					?>
					<script> window.location.replace("?student_search"); </script>
					<?php
				}
				?>
			</div>
		</div>
	</section>
	<?php require_once("templates/scripts.php"); ?>
	<script> var shouldCheckIfPassed = false; </script>
	<?php
	if (isset($_GET['student']) && !getData("data/tests.json")[$_GET['student']]['passed']) {
		echo "<script>
		var id = '".$_GET['student']."';
		var first_name = '".getData("data/tests.json")[$_GET['student']]['first_name']."';
		shouldCheckIfPassed = true;
		</script>";
	}
	?>
	<script src="assets/js/panel.js"></script>
</body>
</html>
<?php
}
?>