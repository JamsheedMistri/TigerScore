<nav class="navbar fixed-top" role="navigation">
	<div class="navbar-header">
		<a class="navbar-brand" href=".">TigerScore</a>
		<div class="nav-wrapper">
			<ul class="nav navbar-left">
				<li><a href="testing_form.php?from_app" target="_blank">Testing Form</a></li>
				<?php
				if (isset($_SESSION['master'])) {
					?>
					<li><a href="panel.php">Testing Panel</a></li>
					<li><a href="admin.php" class="red">Admin Panel</a></li>		
					<?php
				}
				?>
			</ul>
		</div>
	</div>

	<ul class="nav navbar-right">
		<?php
		if (isConfigured()) {
			if (isset($_SESSION['master'])) {
				?>
				<li><a href='logout.php'>Log Out Of <?php echo $_SESSION['master']; ?>'s Admin Account</a></li>
				<?php
			} else if (isset($_SESSION['instructor'])) {
				?>
				<li><a href='logout.php'>Log Out of Instructor <?php echo $_SESSION['instructor']; ?>'s Account</a></li>
				<?php
			} else {
				?>
				<li><a href=".?admin">Log In As Admin</a></li>
				<li><a href=".">Log In</a></li>
				<?php
			}
		}
		?>
	</ul>
</nav>