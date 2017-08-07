<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
$config['db']['host'] = "localhost";
$config['db']['user'] = "root";
$config['db']['pass'] = "gazarik126";
$config['db']['dbname'] = "API";


$app = new Slim\App([
    'settings' => $config
]);


$container = $app->getContainer();
$container['view'] = new \Slim\Views\PhpRenderer('../view/');
$container['GetController'] = function ($container) {
    return new \Controller\GetController($container);
};
$container['PostController'] = function ($container) {
    return new \Controller\PostController($container);
};

$container['PutController'] = function ($container) {
    return new \Controller\PutController($container);
};

$container['PatchController'] = function ($container) {
    return new \Controller\PatchController($container);
};

$container['DeleteController'] = function ($container) {
    return new \Controller\DeleteController($container);
};

$container['ContactModel'] = function ($container) {
    return new \Model\ContactModel($container);
};
$container['NotesModel'] = function ($container) {
    return new \Model\NotesModel($container);
};
$container['TokenModel'] = function ($container) {
    return new \Model\TokenModel($container);
};

$container['JsonMiddleware'] = function () {
    return new \Middleware\JsonMiddleware();
};
$container['AuthMiddleware'] = function ($container) {
    return new \Middleware\AuthMiddleware($container);
};
$container['ValidationMiddleware'] = function () {
    return new \Middleware\ValidationMiddleware();
};



$container['db'] = function ($container) {
    $db = $container['settings']['db'];
    $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
};


require('../app/routes.php');

