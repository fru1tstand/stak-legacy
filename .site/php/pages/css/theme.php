<?php
namespace css;

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

$tasklistTaskBackground = "transparent";
$tasklistTaskHoverBackground = "#EEE";
$tasklistTaskTitle = "#000";
$tasklistTaskSubtitle = "#000";
$tasklistBorder = "#CCC";
$tasklistDueinFuture = "#0A0";
$tasklistDueinPast = "#F00";
$tasklistDueinFarFuture = "#99F";
$tasklistQuickEdit = "#99F";
$tasklistQuickEditBackground = "transparent";
$tasklistQuickEditBackgroundHover = "#EEE";
$tasklistLabel = "#333";
$tasklistLabelBackground = "#EEE";
$tasklistCompleteTitle = "#999";

$splitScreenOptionsBackground = "#FFF";
$splitScreenOptionsBorder = "#CCC";
$splitScreenOptionsTitle = "#99F";
$splitScreenOptionsLabel = "#999";
$splitScreenOptionsLabelHover = "#333";
$splitScreenOptionsLabelHoverBackground = "#EEE";
$splitScreenOptionsGroupBackground = "transparent";
$splitScreenOptionsChecked = "#333";
$splitScreenOptionsCheckedBorder = "#333";
$splitScreenOptionsCheckedBackground = "#F6F6F6";
$splitScreenOptionsButtonBackground = "transparent";
$splitScreenOptionsButton = "#99F";
$splitScreenOptionsButtonHoverBackground = "#EEE";

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
echo <<<tasklist
.tasklist li {
	border-color: $tasklistBorder;
}
.tasklist .task {
	background-color: $tasklistTaskBackground;
}
.tasklist .task:hover {
	background-color: $tasklistTaskHoverBackground;
}
.tasklist .title {
	color: $tasklistTaskTitle;
}
.tasklist .subtitle {
	color: $tasklistTaskSubtitle;
}
.tasklist .quick-edit a {
	background-color: $tasklistQuickEditBackground;
	color: $tasklistQuickEdit;
}
.tasklist .quick-edit a:hover {
	background-color: $tasklistQuickEditBackgroundHover;
}
.tasklist .label {
	color: $tasklistLabel;
	background-color: $tasklistLabelBackground;
}

.tasklist .complete .title {
	color: $tasklistCompleteTitle;
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
.split-left .options .content .title {
	color: $splitScreenOptionsTitle;
}
.split-left .options .content label {
	color: $splitScreenOptionsLabel;
}
.split-left .options .content form > ul > li {
	background-color: $splitScreenOptionsGroupBackground;
}
.split-left .options .content input:checked + label {
	color: $splitScreenOptionsChecked;
	border-color: $splitScreenOptionsCheckedBorder;
	background-color: $splitScreenOptionsCheckedBackground;
}
.split-left .options .content label:hover,
.split-left .options .content input:checked + label:hover {
	background-color: $splitScreenOptionsLabelHoverBackground;
	color: $splitScreenOptionsLabelHover;
}
.split-left .options .content .buttons button {
	background-color: $splitScreenOptionsButtonBackground;
	color: $splitScreenOptionsButton;
}
.split-left .options .content .buttons button:hover {
	background-color: $splitScreenOptionsButtonHoverBackground;
}
split;

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
