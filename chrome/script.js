/*Handle requests from background.html*/
function handleRequest(	
	request, 	
	sender, sendResponse
	) {
	if (request.callFunction == "toggleSidebar")
		toggleSidebar();
}
chrome.extension.onRequest.addListener(handleRequest);

/*Small function wich create a sidebar(just to illustrate my point)*/
var sidebarOpen = false;
function toggleSidebar() {
	if(sidebarOpen) {
		var el = document.getElementById('mySidebar');
		el.parentNode.removeChild(el);
		sidebarOpen = false;
	}
	else {
		var sidebar = document.createElement('div');
		sidebar.id = "mySidebar";
		sidebar.innerHTML = "\
			<h1>Warning</h1>\
			This entry has been marked as a hoax.\
			Here is some evidence.\
			blaah\
			<a href=''>[upvote]</a> <a href=''>[downvote]</a>\
		";
		sidebar.style.cssText = "\
		border-right: 1px solid #E0E0E0;\
        box-shadow: 1px 1px 23px rgba(0, 0, 0, 0.17), -1px -1px 0 rgba(255, 255, 255, 0.85) inset;\
        position:fixed;\
        padding-left:10px\
        z-index: 2147483647;\
        width:270px;\
        background:#eee;\
        height:100%;\
        top:0;\
        right:0;\
		";
		document.body.appendChild(sidebar);
		sidebarOpen = true;
	}
}

String.prototype.trim = function() {
  return this.replace(/^\s+|\s+$/g, "");
};

var xhr = new XMLHttpRequest();
xhr.open("POST", "http://ptigas.com/hoax.php", true);
xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xhr.onreadystatechange = function() {
  if (xhr.readyState == 4) {
    // JSON.parse does not evaluate the attacker's scripts.
    var response = xhr.responseText.trim();    
    if (response == "true")
	{
		toggleSidebar();		
	}
  }
}
xhr.send("url=" + encodeURI(location.href));