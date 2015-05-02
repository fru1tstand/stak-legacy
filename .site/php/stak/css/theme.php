<?php
namespace stak\content\css;

header("content-type: text/css");

$defaultTxt = "#2C3E50";
$defaultBg = "#FFF";

$btnBgActive = "#798D8F";
$btnBg = "#95A5A6";
$btnTxt = "#FFF";

$invBg = "#149C82";
$invBgDisabled = "#18BC9C";
$invBgDisabledLight = "#3BE6C4";
$invBgActive = "#0F7864";
$invTxt =  "#FFF";

$hiBgActive = "#1A242F";
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
}

.nav:hover,
.nav:hover a {
    background-color: $hiBg;
    color: $hiTxt;
}
.nav:hover a.active {
    background-color: $hiBgActive;
}

.nav a:hover {
    background-color: $hiBgActive;
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
    color: $defaultTxt;
}
.sidebar-links a:hover,
.sidebar-links a:active {
    background-color: $btnBgActive;
    color: $btnTxt;
}
hr {
    background-color: $btnBg;
}
HTML;
