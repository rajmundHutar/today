<?php

declare(strict_types=1);

namespace App;

use App\Controllers\IndexController;
use App\Services\NameService;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use Tracy\Debugger;

class Application
{
	public function __construct()
	{
		$request = ServerRequestFactory::fromGlobals(
			$_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
		);

		Debugger::enable(Debugger::Development, __DIR__ . '/../log');

		$container = $this->initContainer();

		$router = $this->initRouter($container);

		$response = $router->dispatch($request);

		(new SapiEmitter())->emit($response);
	}

	private function initContainer(): Container
	{
		$container = new Container();
		$container->defaultToShared();
		$container->delegate(new ReflectionContainer(true));

		$container->add(NameService::class);

		return $container;
	}

	private function initRouter(Container $container): Router
	{
		$router = new Router();
		$strategy = (new ApplicationStrategy());
		$strategy->setContainer($container);
		$router->setStrategy($strategy);

		$router->map('GET', '/', [IndexController::class, 'get']);

		return $router;
	}
}
