<?php
require_once("utils.php");
if (!isConfigured()) {
	header("Location: install.php");
} else {
	if (isset($_SESSION['instructor'])) {
		header("Location: panel.php");
	} else if (isset($_POST['name']) && isset($_POST['password'])) {
		if (isset($_GET['admin'])) {
			if (password_verify($_POST['password'], getData("config/tigerscore.json")["master_password"])) {
				$_SESSION['master'] = $_POST['name'];
				$_SESSION['instructor'] = $_POST['name'];
				addToLog($_POST['name']." logged in.");
				header("Location: admin.php");
			} else {
				alert("Incorrect password, please try again.", ".?admin");
			}
		} else {
			if (password_verify($_POST['password'], getData("config/tigerscore.json")["instructor_password"])) {
				$_SESSION['instructor'] = $_POST['name'];
				addToLog($_POST['name']." logged in.");
				header("Location: panel.php");
			} else {
				alert("Incorrect password, please try again.", ".");
			}
		}
	} else {
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<?php require_once("templates/headers.php"); ?>
			<title>TigerScore</title>
			<link href="assets/css/main.css" rel="stylesheet">
			<link href="assets/css/index.css" rel="stylesheet">
		</head>
		<body>
			<?php include 'templates/nav.php'; ?>
			<section id="welcome">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 text-center">
							<img src="assets/images/logo-transparent.png" width="30%"></img>
							<h1>Log In</h1>
							<?php
							if (isset($_GET['admin'])) {
								?>
								<form action=".?admin" method="post">
									<input name="name" type="text" class="inp" placeholder="Master Name"/>
									<input name="password" type="password" class="inp" placeholder="Master Password"/>
									<input name="submit" type="submit" class="admin-login" value="Log In As Admin"/>
								</form>
								<?php
							} else {
								?>
								<form action="." method="post">
									<input name="name" type="text" class="inp" placeholder="Instructor Name"/>
									<input name="password" type="password" class="inp" placeholder="Password"/>
									<input name="submit" type="submit" class="login" value="Log In"/>
								</form>
								<?php
							}
							?>
						</div>
					</div>
				</div>
			</section>
			<?php require_once("templates/scripts.php"); ?>
		</body>
		</html>
		<?php
	}
}