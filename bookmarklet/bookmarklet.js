(function(){
	var src = "http://localhost/antihoax/api.php?f=js&u="+url;
	var script = document.createElement("script");
	script.src = src;
	script.onload = script.onreadystatechange = function(){
		if (!done && (!this.readyState || this.readyState == "loaded" || this.readyState == "complete")) {
			done = true;
		}
	};
	document.getElementsByTagName("head")[0].appendChild(script);
})();