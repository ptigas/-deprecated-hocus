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
			var url = '{{ url }}';
			var data = 'checking ' + url + ' ...';

			if ({{ is_hoax }})
			{
				alert('ITS A HOAX');
			} else
			{
				alert('yoyo! all clear');
			}
		}();
	}
})();