<?php
/**
 * Created by PhpStorm.
 * User: moof
 * Date: 8/4/17
 * Time: 4:41 PM
 */

namespace Middleware;


use Model\TokenModel;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthMiddleware
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response, $next)
    {
        $errorJSON = [
            'error' => [
                'message' => 'An access token is required to request this resource.'
            ]
        ];
        $tokenVerificator = new TokenModel($this->container);
        $token = $request->getHeader('TOKEN');
        if (!empty($token)) {
            if ($tokenVerificator->verify($token)) {
                return $response = $next($request, $response);
            } else {
                return $response->withJson($errorJSON, 403);
            }
        }
        return $response->withJson($errorJSON, 403);
    }
}