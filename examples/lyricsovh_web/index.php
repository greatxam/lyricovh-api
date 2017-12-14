<?php 
	require_once(dirname(dirname(dirname(__FILE__))).'/src/lyricsovh.php');

	if ($_GET) {
		$artist = $_GET['artist'];
		$title = $_GET['title'];

		// Search the lyrics of a song.
		try {
			// Parse JSON into array.
			$res = json_decode(lyricsovh\LyricsAPI::search($artist, $title), true);
			$res['artist'] = $artist;
			$res['title'] = $title;
		} catch (lyricsovh\TimeoutException $e) {
			$res = array('error'=>$e->getMessage());
		} catch (lyricsovh\APIException $e) {
			$res = array('error'=>$e->getMessage());
		} catch (lyricsovh\LyricsNotFoundException $e) {
			$res = array('error'=>$e->getMessage());
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>lyrics.ovh API PHP Implementation</title>
	<meta charset="utf-8">
	<meta NAME="robots" CONTENT="noindex, nofollow">

	<!-- jQuery 3.x -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="css/jumbotron-narrow.css" >

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<div class="header clearfix">
			<nav>
				<ul class="nav nav-pills pull-right">
					<li role="presentation" class="active"><a href="#">Home</a></li>
					<li role="presentation"><a href="#">About</a></li>
					<li role="presentation"><a href="#">Contact</a></li>
				</ul>
			</nav>
			<h3 class="text-muted">lyricsovh-php</h3>
		</div>
		<div class="jumbotron">
			<h1>lyrics.ovh API implementation for PHP.</h1>
			<p class="lead">
				A lyrics.ovh PHP Implementation. Searches for a song lyrics.
			</p>
		</div>
		<form class="form-horizontal" metho="get">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<div class="form-group">
						<label for="artist" class="col-sm-2 control-label">Artist</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="artist" name="artist" placeholder="Artist">
						</div>
					</div>
					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">Title</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="title" name="title" placeholder="Title">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-primary">Search</button>
						</div>
					</div>
				</div>
				<!-- Search result -->
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<?php if(isset($res)): ?>
						<?php if(isset($res['error'])): ?>
							<!-- Error message -->
							<p class="text-danger"><?php echo $res['error']; ?></p>
						<?php else: ?>
							<!-- Lyrics found -->
							<h4><u><?php echo $res['title']; ?></u></h4>
							<h5><?php echo $res['artist']; ?></h5>
							<p><em><?php echo nl2br($res['lyrics']); ?></em></p>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		</form>
		<footer class="footer">
			<p>© 2017 Maximillian M. Estrada</p>
		</footer>
	</div>
</body>
</html>