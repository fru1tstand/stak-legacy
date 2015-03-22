<?php
namespace css;

//Some prep
header("content-type: text/css");

//Set default colors
$globalLogoDefault = "#99F";
$globalLogoHover = "#66C";
$globalMenuBarBorder = "#CCC";
$globalMenuTabBorder = "#CCC";

$windowBackground = "#F9F9F9";
$windowText = "inherit";

$menuTab = "#99F";
$menuTabHover = "#66C";
$menuTabShadowHover = "#00F";
$menuTabShadowActive = "#0F0";

$sidebarBackground = "#EEE";
$sidebarLinkBackgroundDefault = "#FFF";
$sidebarLinkBackgroundHover = "#F9F9F9";
$sidebarLinkDefault = "#99F";
$sidebarLinkHover = "#66C";

//Anything before
echo <<<CSS
@charset "UTF-8";
CSS;

echo <<<template

#global-menu-bar {
	border-color: $globalMenuBarBorder;
}
#global-logo .bar-link:link, #global-logo .bar-link:visited {
	color: $globalLogoDefault;
}
#global-logo .bar-link:hover, #global-logo .bar-link:active {
	color: $globalLogoHover;
}
#global-tabs ul, #global-tabs li {
	border-color: $globalMenuTabBorder;
}

#window-container > div {
	background-color: $windowBackground;
	color: $windowText;
}

.tabs {
	color: $menuTab;
}
.tabs li:hover {
	color: $menuTabHover;
	box-shadow: 0px -10px 30px -30px $menuTabShadowHover inset;
}
.tabs li.active {
	box-shadow: 0px -10px 30px -30px $menuTabShadowActive inset;
}

.sidebar {
	background-color: $sidebarBackground;
}
.sidebar a:link,
.sidebar a:visited {
	background-color: $sidebarLinkBackgroundDefault;
	color: $sidebarLinkDefault;
}
.sidebar a:hover,
.sidebar a:active {
	background-color: $sidebarLinkBackgroundHover;
	color: $sidebarLinkHover;
}

template;

echo <<<pagetodo

.list-fullscreen {
	border-color: #FFF;
}

pagetodo;
?>

