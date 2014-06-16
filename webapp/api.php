<?php

include 'library/idiorm/idiorm.php';
include 'settings.php';

// A named connection, where 'remote' is an arbitrary key name
ORM::configure('mysql:host=localhost;dbname=' . $mysql_database, null, 'remote');
ORM::configure('username', $mysql_username, 'remote');
ORM::configure('password', $mysql_password, 'remote');

$url = "";
$is_hoax = false;
if (isset($_GET['u']))
{
	$url = stripslashes(nl2br($_GET['u']));

	$hoax = ORM::for_table('hoax', 'remote')->where('url', $url);
  	if ($hoax->count() > 0)
  	{
  		$is_hoax = true;
  	}
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
			var url = '<?php echo $url;?>';
			//$(document.body).append('<iframe id="antihoax_frame" style="background:#eee; padding: 0px; position: fixed; top: 10px; right: 10px; z-index: 999999999;" frameborder="0" scrolling="no" width="350px" height="660px"></iframe>');

			var data = 'checking ' + url + ' ...';
			//$('#antihoax_frame').contents().find('html').html(data);			
			if (<?php echo $is_hoax?'true':'false' ?>)
			{
				alert('ITS A HOAX');
			} else
			{
				alert('all clear');
			}
		}();
	}
})();