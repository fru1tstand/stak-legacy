<?php
namespace stak\template\content\listpage;
require_once $_SERVER['DOCUMENT_ROOT'] . '/.site/php/stak/Autoload.php';
use stak\template\processors\ListProcessor;

$timescopeGroup = ListProcessor::getSingleListViewTimescopeGroup();
?>
<!-- Single list mode -->

<?php
// Each TimescopeContainer has a div
foreach ($timescopeGroup->getTimescopeContainers() as $tsContainer) {
	// Don't display if hidden
	if ($tsContainer->shouldHide())
		continue;

	$tsHash = $tsContainer->getTimescope()->getHash();
	$tsTodoCount = $tsContainer->countIncompleteTasks();
	$tsName = $tsContainer->getTimescope()->getName();

	// Timescope container html
	echo <<<HTML
        <input type="checkbox" class="controller timescope-controller" id="timescope-$tsHash" />
        <div class="tl-timescope">
            <div class="left">$tsTodoCount</div>
            <label class="name" for="timescope-$tsHash">$tsName</label>
        </div>
        <div> <!-- .timescope -->
HTML;

	// Tasks
	foreach ($tsContainer->getTasks() as $task) {
		if ($tsContainer->getTimescope()->hideCompleted() && $task->isComplete())
			continue;
		echo ListProcessor::getTaskHtml($task);
	}

	echo <<<HTML
		</div> <!-- .timescope -->
HTML;

} // End TimescopeGroup for
?>
