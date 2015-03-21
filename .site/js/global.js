//Window
(function (window, document, undefined) {
	var currentWindow = null;
	var windowAnimationTime = 200; //ms
	
	_construct();
	
	//Cleans up the code a lil 
	function _construct() {
		//Bind all toggles
		var windowOpenNodes = document.getElementsByClassName("window-open");
		for (var i = 0; i < windowOpenNodes.length; i++)
			windowOpenNodes[i].onclick = windowOpenOnClick;
		
		var windowCloseNodes = document.getElementsByClassName("window-close");
		for (var i = 0; i < windowCloseNodes.length; i++) {
			windowCloseNodes[i].onclick = closeWindow;
		}
	}
	
	/**
	 * Closes the currently opened window if there is one
	 */
	function closeWindow(callback) {
		if (currentWindow == null) {
			if (typeof callback == "function")
				callback();
			return;
		}
		
		currentWindow.classList.remove("open");
		var activeTabs = document.querySelectorAll(".window-open.active");
		for (var i = 0; i < activeTabs.length; i++)
			activeTabs[i].classList.remove("active");
		
		setTimeout(function() {
			currentWindow.style.display = "none";
			currentWindow = null;
			if (typeof callback == "function")
				callback();
		}, windowAnimationTime);
	}
	
	/**
	 * Simply opens the one that it says it opens.
	 */
	function windowOpenOnClick() {
		//Is there a window to open?
		if (!this.attributes["data-window"])
			return;
		var hWindow = document.getElementById("window-" 
				+ this.attributes["data-window"].value);
		if (!hWindow)
			return;
		
		openWindow(hWindow);
		
		//Actiate tab
		this.classList.add("active");
	}
	
	/**
	 * Closes all windows and opens the specified one.
	 */
	function openWindow(hWindow) {
		closeWindow(function() {
			hWindow.style.display = "block";
			currentWindow = hWindow;
			setTimeout(openWindowAddClass, 20);
		});
	}
	
	function openWindowByName(windowName) {
		var hWindow = document.getElementById(windowName);
		if (!hWindow)
			return;
		
		openWindow(hWindow);
	}
	
	function openWindowAddClass() {
		currentWindow.classList.add("open");
	}
	
	window.openWindowByName = openWindowByName;
	
} (this, document));
