//Window
(function (window, document, undefined) {
	var isWindowOpen = false;
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
			windowCloseNodes[i].onclick = function() {
				windowClose(this);
			}
		}
	}
	
	/**
	 * Simply opens the one that it says it opens.
	 */
	function windowOpenOnClick() {
		if (!this.attributes["data-window"])
			return;
		
		//Check for pointer to window
		var hoverWindow = document.getElementById("window-" 
				+ this.attributes["data-window"].value);
		if (!hoverWindow)
			return;
		
		//Close opened windows
		var openWindows = document.querySelectorAll(".window-container>div.open");
		for (var i = 0; i < openWindows.length; i++)
			windowClose(openWindows[i]);
		
		//un-activate other tabs
		var openTabs = document.querySelectorAll(".window-open.active");
		for (var i = 0; i < openTabs.length; i++)
			openTabs[i].classList.remove("active");
		
		//Animate in window, delay if one is open
		if (isWindowOpen)
			setTimeout(function() { openWindow(hoverWindow); }, windowAnimationTime);
		else
			openWindow(hoverWindow);
		
		//Actiate tab
		this.classList.add("active");
	}
	
	function openWindow(window) {
		window.classList.add("open");
		isWindowOpen = true;
	}
	
	/**
	 * Recursively checks parent if its a hover-window and if so, closes it.
	 */
	function windowClose(node) {
		if (node == null || node == document || node == document.body)
			return;
		
		if (node.classList.contains("open")) {
			node.classList.remove("open");
			//Delay the close flag because javascript.
			setTimeout(function() { isWindowOpen = false; },
					windowAnimationTime / 2);
			return;
		}
		
		windowClose(node.parentNode);
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