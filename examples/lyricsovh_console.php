<?php
/**
* lyrics.ovh API PHP Implementation
* Copyright (c) 2017 Maximillian M. Estrada. All rights reserved.
* Created by Maximillian M. Estrada on 14/12/2017
*
* @copyright 	Copyright (c) 2017 Maximillian M. Estrada.
* @since 		0.1.0
*/
require_once(dirname(dirname(__FILE__)).'/src/lyricsovh.php');
// Carriage Return and Line Feed
define("CRLF", "\r\n");

/*
* lyricsovh_console
* 
* Usage: lyricsovh_console.php <artist> <title>
*/
echo "Prints the lyrics of a song. Perform 'search' API endpoint of lyrics.ovh.".CRLF.CRLF;
if (empty($argv[1])) {
	echo "Arguments are empty. Please pass the 'artist' and the song 'title'".CRLF
		."Usage: lyricsovh_console.php <artist> <title>".CRLF
		."Example: lyricsovh_console.php \"Coldplay\" \"Adventure of a Lifetime\"".CRLF;
	exit(1);
} else {
	// Remove the first argument which is the filename 'lyricsovh_console.php'
	unset($argv[0]);

	// Search the lyrics of a song.
	try {
		// Parse JSON into array.
		$res = json_decode(lyricsovh\LyricsAPI::search($argv[1], $argv[2]), true);

		printf("Title: %s".CRLF,$argv[2]);
		printf("By: %s".CRLF.CRLF,$argv[1]);
		print($res['lyrics']);
	} catch (lyricsovh\TimeoutException $e) {
		print($e->getMessage());
	} catch (lyricsovh\APIException $e) {
		print($e->getMessage());
	} catch (lyricsovh\LyricsNotFoundException $e) {
		print($e->getMessage());
	}
}

echo CRLF;
?>