<!DOCTYPE html>
<?php include(".site/php/ascii-art.php"); ?>
<html lang="en">
	<head>
		<title>Fru1tMe - Homework Thing</title>
		<meta charset="UTF-8" />
		
		<link href="/.site/css/compiled/global.css" rel="stylesheet" type="text/css">
		
	</head>
	
	<body>
		<div class="window" id="window-theone">
			<div class="window-close">Click to close</div>
		</div>
		<div class="window" id="window-thetwo">
			<div class="window-close">CLOSE MEEEE</div>
		</div>
		
		<div id="global-menu-bar">
			<div id="global-logo">
				Lions and dragons
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
		</div>
		
		
		<div class="sidebar" id="global-sidebar">
			<ul class="expand-hidden"
				><li class="window-open" data-window="theone">The One m</li
				><li class="window-open" data-window="thetwo">The Two m</li>
			</ul>
		</div>
		
		
		<script src="/.site/js/global.js"></script>
	</body>
</html>