<?php


?><!DOCTYPE html>
<html>
	<head>
		<title>HTMLViewer</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="media/mobile.css" />
	</head>
	<body>
		<div class="container">
			<div class="logo">
				<img src="media/aubergine-it-logo.png" alt="Aubergine IT" />
			</div>
			<h1><?= $projectTitle; ?></h1>

			<?
			foreach($groups as $groupName => $pages) {
				echo '<h2>' . $groupName . '</h2>';
				echo '<ul>';
				foreach($pages as $entry) {
					echo '<li><a href="' . $entry['src'] . '" target="_blank">' . $entry['title'] . '</a></li>';
				}
				echo '</ul>';
			}
			?>
		</div>
	</body>
</html>