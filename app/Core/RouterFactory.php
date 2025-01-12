<?php

declare(strict_types=1);

namespace App\Core;

use App\AdminModule\Router\RouterFactory as AdminRouterFactory;
use Nette;
use Nette\Application\Routers\RouteList;
use App\Core\RouterFactory as FrontRouterFactory;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
		$router->add(AdminRouterFactory::createRouter())
		->add(FrontRouterFactory::createRouter())
		->addRoute('[<lang=cs cs|en>/]<presenter>/<action>[/<id>]', 'Home:default');
		
		
		return $router;
	}
}
