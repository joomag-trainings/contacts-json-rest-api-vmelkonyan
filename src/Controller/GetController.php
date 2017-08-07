<?php
/**
 * Created by PhpStorm.
 * User: moof
 * Date: 7/31/17
 * Time: 7:59 PM
 */

namespace Controller;


use Slim\Http\Request;
use Slim\Http\Response;

class GetController extends AbstractController
{


    public function actionContacts(Request $request, Response $response)
    {
        if (!empty($request->getQueryParams())) {
            $params = $request->getQueryParams();
            $page = $params['page'];
            $order = $params['order'];
            $limit = $params['limit'];
            if (!empty($page) && is_numeric($page) && !empty($order) && !empty($limit) && is_numeric($limit)) {
                if (in_array($order, ['firstName', 'lastName', 'email', 'id', '-id', '-frstName', '-lastName'])) {
                    if (!$result = $this->container['ContactModel']->actionSelectAllWithProp($page, $order, $limit)) {
                        return $response->withStatus(404);
                    } else {
                        return $response->withJson($result, 200);
                    }
                }
            }

        }

        if (!($result = $this->container['ContactModel']->actionSelectAll())) {
            return $response->withStatus(404);
        } else {
            return $response->withJson($result, 200);
        }
    }


    public function actionContactsId(Request $request, Response $response, $args)
    {
        if (!($result = $this->container['ContactModel']->actionSelectById($args['id']))) {
            return $response->withStatus(404);
        } else {

            return $response->withJson($result, 200);
        }

    }


    public function actionContactsIdNotes(Request $request, Response $response, $args)
    {
        if (!empty($request->getQueryParams())) {
            $params = $request->getQueryParams();
            $page = $params['page'];
            $order = $params['order'];
            $limit = $params['limit'];
            if (!empty($page) && is_numeric($page) && !empty($order) && !empty($limit) && is_numeric($limit)) {
                if (in_array($order, ['text', '-text', 'id', '-id'])) {
                    if (!$result = $this->container['NotesModel']->actionSelectAllWithProp($page, $order, $limit)) {
                        return $response->withStatus(404);
                    } else {
                        return $response->withJson($result, 200);
                    }

                }
            }

        }


        if (!($result = $this->container['NotesModel']->actionSelectAll($args['id']))) {
            return $response->withStatus(404);
        } else {
            return $response->withJson($result, 200);
        }
    }


    public function actionContactsIdNotesId(Request $request, Response $response, $args)
    {
        if (!($result = $this->container['NotesModel']->actionSelectById($args['id'], $args['nid']))) {
            return $response->withStatus(404);
        } else {
            return $response->withJson($result, 200);
        }
    }

}