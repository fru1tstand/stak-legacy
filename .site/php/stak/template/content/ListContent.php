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
		<div class="lc-overview">
			<div class="date">Wednesday, May 13th, 2015</div>

			<ul class="lc-timescope"><!-- TODO add .no-js to classlist -->
				<li><div class="end-spacer"></div></li>

				<li>
					<fieldset>
						<legend>(Just Things To Do)</legend>
						<div class="total">3</div>
						<div class="tag" style="border-color: #99F">3</div>
					</fieldset>
				</li>
				<li>
					<fieldset>
						<legend>Overdue</legend>
						<div class="total">0<div class="right"><i class="fa fa-check"></i></div></div>
					</fieldset>
				</li>
				<li>
					<fieldset>
						<legend>Today</legend>
						<div class="total">7</div>
						<div class="tag" style="border-color: #99F">0</div>
						<div class="tag" style="border-color: #F99">1</div>
						<div class="tag" style="border-color: #FF9">2</div>
					</fieldset>
				</li>
				<li>
					<fieldset>
						<legend>This week that is really long and will flow off the edge of the page</legend>
						<div class="total">9999</div>
						<div class="tag" style="border-color: #99F">9999</div>
					</fieldset>
				</li>
				<li>
					<fieldset>
						<legend>Overdue</legend>
						<div class="total">99999989999889</div>
						<div class="tag" style="border-color: #99F">9999</div>
						<div class="tag" style="border-color: #F99">9999</div>
						<div class="tag" style="border-color: #FF9">342</div>
						<div class="tag" style="border-color: #F99">9999</div>
						<div class="tag" style="border-color: #FF9">342</div>

					</fieldset>
				</li>
				<li>
					<fieldset>
						<legend>Everything else</legend>
						<div class="total">7</div>
						<div class="tag" style="border-color: #99F">9999</div>
						<div class="tag" style="border-color: #F99">9999</div>
						<div class="tag" style="border-color: #FF9">342</div>
					</fieldset>
				</li>

				<li><div class="end-spacer"></div></li>
			</ul>

			<div class="lc-statistics">
				<div class="left">
					<span class="title bar">Tasks per Day</span>
					<span class="value">4.6</span>
				</div>
			</div>
			<div class="activity">

				<div class="graph"></div>
				<ul>

				</ul>
			</div>
		</div> <!-- .lc-overview -->

	</div> <!-- .listpage-content -->
</div>
