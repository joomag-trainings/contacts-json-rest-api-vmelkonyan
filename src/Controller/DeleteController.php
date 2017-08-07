<?php

namespace Controller;


use Model\ContactEntity;
use Model\NotesEntity;
use Slim\Http\Request;
use Slim\Http\Response;

class DeleteController extends AbstractController
{

    public function actionContactsId(Request $request, Response $response, $args)
    {
        $contact = new ContactEntity();
        $contact->setId($args['id']);
        if (!$result = $this->container['ContactModel']->actionDeleteContact($contact)) {
            return $response->withJson(['error' => 'Invalid Input Data'], 400);
        } else {
            return $response->withStatus(204);
        }

    }

    public function actionContactsIdStar(Request $request, Response $response, $args)
    {
        $contact = new ContactEntity();
        $contact->setId($args['id']);
        if (!$result = $this->container['ContactModel']->actionDeleteStar($contact)) {
            return $response->withStatus(400);
        } else {
            return $response->withStatus(204);
        }
    }

    public function actionContactsIdNotesId(Request $request, Response $response, $args)
    {
        $note = new NotesEntity();
        $note->setId($args['nid']);
        $note->setContactId($args['id']);
        if (!$result = $this->container['NotesModel']->actionDelete($note)) {
            return $response->withStatus(400);
        } else {
            return $response->withStatus(204);
        }

    }

}