<?php

declare(strict_types=1);

namespace App\AdminModule\Router;

use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
		$router->withModule('admin')
		->withPath('admin')
		->addRoute('[<lang=cs cs|en>/]prihlaseni', 'Sign:in')
		->addRoute('[<lang=cs cs|en>/]<presenter>/<action>', 'Home:default')
		->addRoute('[<lang=cs cs|en>/]clanek/detail/<postId>','Post:show');
		$router->addRoute('[<lang=cs cs|en>/]<presenter>/<action>[/<id>]', 'Home:default');
		
		return $router;
	}
}
