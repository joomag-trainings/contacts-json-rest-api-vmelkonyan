<?php
/**
 * Created by PhpStorm.
 * User: moof
 * Date: 7/31/17
 * Time: 8:25 PM
 */

namespace Controller;


use Model\ContactEntity;
use Model\NotesEntity;
use Slim\Http\Request;
use Slim\Http\Response;

class PatchController extends AbstractController
{

    public function actionContactsId(Request $request, Response $response, $args)
    {

        $contact = new ContactEntity();
        $contact->setFirstName($request->getParam('firstName'));
        $contact->setLastName($request->getParam('lastName'));
        $contact->setEmail($request->getParam('email'));
        $contact->setId($args['id']);
        if (!$result = $this->container['ContactModel']->actionUpdate($contact)) {
            return $response->withStatus(400);
        } else {
            return $response->withStatus(201);
        }

    }

    public function actionContactsIdNotesId(Request $request, Response $response, $args)
    {
        $note = new NotesEntity();
        $note->setId($args['nid']);
        $note->setText($request->getParam('text'));
        $note->setContactId($args['id']);
        if (!$result = $this->container['NotesModel']->actionUpdate($note)) {
            return $response->withStatus(400);
        } else {
            return $response->withStatus(201);
        }

    }

}