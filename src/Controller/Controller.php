<?php

namespace Mohist\SodionAuthFlarum\Controller;

use Laminas\Diactoros\Response\JsonResponse;
use Mohist\SodionAuthFlarum\Provider\UserProvider;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Controller implements RequestHandlerInterface
{

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = (new \Mohist\SodionAuth\Controller\Controller(new UserProvider()))
            ->handle((object)$request->getParsedBody());
        return new JsonResponse($response->data);
    }
}
