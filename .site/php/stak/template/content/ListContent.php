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
        <input type="radio" class="controller" checked="checked" name="task" />
		<div class="active">
			<div class="title">mmmm</div>
			<div class="content">

				asdfasdf
				asdfa
			</div>
		</div>
    </div>
</div>
