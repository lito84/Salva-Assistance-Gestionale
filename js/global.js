// Apertura finestre popup PDF
function pdf_window(url,name,width,height) {
	/*width += 32;
	height += 96;
	wleft = (screen.width - width) / 2;
	wtop = (screen.height - height) / 2;
	if (wleft < 0) {
		width = screen.width;
		wleft = 0;
	}
	if (wtop < 0) {
		height = screen.height;
		wtop = 0;
	}*/
	
	var win = window.open(url,name,'width='+width+',height='+height+',resizable=yes,location=no,toolbar=no,scrollbars=no,menubar=no,directories=no');
	
	/*win.resizeTo(width,height);
	win.moveTo(wleft,wtop);
	win.focus();*/
}