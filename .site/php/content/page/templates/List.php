<?php 
namespace content\page\templates;
require_once $_SERVER['DOCUMENT_ROOT'] . '/.site/php/utils/Autoload.php';
use content\IncludePage;
use content\page\generators\TasklistStyleGenerator;


//Make sure we're being loaded from a proper source
if (!IncludePage::validate()) return;

?>

<div class="split-left">

	<?php TasklistStyleGenerator::singleListMode(); ?>
	
	<div class="split-left-options-container">
		<div class="icon spin-container"><span class="fa fa-cog spin"></span></div>
		<div class="content">
		</div>
	</div> <!-- Options container -->
</div>

<div class="split-right">
	<div class="page-list">
		<div class="page-list-date">
			<div>
				<div class="date">March 28th, 2015</div>
				<div class="dow">Wednesday</div> <div class="time">12:00 PM</div>
			</div>
		</div>
		
		<div class="page-list-details">
			<!-- No Task -->
			<div class="hint hidden">No task selected. Click one to see details.</div>
			
			<!-- Task -->
			<div class="">
				<div class="title">Giant music project that comes close to exceeding two linel l</div>
				<div class="hierarchy">
					Project
					<i class="fa fa-caret-right"></i>
					Research
					<i class="fa fa-caret-right"></i>
					Websites
					<i class="fa fa-caret-right"></i>
					Reminder
				</div>
				<div class="tags">
					<ul>
						<li>School</li>
						<li>Project</li>
						<li>Important</li>
					</ul>
				</div>
				<div class="clear"></div>
				
				<div class="page-list-infobar">
					<div class="header">Due</div>
					<div class="date-container">
						<div class="date">March 29th, 2015</div>
						<div class="dow">Thursday</div> <div class="time">1:15 PM</div>
						<div class="clear"></div>
					</div>
					
					<div class="header">Completed</div>
					<div class="date-container">
						<div class="date">September 30th, 2015</div>
						<div class="dow">Friday</div> <div class="time">2:14 AM</div>
						<div class="clear"></div>
					</div>
					
					<div class="stats">
						<ul>
							<li>
								<span>Due In</span>
								<span>3 Days</span>
							</li>
							<li>
								<span>Created</span>
								<span>September 30th, 2015</span>
							</li>
							<li>
								<span>Type</span>
								<span>Reminder</span>
							</li>
							<li>
								<span title="Primary Tag">PTag</span>
								<span>VeryLongWordThatHappensToGoOffThePage</span>
							</li>
						</ul>
					</div>
				</div>
				
				<div class="task-more">
					<div class="subtitle">Description</div>
					<div class="block">
						<div class="hint hidden">Nothing to see here...</div>
						<div class="">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ut laoreet ex. Nunc eget nisi et nibh varius mollis. Nam tincidunt placerat ipsum, ac maximus ipsum ullamcorper et. Suspendisse pulvinar velit sed metus laoreet ultrices. Maecenas libero diam, volutpat nec vehicula vel, dignissim vel dui. Donec iaculis consectetur mi non efficitur. Mauris feugiat enim metus, quis fermentum erat imperdiet sed. Maecenas enim neque, volutpat in posuere ac, fermentum id eros. Proin vel arcu ut metus pretium auctor. Nullam erat mi, vestibulum vel suscipit ut, ornare ut sem. Maecenas hendrerit magna vitae fermentum hendrerit. Duis vel facilisis nisl. </div>
					</div>

					<div class="clear"></div>
				</div>
			</div>
		</div>
		
		<div class="page-list-push"></div>
	</div>
	<div class="page-list-footer">
		
	</div>
</div>