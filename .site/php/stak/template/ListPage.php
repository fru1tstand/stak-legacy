<?php
namespace stak\template;
require_once $_SERVER['DOCUMENT_ROOT'] . '/.site/php/stak/Autoload.php';
use common\template\ContentPage;
use common\base\Response;
use stak\Autoload;
use stak\UserData;
use stak\template\utils\TemplateUtils;

class ListPage implements ContentPage {
	/**
	 * Should check if the page can be rendered (security, web state, etc).
	 * @param Response $response
	 * @return bool
	 */
	public static function canLoad(Response &$response = null) {
		/** @var UserData $userData */
		$userData = Autoload::getInjector()->getInstance(UserData::class);
		return $userData::isLoggedIn();
	}

	/**
	 * Returns the location of the template (this method should not itself print any html).
	 * @return string
	 */
	public static function getContentLocation() {
		return TemplateUtils::getContentLocation() . '/ListContent.php';
	}
}
