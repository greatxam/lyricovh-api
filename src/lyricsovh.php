<?php
/**
* lyrics.ovh API PHP Implementation
* Copyright (c) 2017 Maximillian M. Estrada. All rights reserved.
* Created by Maximillian M. Estrada on 14/12/2017
*
* @copyright 	Copyright (c) 2017 Maximillian M. Estrada.
* @since 		0.1.0
*/
namespace lyricsovh;

/*
* LyricsAPI
* An abstract class for conviently call lyrics.ovh endpoints.
* No need to subclass. Just call the specific function for each API endpoints.
* 
* @property String URL
* @property String VERSION
*/
abstract class LyricsAPI {
	const URL = "https://api.lyrics.ovh";
	const VERSION = "v1";

	/*
	* Searches the lyrics.ovh for the lyrics of a song.
	* 
	* @parameter String $artist
	* @parameter String $title
	*/
	public static function search($artist, $title) {
		// $url/$version/$artist/$title
		$url = sprintf("%s/%s/%s/%s", 
			LyricsAPI::URL, LyricsAPI::VERSION, urlencode($artist), urlencode($title));

		// HTTP GET request using cUrl
		$options = array(
			CURLOPT_URL=>$url,
			CURLOPT_RETURNTRANSFER=>true,
			CURLOPT_CONNECTTIMEOUT=>5,
			CURLOPT_TIMEOUT=>5,
		);
		$curl = curl_init();
		curl_setopt_array($curl, $options);
		if(!$response = curl_exec($curl)) {
			switch (curl_errno($curl)) {
				case 28: // CURLE_OPERATION_TIMEOUT
					throw new TimeoutException(curl_error($curl), 1);
					break;
				default: // Catch any other cUrl error
					throw new APIException(curl_error($curl), 1);
					break;
			}
		} else {
			// Return the json reponse
			return $response;
		}
		curl_close($curl);

		throw new LyricsNotFoundException("Lyrics not found!", 1);
	}
}

/*
* APIException
* Use when an endpoint call error occurs.
*/
class APIException extends \Exception {}

/*
* TimeoutException
* Use when an endpoint call exceeds the maximum timeout.
*/
class TimeoutException extends \Exception {}

/*
* LyricsNotFoundException
* Use when no lyrics found.
*/
class LyricsNotFoundException extends \Exception {}
?>