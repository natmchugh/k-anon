<?php
session_start();

if (isset($_GET['reset']) && $_GET['reset']) {
	$_SESSION['guesses'] = [];
	return;
}

require __DIR__.'/guess.php';

function makeGuesses($hashPrefix, $guesses)
{
	
	if (empty($guesses)) {
		$newGuesses = search_for_prefix($hashPrefix);
	} else {
		$newGuesses = extend($guesses, $hashPrefix);
	}
	if (empty($newGuesses)) {
		$newGuesses = extendTwice($guesses, $hashPrefix);
	}
	return $newGuesses;
}


$guesses = [];
if (isset($_SESSION['guesses']) && count($_SESSION['guesses']) > 0) {
	$guesses = $_SESSION['guesses'];
}
if (isset($_GET['range'])) {
	$prefix = $_GET['range'];
	$hashPrefix = substr($prefix, 0, 5);

	$hibp_url = sprintf('https://api.pwnedpasswords.com/range/%s', $hashPrefix);

	$guesses = makeGuesses($hashPrefix, $guesses);
	if (count($guesses) > 0) {
		$_SESSION['guesses'] = $guesses;
		echo json_encode($guesses);
	}
	echo "\n---BEGIN-HIBP---\n";
	$response = file_get_contents($hibp_url);
	echo $response;
}