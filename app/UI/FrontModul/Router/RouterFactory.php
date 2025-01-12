<?php

declare(strict_types=1);

namespace App\UI\FrontModul\Router;
use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
		$router->withModule('front')
		->addRoute('[<lang=cs cs|en>/]prihlaseni', 'Sign:in')
		->addRoute('[<lang=cs cs|en>/]<presenter>/<action>', 'Home:default')
		->addRoute('[<lang=cs cs|en>/]clanek/detail/<postId>','Post:show');
		
		return $router;
	}
}
