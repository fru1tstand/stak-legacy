<?php
namespace stak\content\css;

header("content-type: text/css");

//Set default colors
$bodyBackground = "#CCC";
$bodyBorder = "#999";

$globalLogoDefault = "#99F";
$globalLogoHover = "#66C";
$globalMenuBarBorder = "#CCC";
$globalMenuTabBorder = "#CCC";
$globalMenuBackground = "#FFF";

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

$listpageDate = "#999";
$listpageDateActive = "#000";
$listpageDetailsBorder = "#999";
$listpageDetailsBackground = "#F0F0F0";
$listpageHierarchy = "#333";
$listpageHint = "#999";
$listpageTagsBackground = "#333";
$listpageTags = "#F0F0F0";
$listpageDetailsBorder = "#CCC";

$listpageInfobarBackground = "#FFF";
$listpageInfobarHeaderBackground = "#CCC";
$listpageInfobarHeader = "#000";
$listpageInfobarStatsBackground = "#F0F0F0";
$listpageInfobarStatsBorder = "#FFF";
$listpageInfobarStats = "#000";
$listpageInfobarStatsSeparator = "#CCC";

//Anything before
echo <<<CSS
@charset "UTF-8";
CSS;

/**
 * Template
 */
echo <<<template
body {
	border-color: $bodyBorder;
	background-color: $bodyBackground;
}
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
	background-color: $globalMenuBackground;
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
$tasklistTagText = "#000";
$tasklistTagBackground = "transparent";
$tasklistTagTextHover = "#000";
$tasklistTagBackgroundHover = "#E0E0E0";

$tasklistTimescopeText = "#000";
$tasklistTimescopeBackground = "#F0F0F0";
$tasklistTimescopeTextHover = "#000";
$tasklistTimescopeBackgroundHover = "#E0E0E0";

$tasklistTaskText = "#000";
$tasklistTaskBackground = "transparent";
$tasklistTaskTextHover = "#000";
$tasklistTaskBackgroundHover = "#E0E0E0";

$tasklistTaskCompleteText = "#999";
$tasklistTaskCompleteBackground = "#F3F3F3";
$tasklistTaskCompleteTextHover = "#999";
$tasklistTaskCompleteBackgroundHover = "#E0E0E0";

$tasklistQuickeditIcon = "#99F";
$tasklistQuickeditBackground = "#transparent";
$tasklistQuickeditIconHover = "#99F";
$tasklistQuickeditBackgroundHover = "#FFF";
echo <<<tasklist
.tasklist-tag {
	color: $tasklistTagText;
	background-color: $tasklistTagBackground;
}
.tasklist-tag:hover {
	color: $tasklistTagTextHover;
	background-color: $tasklistTagBackgroundHover;
}
.tasklist-timescope {
	color: $tasklistTimescopeText;
	background-color: $tasklistTimescopeBackground;
}
.tasklist-timescope:hover {
	color: $tasklistTimescopeTextHover;
	background-color: $tasklistTimescopeBackgroundHover;
}
.tasklist-task {
	color: $tasklistTaskText;
	background-color: $tasklistTaskBackground;
}
.tasklist-task.complete {
	color: $tasklistTaskCompleteText;
	background-color: $tasklistTaskCompleteBackground;
}
.tasklist-task:hover {
	color: $tasklistTaskTextHover;
	background-color: $tasklistTaskBackgroundHover;
}
.tasklist-task.complete:hover {
	color: $tasklistTaskCompleteTextHover;
	background-color: $tasklistTaskCompleteBackgroundHover;
}
.tasklist-quickedit a:link,
.tasklist-quickedit a:visited {
	color: $tasklistQuickeditIcon;
	background-color: $tasklistQuickeditBackground;
}
.tasklist-quickedit a:hover,
.tasklist-quickedit a:active {
	color: $tasklistQuickeditIconHover;
	background-color: $tasklistQuickeditBackgroundHover;
}
tasklist;

/**
 * List page for tasks
 */
echo <<<listpage
.page-list-date,
.page-list-details {
	border-color: $listpageDetailsBorder;
}
.page-list-date:hover,
.page-list-date.active {
	color: $listpageDateActive;
}
.page-list-date {
	color: $listpageDate;
}
.page-list-details {
	background-color: $listpageDetailsBackground;
}
.page-list-details .hierarchy {
	color: $listpageHierarchy;
}
.page-list-details .hint {
	color: $listpageHint;
}
.page-list-details .tags li {
	background-color: $listpageTagsBackground;
	color: $listpageTags;
}
.page-list-details .block {
	border-color: $listpageDetailsBorder;
}

.page-list-infobar {
	background-color: $listpageInfobarBackground;
}
.page-list-infobar .header {
	background-color: $listpageInfobarHeaderBackground;
	color: $listpageInfobarHeader;
}
.page-list-infobar .stats {
	border-color: $listpageInfobarStatsBorder;
	background-color: $listpageInfobarStatsBackground;
	color: $listpageInfobarStats;
}
.page-list-infobar .stats li:nth-child(n+2) {
	border-color: $listpageInfobarStatsSeparator;
}
listpage;

?>
