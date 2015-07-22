(function() {
    var t, e, a, n, o, r, i, d, s, m;
    a = null, n = null, e = null, t = function() {
        var t, o;
        return o = document.createDocumentFragment(), a = document.createElement("iframe"), a.name = "dpmk", a.id = "dpmk", a.classList.add("animated"), a.classList.add("bounceInRight"), a.src = "http://localhost/antihoax/api.php?u={{ url }}&f=sidebar", o.appendChild(a), n = document.createElement("div"), n.id = "dpmkr", o.appendChild(n), e = document.createElement("style"), e.type = "text/css", t = "#dpmk,#dpmkr{ width:260px; height:100%; position:fixed; top:0;right:0; bottom:0; border:none } #dpmk{ z-index:9999999998; background:#fff; box-shadow: 0 10px 20px rgba(0, 0, 20, 0.15); display: block !important; } #dpmkr{ z-index:9999999999; display:none; opacity:0 } #dpmkr.is-active{ display:block } .animated{-webkit-animation-fill-mode:both;-moz-animation-fill-mode:both;-ms-animation-fill-mode:both;-o-animation-fill-mode:both;animation-fill-mode:both;-webkit-animation-duration:1s;-moz-animation-duration:1s;-ms-animation-duration:1s;-o-animation-duration:1s;animation-duration:1s;}.animated.hinge{-webkit-animation-duration:1s;-moz-animation-duration:1s;-ms-animation-duration:1s;-o-animation-duration:1s;animation-duration:1s;} @-webkit-keyframes bounceInRight { 0% { opacity: 0; -webkit-transform: translateX(2000px); } 60% { opacity: 1; -webkit-transform: translateX(-30px); } 80% { -webkit-transform: translateX(10px); } 100% { -webkit-transform: translateX(0); } } @-moz-keyframes bounceInRight { 0% { opacity: 0; -moz-transform: translateX(2000px); } 60% { opacity: 1; -moz-transform: translateX(-30px); } 80% { -moz-transform: translateX(10px); } 100% { -moz-transform: translateX(0); } } @-o-keyframes bounceInRight { 0% { opacity: 0; -o-transform: translateX(2000px); } 60% { opacity: 1; -o-transform: translateX(-30px); } 80% { -o-transform: translateX(10px); } 100% { -o-transform: translateX(0); } } @keyframes bounceInRight { 0% { opacity: 0; transform: translateX(2000px); } 60% { opacity: 1; transform: translateX(-30px); } 80% { transform: translateX(10px); } 100% { transform: translateX(0); } } .bounceInRight { -webkit-animation-name: bounceInRight; -moz-animation-name: bounceInRight; -o-animation-name: bounceInRight; animation-name: bounceInRight; }", location.hostname.indexOf("flickr.com") > -1 && (t += "#photo-drag-proxy,.facade-of-protection{z-index:-1 !important}"), e.styleSheet ? e.styleSheet.cssText = dcss : e.appendChild(document.createTextNode(t)), o.appendChild(e), document.body.appendChild(o)
    }, s = function(t) {
        var e, a, o;
        if (!n.classList.contains("is-active")) return n.classList.add("is-active"), "undefined" == typeof t.dataTransfer.getData("text/html") && "IMG" === t.target.tagName ? (o = d(t.target, "A"), o ? (e = o.cloneNode(!1), e.href = e.href, a = t.target.cloneNode(!1), a.src = a.src, e.appendChild(a), t.dataTransfer.setData("text/html", e.outerHTML)) : (a = t.target.cloneNode(!1), a.src = a.src, t.dataTransfer.setData("text/html", a.outerHTML))) : void 0
    }, m = function() {
        return window.addEventListener("message", r, !1), document.addEventListener("dragstart", function(t) {
            return s(t), t.dataTransfer.dropEffect = "copy"
        }, !0), document.addEventListener("dragenter", function(t) {
            return s(t), t.dataTransfer.dropEffect = "copy"
        }, !0), document.addEventListener("dragend", function() {
            return n.classList.remove("is-active")
        }, !0), n.addEventListener("dragover", function(t) {
            return t.stopPropagation(), t.preventDefault(), t.dataTransfer.dropEffect = "copy", !1
        }, !1), n.addEventListener("dragenter", function(t) {
            return t.dataTransfer.dropEffect = "copy", i({
                action: "dragenter"
            }), !1
        }, !1), n.addEventListener("dragleave", function(t) {
            return t.dataTransfer.dropEffect = "copy", i({
                action: "dragleave"
            }), !1
        }, !1), n.addEventListener("drop", function(t) {
            var e, a;
            t.stopPropagation(), t.preventDefault(), e = new Object, e.source = location.href, e.title = document.title;
            for (a in t.dataTransfer.types) e[t.dataTransfer.types[a]] = t.dataTransfer.getData(t.dataTransfer.types[a]);
            return i({
                action: "drop",
                value: e
            }), n.classList.remove("is-active"), !1
        }, !1)
    }, r = function(t) {
        var e;
        return "issidebar" === t.data.action ? i({
            action: "issidebar",
            value: !0
        }) : "bookmarkPage" === t.data.action ? (e = new Object, e.url = location.href, e.title = document.title, i({
            action: "drop",
            value: e
        })) : "close" === t.data.action ? o() : void 0
    }, o = function() {
        return window.removeEventListener && window.removeEventListener("message", r, !1), a && document.body.removeChild(a), n && document.body.removeChild(n), e ? document.body.removeChild(e) : void 0
    }, d = function(t, e) {
        for (; t.parentNode;)
            if (t = t.parentNode, t.tagName === e) return t
    }, i = function(t) {
        return a.contentWindow.postMessage(t, "*")
    }, document.getElementById("dpmk") || (t(), m())
}).call(this);
//# sourceMappingURL=maps/bookmarklet.min.js.map
