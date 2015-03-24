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

$tasklistTask = "#000";
$tasklistBorder = "#CCC";
$tasklistDueinFuture = "#0A0";
$tasklistDueinPast = "#F00";
$tasklistDueinFarFuture = "#99F";
$tasklistQuickEdit = "#99F";
$tasklistQuickEditBackground = "transparent";
$tasklistQuickEditBackgroundHover = "#EEE";

$tasklistCompletedDuein = "#999";
$tasklistCompletedTask = "#999";
$tasklistCompletedBackground = "#EEE";
$tasklistCompletedQuickEditBackground = "transparent";
$tasklistCompletedQuickEditBackgroundHover = "#FFF";

$splitScreenOptionsBackground = "#FFF";
$splitScreenOptionsBorder = "#CCC";

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
	border-color: $tasklistBorder;
}
.tasklist .task a {
	color: $tasklistTask;
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
.tasklist .quick-edit > div > a {
	background-color: $tasklistQuickEditBackground;
	color: $tasklistQuickEdit;
}
.tasklist .quick-edit > div > a:hover {
	background-color: $tasklistQuickEditBackgroundHover;
}

.tasklist.completed {
	background-color: $tasklistCompletedBackground;
	border-color: $tasklistBorder;
}
.tasklist.completed .task a {
	color: $tasklistCompletedTask;
}
.tasklist.completed .complete {
	color: $tasklistCompletedDuein;
}
.tasklist.completed .quick-edit > div > a {
	background-color: $tasklistCompletedQuickEditBackground;
}
.tasklist.completed .quick-edit > div > a:hover {
	background-color: $tasklistCompletedQuickEditBackgroundHover;
}
tasklist;

/**
 * Split Screen
 */
echo <<<split
.split-left .options {
	background-color: $splitScreenOptionsBackground;
	border-color: $splitScreenOptionsBorder;
}
split;
?>
