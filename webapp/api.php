<?php

$url = "";

if (isset($_GET['u']))
{
	$url = $_GET['u'];

	// TODO: check if there is anything regarding this url
}

?>
(function(){

	var v = "1.3.2";

	if (window.jQuery === undefined || window.jQuery.fn.jquery < v) {
		var done = false;
		var script = document.createElement("script");
		script.src = "http://ajax.googleapis.com/ajax/libs/jquery/" + v + "/jquery.min.js";
		script.onload = script.onreadystatechange = function(){
			if (!done && (!this.readyState || this.readyState == "loaded" || this.readyState == "complete")) {
				done = true;
				initMyBookmarklet();
			}
		};
		document.getElementsByTagName("head")[0].appendChild(script);
	} else {
		initMyBookmarklet();
	}

	function initMyBookmarklet() {
		window.myBookmarklet = function() {						
			var url = decodeURIComponent('<?php echo $_GET['u'];?>');
			//$(document.body).append('<iframe id="antihoax_frame" style="background:#eee; padding: 0px; position: fixed; top: 10px; right: 10px; z-index: 999999999;" frameborder="0" scrolling="no" width="350px" height="660px"></iframe>');

			var data = 'checking ' + url + ' ...';
			//$('#antihoax_frame').contents().find('html').html(data);
			alert(data);
		}();
	}
})();