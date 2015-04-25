<?php
namespace common\ppunit\html;

use common\ppunit\UnitTest;
use stak\template\processors\IndexProcessor;
use common\base\Response;
use Exception;

// Make sure we've been included and have the information necessary to make the page
/** @var \ReflectionObject $reflectionObject */
/** @var \ReflectionMethod[] $tests */
/** @var UnitTest $unitTest */
if (!isset($ppunitTestPage, $tests, $reflectionObject, $unitTest))
	exit;

//TODO: For the love of all that is holy, make this page look half decent.

$page = IndexProcessor::getRequestedPage();
$response = null;
Response::getInstance($response, "Index Root");
if (!$page::canLoad($response))
	print_r($response);
$includeContent = $page::getContentLocation();
?>

<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>PPUnit - <?php $reflectionObject->getParentClass()->getName(); ?></title>
</head>

<body>

<?php
$passedTests = 0;
echo "<div>Testing ", count($tests), " test(s).<br /><br />";
foreach ($tests as $test) {
	echo "<div>Running ", $test->getName(), "...</div>";
	try {
		$test->invoke($unitTest);
		$passedTests++;
		echo "Passed!<br /><br />";
	}
	catch (Exception $e) {
		echo "The test failed with error: ", $e->getMessage(), ".";
		echo "<ol>";
		foreach ($e->getTrace() as $trace) {
			echo "<li>",
					"<div>File: ", ((isset($trace['file'])) ? $trace['file'] : ""), "</div>",
					"<div>Line: ", ((isset($trace['line'])) ? $trace['line'] : ""), "</div>",
					"<div>Class: ", ((isset($trace['class'])) ? $trace['class'] : ""), "</div>",
					"<div>Args: ", print_r($trace['args']), "</div>",
				"</li>";
		}
		echo "</ol><br /><br />";
	}
}
if ($passedTests == count($tests))
	echo "<div>Passed all tests!</div>";
else
	echo "<div>There were one or more errors</div>";
?>

</body>
</html>