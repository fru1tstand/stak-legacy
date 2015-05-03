<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/.site/php/stak/Autoload.php';
use stak\template\processors\IndexProcessor;
use common\base\Response;

//TODO: Handle errors properly
$page = IndexProcessor::getRequestedPage();
$response = null;
Response::getInstance($response, "Index Root");
if (!$page::canLoad($response))
	print_r($response);
$includeContent = $page::getContentLocation();
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Fru1tMe - Stak: The Task Whatcham'callit</title>

    <!-- IT LOOKS A LOT LIKE BOOTSTRAP DOESN'T IT??? HAH. WELL IT'S NOT. I did, however... "borrow" some styles from it though. -->
    <link href="/.site/css/compiled/styles.css" rel="stylesheet" type="text/css" />
    <link href="/.site/css/compiled/theme-mirror.php" rel="stylesheet" type="text/css" />
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="nav">
    <div class="container">
        <div class="left">
            <label for="sidebar-controller"><i class="fa fa-bars"></i></label>
            <div class="title">Hello</div>
        </div>
        <div class="right">
            <ul class="nav-tabs">
                <!--
                "White-space independent" my ass.
                See http://fru1t.me/code/inline-block-whitespace for details
                -->
                <li><a href="#" class="active">List</a></li
                ><li><a href="#">Calendar</a></li>
            </ul>
        </div>
        <div class="float-clear"></div>
    </div>
</div>

<!-- Page CONTENTNTNTNT! -->
<?php
/** @noinspection PhpIncludeInspection */
include $includeContent;
?>


<input type="checkbox" class="controller" id="sidebar-controller" />
<div class="sidebar">
    <div class="sidebar-logo">
        <div class="title">Stak: The Task Whatcham'callit</div>
        <div class="subtitle">By Fru1tStudios</div>
    </div>

    <div class="sidebar-links">
        <ul>
            <li><a href="#">List</a></li>
            <li><a href="#">Weekly</a></li>
            <li><a href="#">Monthly</a></li>
            <li><hr /></li>
            <li><a href="#">Item 3</a></li>
            <li><a href="#">Item 4</a></li>
            <li><a href="#">Item 5</a></li>
            <li><a href="#">Item 6</a></li>
            <li><a href="#">Item 7</a></li>
            <li><a href="#">Item 8</a></li>
        </ul>
    </div>
</div>
<label for="sidebar-controller" class="sidebar-closer"></label>

</body>
</html>