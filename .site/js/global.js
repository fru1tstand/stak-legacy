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
	
	function openWindowAddClass() {
		currentWindow.classList.add("open");
	}
	
} (this, document));

//sidebars
(function (window, document, undefined) {
	var openSidebars = [];
	var sidebarAnimationTime = 500; //ms
	
	_construct();
	
	function _construct() {
		//Bind toggles
		var sidebarOpenNodes = document.getElementsByClassName("sidebar-open");
		for (var i = 0; i < sidebarOpenNodes.length; i++) 
			sidebarOpenNodes[i].onclick = sidebarOpenClick;
		
		var sidebarCloseNodes = document.getElementsByClassName("sidebar-close");
		for (var i = 0; i < sidebarCloseNodes.length; i++)
			sidebarCloseNodes[i].onclick = function() { sidebarClose(this); }
		
		var sidebarContainers = document.getElementsByClassName("sidebar-container");
		for (var i = 0; i < sidebarContainers.length; i++)
			sidebarContainers[i].onclick = closeAllSidebars;
	}
	
	function sidebarOpenClick() {
		if (!this.attributes["data-sidebar"])
			return;
		
		var sidebar = document.getElementById("sidebar-" 
				+ this.attributes["data-sidebar"].value);
		if (!sidebar)
			return;
		
		//TODO: Why tf doesn't the sidebar animate in???
		openSidebars.push(sidebar);
		sidebar.parentNode.classList.add("open");
		sidebar.classList.add("open");
	}
	
	function closeAllSidebars() {
		if (openSidebars.length < 1)
			return;
		
		//Select all open sidebars and remove open class
		for (var i = 0; i < openSidebars.length; i++)
			openSidebars[i].classList.remove("open");
		
		openSidebars = [];
		
		window.setTimeout(function() {
					var openSidebarContainers = document.getElementsByClassName("sidebar-container");
					for (var i = 0; i < openSidebarContainers.length; i++)
						openSidebarContainers[i].classList.remove("open");
				},
				sidebarAnimationTime);
	}
	
	function sidebarClose(sidebar) {
		if (sidebar == null || sidebar == document || sidebar == document.body)
			return;
		
		for (var i = 0; i < openSidebars.length; i++) {
			if (sidebar == openSidebars[i]) {
				sidebar.classList.remove("open");
				openSidebars.splice(i, 1);
				return;
			}
		}
		
		sidebarClose(node.parentNode);
	}
	
} (this, document));