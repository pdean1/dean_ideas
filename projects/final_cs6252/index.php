<?php

// Bringing in common code
require_once 'util/app.util.php';
require_once 'util/secure_conn.util.php';
require_once 'util/sessions.util.php';

if (isset($_SESSION['user'])) {
	$pageTitle = "Home";
	include 'view_home.php';
} else {
	// Forces the user to sign-in or register
	redirect($appPath . "authorization");
}