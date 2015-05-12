<?php
namespace stak\template\content\listpage;
require_once $_SERVER['DOCUMENT_ROOT'] . '/.site/php/stak/Autoload.php';
use stak\template\processors\ListProcessor;
use stak\foundation\Tag;

$tagGroup = ListProcessor::getSingleTagViewTagGroup();
?>
<!-- Single tag mode -->
<input type="radio" class="controller" name="tasklist-tags-controller" id="tags-master" checked="checked" />
<div>
    <?php
    foreach ($tagGroup->getTagContainers() as $tagContain) {
        $tagHash = $tagContain->getTag()->getHash();
        $tagName = htmlspecialchars($tagContain->getTag()->getName());
        $tagColor = $tagContain->getTag()->getValidCssColor();

        echo <<<HTML

    <div class="tl-tag">
        <div class="left"><div style="background-color: $tagColor;"></div></div>
        <label class="name" for="tag-$tagHash">$tagName</label>
    </div>

HTML;
    }
    ?>
</div>

<?php
// Each tag has a div
foreach ($tagGroup->getTagContainers() as $tagContain) {
    $tagHash = $tagContain->getTag()->getHash();
    $tagName = htmlspecialchars($tagContain->getTag()->getName());
	$tagColor = $tagContain->getTag()->getValidCssColor();

    echo <<<HTML

<input type="radio" class="controller" name="tasklist-tags-controller" id="tag-$tagHash" />
<div> <!-- .tag-container -->

    <div class="tl-tag">
        <div class="left"><div style="background-color: $tagColor;"></div></div>
        <label class="name" for="tags-master">$tagName</label>
    </div>

HTML;

    // Each timescope has a div
    foreach ($tagContain->getTimescopeGroup()->getTimescopeContainers() as $tsContainer) {
        // Hide if empty?
        if ($tsContainer->shouldHide())
			continue;

        $tsHash = ListProcessor::getTimescopeTagHash($tsContainer->getTimescope(),
                        $tagContain->getTag());
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

        // Each task then has its own div
        foreach ($tsContainer->getTasks() as $task) {
            // Hide completed tasks?
            if ($tsContainer->getTimescope()->hideCompleted() && $task->isComplete())
                continue;
            echo ListProcessor::getTaskHtml($task);
        } // End tasks for (all tasks are output by here)

        echo "</div> <!-- .timescope -->";
    } // End timescope for (all timescopes are output by here)

    echo "</div> <!-- .tag-container -->";
} // End tagGroup for (all tags are output by here)
?>
