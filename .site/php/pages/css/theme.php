<?php
namespace css;

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

$tasklistDueinFuture = "#0A0";
$tasklistDueinPast = "#F00";
$tasklistDueinFarFuture = "#0AA";
$tasklistQuickEdit = "#99F";
$tasklistQuickEditBackground = "transparent";
$tasklistQuickEditBackgroundHover = "#EEE";

//Anything before
echo <<<CSS
@charset "UTF-8";
CSS;

/**
 * Template
 */
echo <<<template
#window-container > div {
	background-color: $windowBackground;
	color: $windowText;
}
template;

/**
 * Tabs
 */
echo <<<tabs
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
tabs;

/**
 * Sidebar
 */
echo <<<sidebar
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
sidebar;

/**
 * Global Header
 */
echo <<<globalheader
#global-menu-bar {
	border-color: $globalMenuBarBorder;
}
#global-logo .bar-link:link,
#global-logo .bar-link:visited {
	color: $globalLogoDefault;
}
#global-logo .bar-link:hover,
#global-logo .bar-link:active {
	color: $globalLogoHover;
}
#global-tabs ul,
#global-tabs li {
	border-color: $globalMenuTabBorder;
}
globalheader;

/**
 * Task List
 */
echo <<<tasklist
.tasklist li {
	border-color: #999;
}
.tasklist .future {
	color: $tasklistDueinFuture;
}
.tasklist .past {
	color: $tasklistDueinPast;
}
.tasklist .far-future {
	color: $tasklistDueinFarFuture;
}
.tasklist .quick-edit > div > div:before {
	background-color: $tasklistQuickEditBackground;
	color: $tasklistQuickEdit;
}
.tasklist .quick-edit > div > div:hover:before {
	background-color: $tasklistQuickEditBackgroundHover;
}

tasklist;

?>
