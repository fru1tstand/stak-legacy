<?php
namespace common\template;
use common\base\Response;

/**
 * Defines a template content page.
 * The structure for templating using this file is as follows
 * 	- Master Page (index/home/other root template name)
 * 		- Content Page
 * 			- Page Processor
 * 			- Page Content
 * 				- Sub-divided page content ad infinitum
 * @package common\template
 */
interface ContentPage {
	/**
	 * Returns whether or not the page should be loaded. This method is called before any HTML is
	 * sent to the requester. This is where all the checks for valid users, permissions, session
	 * state, etc is done.
	 * @param Response $response
	 * @return bool True if the page can be loaded; false otherwise.
	 */
	public static function canLoad(Response &$response = null);

	/**
	 * Returns the absolute location of the page content.
	 * @return string
	 */
	public static function getContentLocation();
}