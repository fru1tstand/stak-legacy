<?php
namespace common\ppunit\html;

use common\ppunit\UnitTest;
use ReflectionObject;
use ReflectionMethod;
use Exception;

// Make sure we've been included and have the information necessary to make the page
/** @var UnitTest[] $tests */
if (!isset($testObjects))
	exit;

// Get all tests
/** @var ReflectionMethod[] $tests */
$tests = array();
$passedTests = 0;
$totalTests = 0;

foreach ($testObjects as $obj) {
	$reflectObject = new ReflectionObject($obj);
	foreach ($reflectObject->getMethods() as $method) {
		// Check if its static
		if (!$method->isStatic())
			continue;

		if (!isset($tests[$reflectObject->getName()]))
			$tests[$reflectObject->getName()] = array();

		// Check if its a test
		if (strpos($method->getDocComment(), "@Test")) {
			$tests[$reflectObject->getName()][] = $method;
			$totalTests++;
		}
	}
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>PPUnitTest</title>

	<style>
		* {
			margin: 0;
			padding: 0;
		}
		body, html {
			height: 100%;
		}
		body {
			color: #a9b7c6;
			background-color: #313335;
			font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
		}
		.clearfix {
			clear: both;
		}

		.container {
			background-color: #2b2b2b;
			box-shadow: 0 0 4px 1px #000;
			margin: 0 auto;
			min-width: 800px;
			max-width: 1300px;
			width: 75%;
			min-height: 100%;
		}

		.title {
			color: #c9c9c9;
			padding: 15px 30px;
			font-size: 26px;
			border-bottom: 4px solid #3c3f41;
		}
		.subtitle {
			color: #cc7832;
			border-bottom: 1px solid #555;
			padding: 5px 30px;
		}

		.stats, .title, .run {
			margin-bottom: 40px;
		}
		.stats .content,
		.results {
			padding: 10px 15px;
		}
		.stats .content span {
			color: #6aabc8;
		}
		.stats .left,
		.stats .right {
			box-sizing: border-box;
			width: 50%;
			float: right;
		}
		.stats .left {
			border-right: 1px solid #555;
			float: left;
		}
		.stats .right span {
			font-family: monospace;
			padding-right: 5px;
		}

		.run {
			padding: 0 15px;
			font-family: monospace;
		}
		.run > div {
			padding: 15px 0;
		}
		.run pre {
			height: 14px;
			font-size: 14px;
			line-height: 14px;
			overflow: hidden;
			background-color: #000;
			-webkit-transition: height 0.5s cubic-bezier(0.3, 0.3, 0.02, 1);
			-moz-transition: height 0.5s cubic-bezier(0.3, 0.3, 0.02, 1);
			transition: height 0.5s cubic-bezier(0.3, 0.3, 0.02, 1);
		}
		.run pre:hover {
			height: 200px;
			overflow: auto;
		}
		.lnno {
			padding: 0 10px;
			color: #50964f;
		}
		.lnno::before {
			content: '[Lines ';
		}
		.lnno::after {
			content: ']';
		}
		.output {
			padding-left: 20px;
		}
		.method {
			color: #ffc66d;
		}
		.pass {
			color: #0A0;
		}
		.fail {
			color: #F33;
		}
		.test-class-name {
			text-align: center;
		}

		.progressbar {
			background-color: #3c3f41;
			height: 20px;
			line-height: 20px;
		}
		.progress-value {
			height: 100%;
			float: left;
			background-color: #0A0;
		}
		.nowidth {
			width: 0;
			white-space: nowrap;
		}
		.nowidth div {
			padding: 0 10px;
			color: #99FFFF;
			font-size: 14px;
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="title">PPUnitTest</div>
		<div class="stats">
			<div class="left">
				<div class="subtitle">Class(es)</div>
				<div class="content">
					<?php
                    foreach ($tests as $className => $classTests) {
                        echo "<div>$className</div>";
                    }
					?>
				</div>
			</div>
			<div class="right">
				<div class="subtitle">Test(s)</div>
				<div class="content">
					<?php
					foreach ($tests as $classTests) {
						/** @var ReflectionMethod $test */
						foreach ($classTests as $test) {
							echo "<div>{$test->getName()}</div>";
						}
					}
					?>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>

		<div class="subtitle">Run</div>
		<div class="run">
		<?php
		foreach ($tests as $className => $classTests) {
			echo "<div class='test-class-name'>$className</div>";

			/** @var ReflectionMethod $test */
			foreach ($classTests as $test) {

				echo '<div class="singletest">';
					echo '<div>Running <span class="method">', $test->getName(), '</span><span class="lnno">', $test->getStartLine(), "-",
							$test->getEndLine(), '</span></div>';
					echo '<div class="output">';
				try {
					$test->invoke(null);
					$passedTests++;
					echo '<div class="pass">Passed!</div>';
				} catch (Exception $e) {
					echo '<div>', $e->getMessage(), ' | Line ', $e->getTrace()[0]['line'], '</div>';
					echo '<pre>Hover to see full trace', "\r\n";
					print_r($e->getTrace());
					echo '</pre>';
					echo '<div class="fail">Failed.</div>';
				}
					echo '</div>';
				echo '</div>';
			}
		}
		?>
		</div>

		<?php
		$percentPass = round($passedTests / $totalTests * 100, 2);
		?>
		<div class="subtitle">Results</div>
		<div class="results">
			<div class="progressbar">
				<div class="progress-value" style="width:<?php echo $percentPass; ?>%">
					<div class="nowidth">
						<div>
							<?php echo $passedTests; ?> of <?php echo $totalTests; ?>
							test(s) passed (<?php echo $percentPass; ?>%)
						</div>
					</div>
				</div>
			</div>
			<?php
			if ($passedTests == $totalTests)
				echo '<div class="pass">All tests passed!</div>';
			else
				echo '<div class="fail">There were some test errors...</div>';
			?>

		</div>
	</div>
</body>
</html>