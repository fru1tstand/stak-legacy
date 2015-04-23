<?php
namespace stak\template\processors;
require_once $_SERVER['DOCUMENT_ROOT'] . '/.site/php/stak/Autoload.php';
use common\template\ContentPage;
use stak\template\ListPage;

class IndexProcessor {

	/**
	 * Returns the page requested
	 * @return ContentPage;
	 */
	public static function getRequestedPage() {
		return ListPage::class;
	}
}