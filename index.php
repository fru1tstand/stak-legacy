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
		<div class="window-container">
			<div id="window-theone">
				<div class="window-close">Click to close</div>
			</div>
			<div id="window-thetwo">
				<div class="window-close">CLOSE MEEEE</div>
			</div>
		</div>

		
		<div id="global-menu-bar">
			<div id="global-logo">
				<a href="#" class="sidebar-open" data-sidebar="global">Open</a>
				<a href="/">Lions and dragons</a>
			</div>
			<div class="menu" id="global-menu">
				<!-- No, that's not a programming error. It's an HTML fix for
						whitespace poo in between display: inline-block; elements.
						-->
				<ul class="collapse-hidden"
					><li class="window-open" data-window="theone">The One</li
					><li class="window-open" data-window="thetwo">The Two</li>
				</ul>
			</div>
			<div class="clearfix"></div>
		</div>
		
		
		<div class="sidebar" id="sidebar-global">
			<ul class="expand-hidden"
				><li class="window-open" data-window="theone">The One m</li
				><li class="window-open" data-window="thetwo">The Two m</li>
			</ul>
		</div>
		
		<script src="/.site/js/global.js"></script>
	</body>
</html>