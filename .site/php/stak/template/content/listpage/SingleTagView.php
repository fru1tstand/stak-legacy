<?php
namespace stak\template\content\listpage;
require_once $_SERVER['DOCUMENT_ROOT'] . '/.site/php/stak/Autoload.php';
use stak\template\processors\ListProcessor;
use stak\foundation\Tag;

$tagGroup = ListProcessor::getTagGroup();
?>
<!-- Single tag mode -->
<input type="radio" class="controller" name="tasklist-tags-controller" id="tags-master" checked="checked" />
<div>
    <?php
    foreach ($tagGroup->getTagContainers() as $tagContain) {
        $tagHash = $tagContain->getTag()->getHash();
        $tagName = htmlspecialchars($tagContain->getTag()->getName());
        $tagColor = "#" . $tagContain->getTag()->getColor();

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
    $tagColor = "#" . $tagContain->getTag()->getColor();

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
        if ($tsContainer->getTimescope()->hideIfEmpty()) {
            // No tasks at all
            if (count($tsContainer->getTasks()) == 0)
                continue;

            // Hidden complete tasks and all tasks are complete
            if ($tsContainer->getTimescope()->hideCompleted()
                && $tsContainer->countIncompleteTasks() == 0)
                continue;
        }

        $tsHash = ListProcessor::getTimescopeTagHash($tsContainer->getTimescope(),
                        $tagContain->getTag());
        $tsTodoCount = $tsContainer->countIncompleteTasks();
        $tsName = $tsContainer->getTimescope()->getName();

        // Timescope container html
        echo <<<HTML
        <div class="tl-timescope">
            <div class="left">$tsTodoCount</div>
            <label class="name" for="timescope-$tsHash">$tsName</label>
        </div>
        <input type="checkbox" class="controller" id="timescope-$tsHash" />
        <div> <!-- .timescope -->
HTML;

        // Each task then has its own div
        foreach ($tsContainer->getTasks() as $task) {
            // Hide completed tasks?
            if ($tsContainer->getTimescope()->hideCompleted() && $task->isComplete())
                continue;

            $taskColor = "#" . $task->getPrimaryTag()->getColor();
            $taskTitle = htmlspecialchars($task->getTitle());
            $taskHash = $task->getHash();

            // Times (x) to "uncomplete". Check to "complete".
            $quickEditSymbol = (($task->isComplete()) ? "times" : "check");

            $taskCompleteClass = (($task->isComplete()) ? "complete" : "");

            echo <<<HTML
            <div class="tl-task $taskCompleteClass">
                <div class="left">
                    <div class="tl-quick-edit" style="border-color: $taskColor;">
                        <a href="#"><i class="fa fa-$quickEditSymbol"></i></a>
                        <a href="#"><i class="fa fa-pencil"></i></a>
                        <a href="#"><i class="fa fa-trash"></i></a>
                    </div>
                </div>
                <label class="title" for="task-$taskHash">$taskTitle</label>
            </div>
HTML;
        } // End tasks for (all tasks are output by here)
        echo "</div> <!-- .timescope -->";
    } // End timescope for (all timescopes are output by here)
    echo "</div> <!-- .tag-container -->";
} // End tagGroup for (all tags are output by here)
?>
