<?php

namespace Mohist\SodionAuthFlarum\Controller;

use Flarum\Foundation\Config;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Container\Container;
use Laminas\Diactoros\Response\JsonResponse;
use Mohist\SodionAuth\Response\Response;
use Mohist\SodionAuthFlarum\Provider\UserProvider;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ramsey\Uuid\Uuid;

class Controller implements RequestHandlerInterface
{
    protected $settings;
    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $body = (object)$request->getParsedBody();
        if($body->key != $this->settings->get('sodion_api_key')){
            return new JsonResponse(Response::unknown('error_key','SodionAuth provider error_key')->data);
        }
        $response = (new \Mohist\SodionAuth\Controller\Controller(new UserProvider()))
            ->handle($body);
        return new JsonResponse($response->data);
    }
}
