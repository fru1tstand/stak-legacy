<?php
namespace stak\template\content\listpage;
require_once $_SERVER['DOCUMENT_ROOT'] . '/.site/php/stak/Autoload.php';
use stak\template\processors\ListProcessor;
use stak\foundation\Tag;

$tagGroup = ListProcessor::getTagGroup();
?>
<!-- Single tag mode -->
<div class="tasklist-viewstyle-container">
	<input type="radio" name="tasklist-tag-select" class="tasklist-tag-option-controller" id="tc-master" checked="checked" />
	<div class="tasklist-tag-container">
		<?php
		foreach ($tagGroup->getTagContainers() as $tagContain) {
			$tagHash = $tagContain->getTag()->getHash();
			$tagName = htmlspecialchars($tagContain->getTag()->getName());
			$tagColor = $tagContain->getTag()->getColor();

			echo <<<HTML

		<label class="tasklist-tag-container-toggle" for="tc-$tagHash">
			<span class="tasklist-tag">
				<span class="tag" style="background-color: #$tagColor"></span>
				<span class="spacer"></span>
				<span class="title">$tagName</span>
			</span>
		</label>

HTML;
		}
		?>
	</div>

	<?php
	foreach ($tagGroup->getTagContainers() as $tagContain) {
		$tagHash = $tagContain->getTag()->getHash();
		$tagName = htmlspecialchars($tagContain->getTag()->getName());
		$tagColor = $tagContain->getTag()->getColor();
        $slideFrame = 0;

		// Tag container html
		echo <<<HTML

	<input type="radio" name="tasklist-tag-select" class="tasklist-tag-option-controller" id="tc-$tagHash" />
	<div class="tasklist-tag-container">
		<label class="tasklist-tag-container-toggle slide-in slide-frame-0" for="tc-master">
				<span class="tasklist-tag">
					<span class="tag" style="background-color: #$tagColor;"></span>
					<span class="options-toggle"></span>
					<span class="title">$tagName</span>
				</span>
		</label>
		<div class="tasklist-timescope-group">

HTML;

		// timescope group html
		foreach ($tagContain->getTimescopeGroup()->getTimescopeContainers() as $tsContain) {
			$tsContainHash = ListProcessor::getTimescopeTagHash($tsContain->getTimescope(),
							$tagContain->getTag());
            $tsContainIncompleteCount = $tsContain->countIncompleteTasks();
            $tsContainName = $tsContain->getTimescope()->getName();
            $slideFrame++;

			// Timescope container html
			echo <<<HTML

			<div class="tasklist-timescope-container">
				<!-- Controls this timescope for the tag -->
				<input type="checkbox" class="tasklist-timescope-container-controller" id="tsc-$tsContainHash" />

				<label class="tasklist-timescope-container-toggle slide-in slide-frame-$slideFrame" for="tsc-$tsContainHash">
						<span class="tasklist-timescope">
							<span class="count">$tsContainIncompleteCount</span>
							<span class="visibility-toggle"></span>
							<span class="name">$tsContainName</span>
						</span>
				</label>

HTML;

            // Task html
            foreach ($tsContain->getTasks() as $task) {
                $taskColor = $task->getPrimaryTag()->getColor();
                $taskTitle = htmlspecialchars($task->getTitle());
                $taskHierarchy = null;
                if ($task->hasParent())
                    $taskHierarchy = $task->getParent()->getTitle();

                echo <<<HTML

                <div class="tasklist-task">
					<div class="tag" style="border-color: #$taskColor"></div>
					<div class="tasklist-quickedit">

HTML;
                if (!$task->isComplete())
                    echo '<a href="#"><i class="complete"></i></a>';
                else
                    echo '<a href="#"><i class="uncomplete"></i></a>';

                echo <<<HTML

						<a href="#"><i class="edit"></i></a>
						<a href="#"><i class="delete"></i></a>
					</div>
					<label class="tasklist-task-toggle">
						<span class="middler"></span>
							<span class="middle">
								<span class="title">$taskTitle</span>

HTML;
                if ($task->hasParent())
                    echo '<span class="hierarchy">', $taskHierarchy, '</span>';

                echo <<<HTML

							</span>
					</label>
				</div><!-- .tasklist-task -->

HTML;

            }

			// End timescope container html
			echo <<<HTML

			</div> <!-- .tasklist-timescope-container -->

HTML;
		}

		// End tag container html
		echo <<<HTML

		</div> <!-- .tasklist-timescope-group -->
	</div> <!-- .tasklist-tag-container -->

HTML;


	}
	?>

</div> <!-- .tasklist-viewstyle-container -->