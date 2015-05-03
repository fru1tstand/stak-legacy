<?php
namespace stak\content\css;

header("content-type: text/css");

$defaultTxt = "#2C3E50";
$defaultBg = "#FFF";


$btnBg = "#95A5A6";
$btnTxt = "#2C3E50";
$btnBgActive = "#798D8F";
$btnTxtActive = "#FFF";

$invBg = "#149C82";
$invTxt =  "#FFF";
$invBgDisabled = "#18BC9C";
$invTxtDisabled = "#FFF";
$invBgDisabledLight = "#3BE6C4";
$invTxtDisabledLight = "#FFF";
$invBgActive = "#0F7864";
$invTxtActive = "#FFF";

$hiBgActive = "#1A242F";
$hiTxtActive = "#FFF";
$hiBg = "#2C3E50";
$hiTxt = "#FFF";

// Global
echo <<<HTML
body {
    background-color: $defaultBg;
    color: $defaultTxt;
}
HTML;

// Nav
echo <<<HTML
.nav,
.nav a:link,
.nav a:visited {
    background-color: $defaultBg;
    color: $defaultTxt;
}
.nav a.active {
    background-color: $invBgDisabledLight;
    color: $invTxtDisabledLight;
}

.nav:hover,
.nav:hover a {
    background-color: $hiBg;
    color: $hiTxt;
}
.nav:hover a.active {
    background-color: $hiBgActive;
    color: $hiTxtActive;
}

.nav a:hover,
.nav label:hover {
    background-color: $hiBgActive;
    color: $hiTxtActive;
}
HTML;

// Sidebar
echo <<<HTML
.sidebar {
    background-color: $defaultBg;
    color: $defaultTxt;
}

.sidebar-logo {
    background-color: $invBg;
    color: $invTxt;
}

.sidebar-links a:link,
.sidebar-links a:visited {
    background-color: transparent;
    border-color: $btnBg;
    color: $btnTxt;
}
.sidebar-links a:hover,
.sidebar-links a:active {
    background-color: $btnBgActive;
    color: $btnTxtActive;
}
hr {
    background-color: $btnBg;
}
HTML;

// Tasklist/Listpage
echo <<<HTML
.tl-task,
.tl-task .left,
.tl-tasl .info {
    background-color: $defaultBg;
    color: $defaultTxt;
}

.tl-quick-edit a:link,
.tl-quick-edit a:visited {
    background-color: $defaultBg;
    color: $defaultTxt;
}
.tl-quick-edit:hover a {
    background-color: $hiBg;
    color: $hiTxt;
}
.tl-quick-edit a:hover,
.tl-quick-edit a:active {
    background-color: $hiBgActive;
    color: $hiTxtActive;
}
HTML;
