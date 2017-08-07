<?php
/**
 * Created by PhpStorm.
 * User: moof
 * Date: 7/31/17
 * Time: 8:09 PM
 */

namespace Controller;


use Model\ContactEntity;
use Model\NotesEntity;
use Slim\Http\Request;
use Slim\Http\Response;

class PostController extends AbstractController
{


    public function actionContacts(Request $request, Response $response, $args)
    {
        $contact = new ContactEntity();
        $contact->setFirstName($request->getParam('firstName'));
        $contact->setLastName($request->getParam('lastName'));
        $contact->setEmail($request->getParam('email'));

        if (!$result = $this->container['ContactModel']->actionAdd($contact)) {
            return $response->withStatus(400);
        } else {
            return $response->withJson($result, 201);
        }
    }


    public function actionContactsIdNotes(Request $request, Response $response, $args)
    {
        $note = new NotesEntity();
        $note->setContactId($args['id']);
        $note->setText($request->getParam('text'));
        if (!$result = $this->container['NotesModel']->actionAdd($note)) {
            return $response->withStatus(400);
        } else {
            return $response->withJson($result, 201);
        }
    }

}