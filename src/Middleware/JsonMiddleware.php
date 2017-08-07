<?php
/**
 * Created by PhpStorm.
 * User: moof
 * Date: 8/4/17
 * Time: 4:02 PM
 */

namespace Middleware;


use Slim\Http\Request;
use Slim\Http\Response;

class JsonMiddleware
{


    public function __invoke(Request $request, Response $response, $next)
    {
        $method = strtolower($request->getMethod());
        $mediaType = $request->getHeader('Content-Type');
        if (in_array($method, ['put', 'post', ' patch'])) {
            if (empty($mediaType) || $mediaType[0] !== 'application/json') {
                return $response->withStatus(415);
            }
        }
        return $response = $next($request, $response);

    }
}