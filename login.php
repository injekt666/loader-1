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

?>