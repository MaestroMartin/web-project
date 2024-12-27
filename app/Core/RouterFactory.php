<?php

declare(strict_types=1);

namespace App\Core;

use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
		$router->addRoute('User/default/', 'User:default');
		$router->addRoute('user/edit/', 'User:edit');
		$router->addRoute('prihlaseni/', 'Sign:in');
		$router->addRoute('sign/<action>', 'Sign:in');
		$router->addRoute('editacePrispevku/<postId>', 'Post:manipulate');
        $router->addRoute('vytvoreniPrispevku/', 'Post:manipulate', Nette\Application\Routers\Route::ONE_WAY);
		$router->addRoute('vytvoreni/prispevku/', 'Post:manipulate');
		$router->addRoute('<presenter>/<action>[/<id>]', 'Home:default');
		return $router;
	}
}
