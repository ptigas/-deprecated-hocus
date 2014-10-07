<?php
sleep(3);

require_once 'core.php';

function check_url($url)
{
	return Hoax::fetch_hoax($url) != null;	
}

$url = "";
$is_hoax = false;
if (isset($_GET['u']))
{
	$url = normalize_url(stripslashes(nl2br($_GET['u'])));

	echo check_url($url) ? 'true' : 'false';
}
/*
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
				init();
			}
		};
		document.getElementsByTagName("head")[0].appendChild(script);
	} else {
		init();
	}

	function init() {
		window.myBookmarklet = function() {						
			var url = '<?php echo $url;?>';		
			var data = 'checking ' + url + ' ...';
				
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

*/
?>