<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\NameService;
use App\Templates\Index\IndexDefaultTemplateParameters;
use Laminas\Diactoros\Response;
use Latte\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class IndexController
{
	public function __construct(
		private readonly Engine $latte,
		private readonly NameService $namedayService
	)
	{
	}

	public function get(ServerRequestInterface $request): ResponseInterface
	{
		$response = new Response();

		$params = new IndexDefaultTemplateParameters(
			name: $this->namedayService->getName(),
		);

		$body = $this->latte->renderToString(__DIR__ . '/../Templates/Index/default.latte', $params);

		$response->getBody()->write($body);
		return $response;
	}
}
