String.prototype.trim = function() {
  return this.replace(/^\s+|\s+$/g, "");
};

var xhr = new XMLHttpRequest();
xhr.open("GET", "http://ptigas.com/hoax.txt", true);
xhr.onreadystatechange = function() {
  if (xhr.readyState == 4) {
    // JSON.parse does not evaluate the attacker's scripts.
    var blacklist = xhr.responseText.trim();    
    if (location.href == blacklist)
	{
		alert("this website is a hoax");
	}
  }
}
xhr.send();