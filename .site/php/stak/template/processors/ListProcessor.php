<?php
namespace stak\template\processors;
use stak\template\utils\TemplateUtils;

require_once $_SERVER['DOCUMENT_ROOT'] . '/.site/php/stak/Autoload.php';

/**
 * The processing backend for the List template
 * @package stak\template\page\processors
 */
class ListProcessor {

	// Init 'n stuff
	public static function showRequestedView() {
		//TODO: Correctly get view from settings
		$view = (isset($_GET['view'])) ? $_GET['view'] : '';
		switch ($view) {
			case "multitag":
				self::showMultiTagView();
				break;
			case "singlelist":
				self::showSingleListView();
				break;
			default:
				self::showSingleTagView();
				break;
		}
	}

	/**
	 * Multi-tag mode. Each tag has its own tasklist and timescopes. All tags are displayed within
	 * the viewstyle container.
	 */
	private static function showMultiTagView() {
		TemplateUtils::includeFromContentLocation("/listpage/MultiTagView.php");
	}

	/**
	 * Single list mode. All tasks are shown in a single list
	 */
	private static function showSingleListView() {
		TemplateUtils::includeFromContentLocation("/listpage/SingleListView.php");
	}

	/**
	 * Single tag mode. Displays a list of tags in which the user can click a single tag and
	 * display only that tag's tasks.
	 */
	private static function showSingleTagView() {
		TemplateUtils::includeFromContentLocation("/listpage/SingleTagView.php");
	}
}
