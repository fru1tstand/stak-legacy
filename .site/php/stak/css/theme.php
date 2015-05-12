<?php
namespace stak\content\css;

header("content-type: text/css");

$txt = "#2C3E50";
$bg = "#FFF";
$bgAlt = "#F9F9F9";

$hiBgActive = "#2C3E50";
$hiTxtActive = "#18BC9C";
$hiBg = "#2C3E50";
$hiTxt = "#FFF";

$invBg = "#149C82";
$invTxt = "#FFF";
$invBgActive = "#149C82";
$invTxtActive = "#2C3E50";
$invBgLite = "#69D3BE";
$invTxtLite = "2C3E50";

$blendBg = $bg;
$blendBgAlt = $bgAlt;
$blendTxt = $txt;
$blendBgActive = "#ECF0F1";
$blendTxtActive = "#18BC9C";
$blendBgDisabled = $bg;
$blendTxtDisabled = "#B4BCC2";

$primBg = "#2C3E50";
$primTxt = "#FFF";
$primBgActive = "#1A242F";
$primTxtActive = "#FFF";
$primBgDisabled = "#76818D";
$primTxtDisabled = "#FFF";

$succBg = "#18BC9C";
$succTxt = "#FFF";
$succBgActive = "#128F76";
$succTxtActive = "#FFF";
$succBgDisabled = "#69D3BE";
$succTxtDisabled = "#FFF";

$defBg = "#95A5A6";
$defTxt = "#FFF";
$defBgActive = "#798D8F";
$defTxtActive = "#FFF";
$defBgDisabled = "#BAC4C5";
$defTxtDisabled = "#FFF";

$infoBg = "#3498DB";
$infoTxt = "#FFF";
$infoBgActive = "#217DBB";
$infoTxtActive = "#FFF";
$infoBgDisabled = "#7BBCE7";
$infoTxtDisabled = "#FFF";

$warnBg = "#F39C12";
$warnTxt = "#FFF";
$warnBgActive = "#C87F0A";
$warnTxtActive = "#FFF";
$warnBgDisabled = "#F7BE65";
$warnTxtDisabled = "#FFF";

$dangBg = "#E74C3C";
$dangTxt = "#FFF";
$dangBgActive = "#D62C1A";
$dangTxtActive = "#FFF";
$dangBgDisabled = "#EF8A80";
$dangTxtDisabled = "#FFF";

// Global
echo <<<HTML
body {
    background-color: $bg;
    color: $txt;
}
HTML;

// Nav
echo <<<HTML
.nav,
.nav a:link,
.nav a:visited {
    background-color: $bgAlt;
    color: $txt;
}
.nav a.active {
    background-color: $invBgLite;
    color: $invTxtLite;
}

.nav:hover,
.nav:hover a:link,
.nav:hover a:visited {
    background-color: $hiBg;
    color: $hiTxt;
}

.nav:hover a:hover,
.nav:hover a:active,
.nav label:hover {
    background-color: $hiBgActive;
    color: $hiTxtActive;
}

.nav:hover a.active {
    background-color: $primBgActive;
    color: $primTxtActive;
}
HTML;

// Sidebar
echo <<<HTML
.sidebar {
    background-color: $bg;
    color: $txt;
}
.sidebar-logo {
    background-color: $invBg;
    color: $invTxt;
}
.sidebar-links a:link,
.sidebar-links a:visited {
    background-color: $blendBg;
    color: $blendTxt;
}
.sidebar-links a:hover,
.sidebar-links a:active,
.sidebar hr {
    background-color: $blendBgActive;
    color: $blendTxtActive;
}
HTML;

// Tasklist/Listpage
echo <<<HTML
.tl-tag,
.tasklist {
    background-color: $blendBg;
    color: $blendTxt;
}
.tl-tag:hover {
    background-color: $blendBgActive;
    color: $blendTxtActive;
}

.tl-task {
    background-color: $bg;
    color: $txt;
}
.tl-task.complete {
    background-color: $blendBgDisabled;
    color: $blendTxtDisabled;
}

.tl-task:hover,
.tl-quick-edit a:link,
.tl-quick-edit a:visited {
    background-color: $blendBgActive;
    color: $blendTxtActive;
}

.tl-quick-edit a:hover,
.tl-quick-edit a:active,
.tl-task .title:hover {
    background-color: $blendBgAlt;
    color: $blendTxt;
}

.tl-timescope {
    background-color: $blendBg;
    color: $blendTxt;
}
.tl-timescope:hover,
.tasklist .controller[type=checkbox]:checked + .tl-timescope:hover{
    background-color: $blendBgActive;
    color: $blendTxtActive;
}
.tasklist .controller[type=checkbox]:checked + .tl-timescope {
    background-color: $blendBgDisabled;
    color: $blendTxtDisabled;
}

HTML;
