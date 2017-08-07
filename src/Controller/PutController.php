<?php

namespace Controller;


use Model\ContactEntity;
use Slim\Http\Request;
use Slim\Http\Response;

class PutController extends AbstractController
{


    public function actionContactsIdStar(Request $request, Response $response, $args)
    {
        $contact = new ContactEntity();
        $contact->setId($args['id']);
        if (!$result = $this->container['ContactModel']->actionAddStar($contact)) {
            return $response->withJson(['error' => 'Invalid Data Input'],400);
        } else {
            return $response->withStatus(200);
        }

    }


}