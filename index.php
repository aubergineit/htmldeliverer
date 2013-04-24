<?php
require_once('core.inc.php');
?><!DOCTYPE html>
<html>
	<head>
		<title>HTMLViewer</title>

		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
		<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/media/jquery.snippet.css" />
		<link rel="stylesheet" href="/media/jquery.selectboxit.css" />
		<link href="/media/viewer.css" type="text/css" media="screen" rel="stylesheet" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

		<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
		<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
		<script src="/media/jquery.snippet.min.js"></script>
		<script src="/media/jquery.selectboxit.min.js"></script>
		<script src="/media/main.js"></script>

	</head>
	<body>
		<input type="hidden" id="config_file" value="<?= $configFile; ?>" />
		<div id="file-list">
			<div class="logo">
				<img src="/media/aubergine-it-logo.png" alt="Aubergine IT" />
			</div>

			<h1 class="project-title"><?= $projectTitle; ?></h1>
			<div class="validators">
				<a href="#" id="w3c" data-default="http://validator.w3.org/check?uri=" target="_blank"><img src="/media/html5_white.png" class="html" /></a>
			</div>
			<div class="page-txt">Pages: </div>
			<div class="dropdown">
				<select id="file-source">
				<?
				foreach($groups as $groupName => $pages) {
					echo '<optgroup label="' . $groupName . '">';
					foreach($pages as $entry) {
						echo '<option value="' . $entry['src'] . '">' . $entry['title'] . '</option>';
					}
					echo '</optgroup>';
				}
				?>
				</select>
			</div>
			<div class="refresh-frame">
				<a href="#" class="frame-refresher"><img src="/media/refresh_white.png" alt="Refresh frame" /></a>
			</div>
			<div class="external-txt">
				<a href="#" class="external-link" target="_blank"><img src="/media/external_link_white.png" alt="Nieuw window" /> Open in a new window </a></span>
			</div>
			<div class="tinyurl-txt">
				<img src="/media/link_white.png" alt="Verkorte link" /> <input type="text" name="tinyurl" id="tinyurl" />
			</div>
		</div>

		<div id="maindock">
			<div id="width-changer">
					<select>
						<option value="340">320px</option>
						<option value="620">600px</option>
						<option value="788">768px</option>
						<option value="1024" selected="selected">1024px</option>
						<option value="1300">1300px</option>
					</select>
				</div>

			<div id="tabs">
				<ul>
					<li><a href="#preview">Preview</a></li>
					<li><a href="#previewsource">HTML</a></li>
					<li><a href="#preview" data-value="480">Smartphone</a></li>
					<li><a href="#preview" data-value="620">Small tablet</a></li>
					<li><a href="#preview" data-value="788">Tablet portrait</a></li>
					<li><a href="#preview" data-value="1024">Tablet landscape</a></li>
					<li><a href="#preview" data-value="1300">Laptop</a></li>
				</ul>
				<div id="preview" class="ui-widget-content">
					<iframe src="/emptyiframe.html" class="ui-widget-content" frameborder="no" id="frame-source" width="100%" height="100%"></iframe>
				</div>
				<div id="previewsource">
				</div>
			</div>
		</div>
	</body>
</html>
