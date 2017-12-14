# lyricsovh-php
A Lyrics.ovh PHP Implementation.

Searches for a song lyrics.

# Usage
To use the example ***lyricsovh_console.php*** enter the command in the terminal.

```
$php lyricsovh_console.php <artist> <title>
```

To use it into your code, just include the ***lyricsovh.php***.

No need to subclass the ***LyricsAPI*** abstract class. Just call the static function ***search()*** and pass the parameters.

```
$artist = "Coldplay";
$title = "Adventure of a Lifetime";

// Search the lyrics of a song.
try {
	// Parse JSON into array.
	$res = json_decode(lyricsovh\LyricsAPI::search($artist, $title), true);

	printf("Title: %s".CRLF,$title);
	printf("By: %s".CRLF.CRLF,$artist);
	print($res['lyrics']);
} catch (lyricsovh\TimeoutException $e) {
	print($e->getMessage());
}
```

# Live Demo
http://lyrics.pantas.ph
