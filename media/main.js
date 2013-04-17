
var parsedConfig = {};
var tabs;
var tabCounter = 2;
var tabTemplate = "<li><a href='#{href}'>#{label}</a></li>";

$(document).ready(function() {

	// Make iframe resizable
	$("#preview").resizable({
		iframeFix: true,
		helper: "ui-resizable-helper" // will make a box around the iframe (no live resize preview)
	});

	// Change tabs
	$("#file-list select, #width-changer select").selectBoxIt();

	// Change handler for the dropdown
	$('#file-source').change(function() {

		// Show new file in the iframe
		changeFile($(this).val());

		// Change the external link to new URL
		$('.external-link').attr('href', $(this).val());


		var bigurl = 'http://' + document.location.hostname + $(this).val();

		
		$('#w3c').attr('href', $('#w3c').attr('data-default') + escape(bigurl));

		// Retrieve and show the TinyURL
		
		$.getJSON('http://json-tinyurl.appspot.com/?callback=?', { 'url': bigurl },
      function(data) {
				$('#tinyurl').val(data.tinyurl);
      }
    );
	});


	// Change handler for the with-dropdown, it resizes
	// the iframe to the selected width
	$('#width-changer select').change(function() {
		$('#preview').animate({width:$(this).val() + 'px'},400);
	});

	$('#width-changer select').change();

	// tiny url focus/click that selects the content
	$('#file-list .tinyurl-txt input').click(function() {
		$(this).select();
	});

	// init jQuery UI Tabs
	tabs = $('#tabs').tabs();

	// Check if the preview panel is selected
	// and show the width-dropdown accordingly
	$("#tabs").on("tabsactivate", function( event, ui ) {
		var width = ui.newTab.find('a').attr('data-value');
		if (typeof width !== 'undefined') {
			$('#width-changer select').val(width);
			$('#width-changer select').change();
		}
		if(ui.newPanel.attr('id') == 'preview') $('#width-changer').fadeIn(200);
		else $('#width-changer').fadeOut(200);
	});

	$('.frame-refresher').click(function(e) {
		document.getElementById('frame-source').contentWindow.location.reload(true);
		e.preventDefault();
	});

	// Load config XML

	configFile = '/' + $('#config_file').val();
	$.ajax({
		type: "GET",
		dataType: "xml",
		url: configFile,
		success: function(xml){
			$(xml).find("page").each(function(){
				tmpFill = {};
				$(this).find('image').each(function() {
					src = $(this).attr('src');
					src = src.indexOf('/') != 0 ? '/' + src : src;
					tmpFill[src] = $(this).text();
				});
				fileSrc = $(this).attr('src');
				fileSrc = fileSrc.indexOf('/') != 0 ? '/' + fileSrc : fileSrc;
				parsedConfig[fileSrc] = tmpFill;
			});

			$('#file-source').change();
		},
		error: function(code) {
		}
	});
});

function changeFile(file) {

	//removeTabs();

	selectedSource = file;
	$('#frame-source').attr('src', selectedSource);

	// Add image tabs + Source
	$.each(parsedConfig, function(index, val) {
		if(index == selectedSource) {
			$.each(val, function(imageSource, imageName) {
				//addTab(imageName, '<img src="' + imageSource + '" />');
			});
		}
	});
	$.get(selectedSource, function(code) {
		elm = $('<pre>');
		elm.text(code.replace(/\t/g, '  '));
		$('#previewsource').html(elm);
		elm.snippet("html", {style:'ide-eclipse'});
	});
}

// actual addTab function: adds new tab using the input from the form above
function addTab(title, htmlContent) {
	var label = title,
	id = "tabs-" + tabCounter,
	li = $( tabTemplate.replace( /#\{href\}/g, "#" + id ).replace( /#\{label\}/g, label ) ),
	tabContentHtml = htmlContent || "Content niet gevonden.";
	tabs.find( ".ui-tabs-nav" ).append( li );
	tabs.append( "<div id='" + id + "'>" + tabContentHtml + "</div>" );
	tabs.tabs( "refresh" );
	tabCounter++;
}

// remove all tabs except for the Preview and HTML tab
function removeTabs() {
	$('#tabs ul li a').each(function() {
		closestLi = $(this).closest('li');
		closestLiId = closestLi.attr('aria-controls');
		if(closestLiId != 'preview' && closestLiId != 'previewsource') {
			var panelId = closestLi.remove().attr('aria-controls');
			$( "#" + panelId ).remove();
			tabs.tabs( "refresh" );
		}
	});
}