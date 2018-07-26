<?php

	/*
    
        === Loader ===
        Developed by Justin
        Simple C# loader with PHP & MySQL integration.
        Github: https://github.com/name/loader
        
    */

    require 'server.php';

    // Function to output text in JSON format.
	// Example : output('true', 'Success!')
	function output($status, $message, $extras = null) {
		$response = array('status' => $status ? "true" : "false", 'message' => $message);
		if ($extras != null)
			array_fuse($response, $extras);
		die(json_encode($response));
	}

	// Function to get the client's UserAgent.
	// Used to stop handler from browser.
	function getUA() {
		if (isset($_SERVER['HTTP_USER_AGENT']))
			return $_SERVER['HTTP_USER_AGENT'];
		return 'N/A';
	}

	// Check if request is from correct useragent
	$ua = getUA();
	if ($ua != "Loader")
		output(false, 'Wrong Client.');

	// Set action variable
	$action = $_GET['action'];
	// Protect from SQL injection
	$username = $conn->real_escape_string($_GET['username']);
	$hwid = $conn->real_escape_string($_GET['hwid']);
	// If logging in
	if ($action == 'login') {
		// Check that username + hwid have values
		if (isset($_GET['username']) and isset($_GET['hwid']) and !empty($_GET['username']) and !empty($_GET['hwid'])) {
			// Get username from request
			$username = $_GET['username'];
			// Select from the table users where username = post username & hwid = post hwid
			$sql = "SELECT * FROM users WHERE uname='$username' and hwid='$hwid'";
			// Database query
			$res = mysqli_query($conn, $sql);
			// Fetch associated from query
			$row = mysqli_fetch_assoc($res);
			// Check if user exists in database
			if (mysqli_num_rows($res)<1) {
				// User doesn't exist
				output(false, 'Failed to verify user.');
			} else {
				// User exists
        		output(true, 'Verified user successfully.');
			}
		} else {
			// At least one request value is empty.
			output(false, 'Failed to verify user.');
		}
	}
?>