<?php
require_once("utils.php");
if (!isConfigured()) {
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<?php require_once("templates/headers.php"); ?>
		<title>TigerScore &bull; Install</title>
		<link href="assets/css/main.css" rel="stylesheet">
		<link href="assets/css/install.css" rel="stylesheet">
	</head>
	<body>
		<?php include 'templates/nav.php'; ?>

		<section id="install-container">
			<h2>
				Install TigerScore
				<span id="step">
					Step <?php 
					if (!isset($_GET['step'])) {
						echo "1";
					} else {
						echo $_GET['step'];
					}
					?>		
				</span>
			</h2>
			<?php
			if (!isset($_GET['step'])) {
				?>
				<h3>Requirements</h3>
				<ul>
					<li>Latest version of PHP</li>
					<li>Read/write permissions for files in this directory</li>
					<li>A mail server that is compatible with the PHP mail() function</li>
				</ul>

				<h3>Suggestions</h3>
				<ul>
					<li>If you already have a website for your academy, you may want to consider installing this in a subdirectory of the site (such as <b>/tigerscore/</b>)</li>
					<li>If you do not know how to install this or if you are having issues, the developer of this software can install it for you. <a href="mailto:jmistri7@gmail.com">Contact him</a> for more info.</li>
				</ul>

				<a class="btn btn-primary" href="install.php?step=2">Acknowledge and Continue</a>
				<?php
			} else {
				if ($_GET['step'] == '2') {
					?>
					<h3>User Configuration</h3>
					<form action="install.php?step=3" method="post">
						<p>Website Root <span class="red">*</span></p>
						<input name="website_root" id="website_root" type="text" placeholder="Exact URL of the TigerScore root directory; it is your URL bar up to 'install.php' but without the trailing '/'" />
						<p>School Name <span class="red">*</span></p>
						<input name="school_name" id="school_name" type="text" placeholder="This will be displayed in confirmation emails" />
						<p>Your School's Incoming Email <span class="red">*</span></p>
						<input name="incoming_email" id="incoming_email" type="email" placeholder="This is the email that all receipts will be sent to" />
						<p>Outgoing Email Address <span class="red">*</span></p>
						<input name="outgoing_email" id="outgoing_email" type="email" placeholder="This should not be a currently existing email; it will be used to send receipts, and it MUST be under the domain that this is being hosted on" />
						<p>Instructor Password <span class="red">*</span></p>
						<input name="instructor_password" id="instructor_password" type="password" placeholder="This is the password you will be able to give to all instructors to log into the system" />
						<p>Master Password <span class="red">*</span></p>
						<input name="master_password" id="master_password" type="password" placeholder="You should keep this password secret, it enables you to manage the curriculum of the school" />
						<br /><br />
						<input type="submit" id="step-2-submit" class="btn btn-primary submit disabled" value="Next" />
					</form>
					<?php
				} else if ($_GET['step'] == '3') {
					$opts = [
						"website_root" => $_POST['website_root'],
						"school_name" => $_POST['school_name'],
						"incoming_email" => $_POST['incoming_email'],
						"outgoing_email" => $_POST['outgoing_email'],
						"instructor_password" => $_POST['instructor_password'],
						"master_password" => $_POST['master_password']
					];
					configureTigerScore($opts);
					?>
					<h3>Installation Complete</h3>
					<p>Congratulations! You have completed the installation of TigerScore. From here, we advise that you input your testing-specific settings in your admin panel. The admin panel password is the password that you input as your <b class="red">master password</b>. Click <a href=".?admin">here</a> to go to your admin panel. Enjoy TigerScore!</p>
					<?php
				}
			}
			?>
		</section>

		<?php require_once("templates/scripts.php"); ?>
		<script src="assets/js/install.js"></script>
	</body>
	</html>
	<?php
} else {
	header("Location: .");
}