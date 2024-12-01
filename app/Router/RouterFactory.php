<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList();
        $router->addRoute('results', 'Survey:default');
        $router->addRoute('survey', 'Survey:edit');
        foreach (['/<param .+>', ''] as $route) {
            $router->addRoute($route, function ($presenter) {
                return $presenter->redirectUrl('/survey');
            });
        }

        return $router;
	}
}
