<?php
require_once("utils.php");
$_SESSION = [];
session_destroy();
alert("Successfully logged out!", ".");
?>