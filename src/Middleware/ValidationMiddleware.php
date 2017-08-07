<?php
/**
 * Created by PhpStorm.
 * User: moof
 * Date: 8/5/17
 * Time: 10:11 PM
 */

namespace Middleware;


use Slim\Http\Request;
use Slim\Http\Response;

class ValidationMiddleware
{

    public function __invoke(Request $request, Response $response, $next)
    {
        $methodsArr = ['patch', 'post'];
        $method = strtolower($request->getMethod());
        if (in_array($method, $methodsArr)) {
            $firstName = $request->getParam('firstName');
            $firstNameLength = strlen($firstName);
            $lastName = $request->getParam('lastName');
            $lastNameLength = strlen($lastName);
            $email = $request->getParam('email');
            $emailLength = strlen($email);
            $isValid = filter_var($email, FILTER_VALIDATE_EMAIL);

            if (!empty($firstName) && !empty($lastName) && !empty($email) && $isValid == true) {
                if ($firstNameLength <= 50 && $lastNameLength <= 50 && $emailLength <= 50) {
                    return $response = $next($request, $response);
                } else {
                    $errorMsg = [
                        'error' => 'invalid data input'
                    ];
                    return $response->withJson($errorMsg, 400);
                }
            } else {
                $errorMsg = [
                    'error' => 'invalid data input'
                ];
                return $response->withJson($errorMsg, 400);
            }
        } else {
            return $response->withJson(['error' => 'method not allowed'], 405);
        }
    }
}