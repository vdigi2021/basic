window.onload = function() {
document.addEventListener("contextmenu", function(e) {
	e.preventDefault();
}, false);
document.addEventListener("keydown", function(e) {
	//document.onkeydown = function(e) {
	// "I" key
	if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
		disabledEvent(e);
	}
	// "J" key
	if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
		disabledEvent(e);
	}
	// "S" key + macOS
	if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
		disabledEvent(e);
	}
	// "U" key
	if (e.ctrlKey && e.keyCode == 85) {
		disabledEvent(e);
	}
	// "F12" key
	if (event.keyCode == 123) {
		disabledEvent(e);
	}
	if(e.ctrlKey && (e.key == "p" || e.charCode == 16 || e.charCode == 112 || e.keyCode == 80) ){
		e.cancelBubble = true;
		e.preventDefault();
		e.stopImmediatePropagation();
	}  
}, false);

function disabledEvent(e) {
	if (e.stopPropagation) {
		e.stopPropagation();
	} else if (window.event) {
		window.event.cancelBubble = true;
	}
	e.preventDefault();
	return false;
}
};
function AddOriginalLink(){
    var body_element = document.getElementsByTagName('body')[0];
    var selection;
    selection = window.getSelection();
    var pagelink = "Source : <a href='"+document.location.href+"'>"+document.location.href+"</a> - WP Extra";
    var copytext = pagelink;
    var newdiv = document.createElement('div');
    newdiv.style.position='absolute';
    newdiv.style.left='-99999px';
    body_element.appendChild(newdiv);
    newdiv.innerHTML = copytext;
    selection.selectAllChildren(newdiv);
    window.setTimeout(function() {
        body_element.removeChild(newdiv);
    },0);
};
// To disable Original Link
document.oncopy = AddOriginalLink;
// To disable click right
document.addEventListener("contextmenu", function(e){
	e.preventDefault();
}, false);