<?php
require_once("utils.php");
if (!isset($_SESSION['master'])) {
	if (isset($_SESSION['instructor'])) header("Location: panel.php");
		else header("Location: .?admin");
		} else {
			?>
			<!DOCTYPE html>
			<html>
			<head>
				<?php require_once("templates/headers.php"); ?>
				<title>TigerScore &bull; Admin</title>
				<link href="assets/css/main.css" rel="stylesheet">
				<link href="assets/quill/quill.tigerscore.css" rel="stylesheet">
				<link href="assets/css/admin.css" rel="stylesheet">
			</head>
			<body>
				<?php include 'templates/nav.php'; ?>
				<section id="admin">
					<div id="sidebar">
						<h4>Curriculum Settings</h4>
						<ul>
							<a href="?curriculum&edit=forms"><li id="first">Forms</li></a>
							<a href="?curriculum&edit=sparring"><li>Sparring</li></a>
							<a href="?curriculum&edit=breaking"><li>Breaking</li></a>
							<a href="?curriculum&edit=other"><li>Other</li></a>
						</ul>
						<h4>Requirements</h4>
						<ul>
							<a href="?belts"><li id="first">Edit Belts &amp; Test Requirements</li></a>
						</ul>
						<h4>Administration</h4>
						<ul>
							<a href="?passwords"><li id="first">Edit Passwords</li></a>
							<a href="?settings"><li>Edit Settings</li></a>
							<a href="?information"><li>Information</li></a>
						</ul>
					</div>
					<div id="content-container">
						<div id="content">
							<?php
							if (isset($_GET['curriculum'])) {
								if (!isset($_GET['edit'])) {
									?>
									<h4>Please select an option to the right.<br><br>If you would like to test students, click <a href="panel.php">here</a>.</h4>
									<?php
								} else if ($_GET['edit'] == 'forms') {
									?>
									<h3>Forms</h3>
									<h4>Add New Form</h4>
									<form action="admin_bridge.php" method="post">
										<input name="new_requirement" type="hidden" />
										<input name="type" type="hidden" value="forms" />
										<input name="id" type="text" placeholder="Form name, all lowercase and no spaces"/>
										<input name="name" type="text" placeholder="Normal form name"/>
										<input name="submit" type="submit" value="Submit"/>
									</form>

									<h4>Current Forms</h4>
									<table class="table">
										<thead>
											<tr>
												<th scope="col">Form ID</th>
												<th scope="col">Form Name</th>
												<th scope="col">Delete</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$forms = getData("config/curriculum/forms.json");
											if (sizeof($forms) == 0) {
												?>
												<tr>
													<td>There are currently no forms. Add a form by submitting one above.</td>
												</tr>
												<?php
											} else {
												foreach ($forms as $id => $name) {
													?>
													<tr>
														<td><?php echo $id; ?></td>
														<td><?php echo $name; ?></td>
														<td><a class="btn btn-danger" href="admin_bridge.php?delete_requirement&type=forms&delete=<?php echo $id; ?>">Delete</a></td>
													</tr>
													<?php
												}
											}
											?>
										</tbody>
									</table>
									<?php
								} else if ($_GET['edit'] == 'sparring') {
									?>
									<h3>Sparring</h3>
									<h4>Add New Sparring Technique</h4>
									<form action="admin_bridge.php" method="post">
										<input name="new_requirement" type="hidden" />
										<input name="type" type="hidden" value="sparring" />
										<input name="id" type="text" placeholder="Technique name, all lowercase and no spaces"/>
										<input name="name" type="text" placeholder="Normal technique name"/>
										<input name="submit" type="submit" value="Submit"/>
									</form>

									<h4>Current Sparring Techniques</h4>
									<table class="table">
										<thead>
											<tr>
												<th scope="col">Technique ID</th>
												<th scope="col">Technique Name</th>
												<th scope="col">Delete</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$sparring = getData("config/curriculum/sparring.json");
											if (sizeof($sparring) == 0) {
												?>
												<tr>
													<td>There are currently no sparring techniques. Add a technique by submitting one above.</td>
												</tr>
												<?php
											} else {
												foreach ($sparring as $id => $name) {
													?>
													<tr>
														<td><?php echo $id; ?></td>
														<td><?php echo $name; ?></td>
														<td><a class="btn btn-danger" href="admin_bridge.php?delete_requirement&type=sparring&delete=<?php echo $id; ?>">Delete</a></td>
													</tr>
													<?php
												}
											}
											?>
										</tbody>
									</table>
									<?php
								} else if ($_GET['edit'] == 'breaking') {
									?>
									<h3>Breaking</h3>
									<h4>Add New Breaking Technique</h4>
									<form action="admin_bridge.php" method="post">
										<input name="new_requirement" type="hidden" />
										<input name="type" type="hidden" value="breaking" />
										<input name="id" type="text" placeholder="Technique name, all lowercase and no spaces"/>
										<input name="name" type="text" placeholder="Normal technique name"/>
										<input name="submit" type="submit" value="Submit"/>
									</form>

									<h4>Current Breaking Techniques</h4>
									<table class="table">
										<thead>
											<tr>
												<th scope="col">Technique ID</th>
												<th scope="col">Technique Name</th>
												<th scope="col">Delete</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$breaking = getData("config/curriculum/breaking.json");
											if (sizeof($breaking) == 0) {
												?>
												<tr>
													<td>There are currently no breaking techniques. Add a technique by submitting one above.</td>
												</tr>
												<?php
											} else {
												foreach ($breaking as $id => $name) {
													?>
													<tr>
														<td><?php echo $id; ?></td>
														<td><?php echo $name; ?></td>
														<td><a class="btn btn-danger" href="admin_bridge.php?delete_requirement&type=breaking&delete=<?php echo $id; ?>">Delete</a></td>
													</tr>
													<?php
												}
											}
											?>
										</tbody>
									</table>
									<?php
								} else if ($_GET['edit'] == 'other') {
									?>
									<h3>Other</h3>
									<h4>Add New "Other" Requirement</h4>
									<form action="admin_bridge.php" method="post">
										<input name="new_requirement" type="hidden" />
										<input name="type" type="hidden" value="other" />
										<input name="id" type="text" placeholder="Requirement name, all lowercase and no spaces"/>
										<input name="name" type="text" placeholder="Normal requirement name"/>
										<input name="submit" type="submit" value="Submit"/>
									</form>

									<h4>Current "Other" Requirements</h4>
									<table class="table">
										<thead>
											<tr>
												<th scope="col">Requirement ID</th>
												<th scope="col">Requirement Name</th>
												<th scope="col">Delete</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$other = getData("config/curriculum/other.json");
											if (sizeof($other) == 0) {
												?>
												<tr>
													<td>There are currently no "other" requirements. Add a requirement by submitting one above.</td>
												</tr>
												<?php
											} else {
												foreach ($other as $id => $name) {
													?>
													<tr>
														<td><?php echo $id; ?></td>
														<td><?php echo $name; ?></td>
														<td><a class="btn btn-danger" href="admin_bridge.php?delete_requirement&type=other&delete=<?php echo $id; ?>">Delete</a></td>
													</tr>
													<?php
												}
											}
											?>
										</tbody>
									</table>
									<?php
								}
							} else if (isset($_GET['belts'])) {
								if (isset($_GET['belt'])) {
									$belt = $_GET['belt'];
									$data = getData("config/belts.json")[$belt];
									?>
									<a class="btn btn-primary" href="?belts"><i class="fa fa-chevron-left"></i> Back</a>
									<br><br>
									<h3>Edit <?php echo $data['name']; ?></h3>
									<h4>Price</h4>
									<form action="admin_bridge.php" method="post">
										<input name="belt_edit_price" value="<?php echo $belt; ?>" type="hidden" />
										<div class="input-group" id="belt_price">
											<div class="input-group-addon">$</div>
											<input name="price" type="number" placeholder="Price" value="<?php echo $data['price']; ?>" />
										</div>

										<input name="submit" type="submit" value="Save"/>
									</form>

									<br>
									<h4>Testing Requirements</h4>
									<h6>Add New Requirement</h6>
									<form action="admin_bridge.php" method="post">
										<input name="belt_add_requirement" value="<?php echo $belt; ?>" type="hidden" />
										<select name="requirement_name">
											<option disabled selected>Select a requirement</option>
											<?php
											$forms = getData("config/curriculum/forms.json");
											if (sizeof($forms) !== 0) echo "<option disabled>Forms</option>";
											foreach ($forms as $id => $name) {
												if (array_key_exists($id, getData("config/belts.json")[$belt]['requirements']['forms'])) continue;
												echo "<option value='forms_$id'>$name ($id)</option>";
											}

											$sparring = getData("config/curriculum/sparring.json");
											if (sizeof($sparring) !== 0) echo "<option disabled>Sparring</option>";
											foreach ($sparring as $id => $name) {
												if (array_key_exists($id, getData("config/belts.json")[$belt]['requirements']['sparring'])) continue;
												echo "<option value='sparring_$id'>$name ($id)</option>";
											}

											$breaking = getData("config/curriculum/breaking.json");
											if (sizeof($breaking) !== 0) echo "<option disabled>Breaking</option>";
											foreach ($breaking as $id => $name) {
												if (array_key_exists($id, getData("config/belts.json")[$belt]['requirements']['breaking'])) continue;
												echo "<option value='breaking_$id'>$name ($id)</option>";
											}

											$other = getData("config/curriculum/other.json");
											if (sizeof($other) !== 0) echo "<option disabled>Other</option>";
											foreach ($other as $id => $name) {
												if (array_key_exists($id, getData("config/belts.json")[$belt]['requirements']['other'])) continue;
												echo "<option value='other_$id'>$name ($id)</option>";
											}
											?>
										</select>

										<input name="submit" type="submit" value="Submit"/>
									</form>

									<br>
									<h6>Current Requirements</h6>
									<table class="table">
										<thead>
											<tr>
												<th scope="col">Type</th>
												<th scope="col">ID</th>
												<th scope="col">Name</th>
												<th scope="col">Delete</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$current_requirements = getData("config/belts.json")[$belt]['requirements'];
											$empty = true;
											foreach ($current_requirements as $key => $value) {
												if (sizeof($value) !== 0) $empty = false;
											}
											if ($empty) {
												?>
												<tr>
													<td>There are currently no requirements. Add a belt by submitting one above.</td>
												</tr>
												<?php
											} else {
												foreach ($current_requirements as $key => $value) {
													foreach ($value as $req => $false) {
														?>
														<tr>
															<td><?php echo $key; ?></td>
															<td><?php echo $req; ?></td>
															<td><?php echo getData("config/curriculum/".$key.".json")[$req]; ?></td>
															<td><a class="btn btn-danger" href="admin_bridge.php?belt_delete_requirement=<?php echo $belt; ?>&type=<?php echo $key; ?>&delete=<?php echo $req; ?>">Delete</a></td>
														</tr>
														<?php
													}
												}
											}
											?>
										</tbody>
									</table>

									<?php
								} else {
									?>
									<h3>Belts</h3>
									<h4>Add New Belt</h4>
									<form action="admin_bridge.php" method="post">
										<input name="belt_add" type="hidden" />
										<h5>Belt ID</h5>
										<h6>For a solid color, put its name only (example: "orange"). For a striped belt, put the background first, then an underscore, then the stripe color (example: "orange_black");</h6>
										<input name="id" type="text" placeholder="Belt name, all lowercase and no spaces"/>
										<h5>Belt Name</h5>
										<input name="name" type="text" placeholder="Normal belt name"/>
										<h5>Testing Price</h5>
										<div class="input-group" id="belt_price">
											<div class="input-group-addon">$</div>
											<input name="price" type="number" placeholder="Price"/>
										</div>
										<input name="submit" type="submit" value="Submit"/>
									</form>

									<br>
									<h4>Current Belts</h4>
									<table class="table">
										<thead>
											<tr>
												<th scope="col">Belt ID</th>
												<th scope="col">Belt Name</th>
												<th scope="col">Edit</th>
												<th scope="col">Delete</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$belts = getData("config/belts.json");
											if (sizeof($belts) == 0) {
												?>
												<tr>
													<td>There are currently no belts. Add a belt by submitting one above.</td>
												</tr>
												<?php
											} else {
												foreach ($belts as $id => $value) {
													?>
													<tr>
														<td><?php echo $id; ?></td>
														<td><?php echo $value['name']; ?></td>
														<td><a class="btn btn-primary" href="?belts&belt=<?php echo $id; ?>">Edit</a></td>
														<td><a class="btn btn-danger" href="admin_bridge.php?belts_delete&delete=<?php echo $id; ?>">Delete</a></td>
													</tr>
													<?php
												}
											}
											?>
										</tbody>
									</table>
									<?php
								}
							} else if (isset($_GET['passwords'])) {
								?>
								<h3>Edit Passwords</h3>
								<h4>Instructor Password</h4>
								<form action="admin_bridge.php" method="post">
									<input name="password_change" value="instructor" type="hidden" />
									<input name="current_password" type="password" placeholder="Current password"/>
									<input name="new_password" type="password" placeholder="New password"/>
									<input name="confirm_password" type="password" placeholder="Retype password to confirm"/>
									<input name="submit" type="submit" value="Submit"/>
								</form>

								<br>
								<h4>Master Password</h4>
								<form action="admin_bridge.php" method="post">
									<input name="password_change" value="master" type="hidden" />
									<input name="current_password" type="password" placeholder="Current password"/>
									<input name="new_password" type="password" placeholder="New password"/>
									<input name="confirm_password" type="password" placeholder="Retype password to confirm"/>
									<input name="submit" type="submit" value="Submit"/>
								</form>
								<?php
							} else if (isset($_GET['settings'])) {
								?>
								<h3>Edit Settings</h3>
								<form action="admin_bridge.php" method="post">
									<input name="settings" type="hidden" />
									<h5>School Name</h5>
									<input name="school_name" type="text" placeholder="School name" value="<?php echo getData("config/tigerscore.json")['school_name']; ?>" />
									<h5>Incoming Email</h5>
									<input name="incoming_email" type="text" placeholder="School name" value="<?php echo getData("config/tigerscore.json")['incoming_email']; ?>" />
									<h5>Outgoing Email</h5>
									<input name="outgoing_email" type="text" placeholder="School name" value="<?php echo getData("config/tigerscore.json")['outgoing_email']; ?>" />
									<input name="submit" type="submit" value="Submit"/>
								</form>

								<br>
								<h5>Receipt for Users (when they submit application)</h5>
								<b>Key:</b><br>
								<b>%%school_name%</b> - school name<br>
								<b>%%first_name%</b> - first name<br>
								<b>%%middle_initial%</b> - middle initial<br>
								<b>%%last_name%</b> - last name<br>
								<b>%%new_belt%</b> - new belt<br>
								<b>%%old_belt%</b> - old belt<br>
								<b>%%new_belt_price%</b> - new belt price<br><br>
								<div id="receipt">
									<?php echo getData("config/tigerscore.json")['receipt']; ?>
								</div>
								<input type="submit" value="Save" id="receipt-save" />

								<br>
								<h5>Receipt When Payment is Validated</h5>
								<b>Same key as above</b><br>
								<div id="payment_validation_email">
									<?php echo getData("config/tigerscore.json")['payment_validation_email']; ?>
								</div>
								<input type="submit" value="Save" id="payment-validation-email-save" />

								<br>
								<h3>Danger Zone</h3>
								<a id="reset_tigerscore" class="btn btn-danger">Reset TigerScore</a>
								<?php
							} else if (isset($_GET['information'])) {
								$url = getData("config/tigerscore.json")['website_root']."/testing_form.php";
								?>
								<h3>TigerScore Information</h3>
								<p>Testing form link: <a href="<?php echo $url; ?>" target="_blank"><?php echo $url; ?></a></p>
								<p>Embed testing form code:</p>
								<pre>&lt;iframe src="<?php echo $url; ?>" width="300" height="700" frameborder="0"&gt;&lt;/iframe&gt;</pre>
								<?php
							} else {
								?>
								<h4>Please select an option to the right.<br><br>If you would like to test students, click <a href="panel.php">here</a>.</h4>
								<?php
							}
							?>
						</div>
					</div>
				</section>
				<?php require_once("templates/scripts.php"); ?>
				<script src="assets/quill/quill.min.js"></script>
				<script src="assets/js/admin.js"></script>
			</body>
			</html>
			<?php
		}
		?>