<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/.site/php/source/Autoload.php';
use content\IncludeContent;
?>

<!DOCTYPE html>

<html lang="en">
	<head>
		<title>Fru1tMe - Homework Thing</title>
		<meta charset="UTF-8" />
		<link href="/.site/css/compiled/global.css" rel="stylesheet" type="text/css">
		<link href="/.site/php/css/theme.php" rel="stylesheet" type="text/css">
	</head>
	
	<body>
		<div id="global-menu-bar">
			<div id="global-logo">
				<!-- Sidebar wrapper -->
				<div id="sidebar-global-wrapper">
					<!-- Toggle Text -->
					<h3><a href="#" class="bar-link"><i class="fa fa-bars"></i></a></h3>
					
					<!-- Actual sidebar -->
					<div class="sidebar" id="global-sidebar">
						<div class="titles">
							<h2>Reminder Thing</h2>
							<h6>By Fru1tStudio</h6>
						</div>
						
						<ul class="expand-hidden">
							<li><a href="#" class="window-open" data-window="list">List</a></li>
							<li><a href="#" class="window-open" data-window="thetwo">The Two</a></li>
						</ul>
					</div>
				</div>
				
				<h3><a href="/" class="bar-link">Lions and dragons</a></h3>
			</div>
			<div class="tabs" id="global-tabs">
				<!-- 
					Whitespace fix for "display: inline-block;" elements
					*See code/inline-block-whitespace
				-->
				<ul class="collapse-hidden"
					><li class="window-open" data-window="list">List</li
					><li class="window-open" data-window="thetwo">The Two</li>
				</ul>
			</div>
			<div class="clearfix"></div>
		</div>
		
		<div id="window-container">
			<div>
				<?php 
					IncludeContent::ListWindow();
				?>
			</div>
		</div>
		
		<script src="/.site/js/global.js"></script>
		<script src="/.site/js/devel.js"></script>
		
	</body>
</html>