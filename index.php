<!DOCTYPE html>

<html lang="en">
	<head>
		<title>Fru1tMe - Homework Thing</title>
		<meta charset="UTF-8" />
		<link href="/.site/css/compiled/global.css" rel="stylesheet" type="text/css">
		<link href="/.site/php/css/theme.php" rel="stylesheet" type="text/css">
		
<?php include(".site/php/ascii-art.php"); ?>

	</head>
	
	<body>
		<div id="global-menu-bar">
			<div id="global-logo">
				<h2><a href="#" class="sidebar-open" data-sidebar="global">&gt;</a></h2>
				<h2><a href="/">Lions and dragons</a></h2>
			</div>
			<div class="tabs" id="global-tabs">
				<!-- 
					Whitespace fix for "display: inline-block;" elements
					*See code/inline-block-whitespace
				-->
				<ul class="collapse-hidden"
					><li class="window-open" data-window="list">ToDo</li
					><li class="window-open" data-window="thetwo">The Two</li>
				</ul>
			</div>
			<div class="clearfix"></div>
		</div>
		
		<div class="window-container">
		
			<div id="window-list">
				<ul class="list-fullscreen">
					<li>
						<div>asdf</div>
					</li>
					<li>Something</li>
					<li>Something</li>
					<li>Something</li>
					
				</ul>
			</div>
			
			<div id="window-thetwo">
				<div class="window-close">CLOSE MEEEE</div>
			</div>
		</div>
		
		<div class="sidebar-container">
			<div id="sidebar-global">
				<div class="titles">
					<h2>Homework Thing</h2>
					<h6>By Fru1tStudio</h6>
				</div>
				
				<ul class="expand-hidden">
					<li><a href="#" class="window-open" data-window="list">ToDo</a></li>
					<li><a href="#" class="window-open" data-window="thetwo">The Two</a></li>
				</ul>
			</div>
		</div>
		
		<script src="/.site/js/global.js"></script>
		<script src="/.site/js/devel.js"></script>
		
	</body>
</html>