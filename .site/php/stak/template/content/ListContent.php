<?php
namespace stak\template\content;
use stak\template\processors\ListProcessor;

require_once $_SERVER['DOCUMENT_ROOT'] . '/.site/php/stak/Autoload.php';
?>

<div class="container full-height nav-push">
    <div class="tasklist">
        <?php ListProcessor::showRequestedTasklistView(); ?>
    </div>
    <div class="listpage-content">
        asdf
    </div>
</div>
