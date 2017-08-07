<?php
$app->group('/api', function () use ($app) {

    // Version group
    $app->group('/v1', function () use ($app) {
        //Contacts group
        $app->group('/contacts', function () use ($app) {


            $app->get('', 'GetController:actionContacts')->add('AuthMiddleware');
            $app->post('',
                'PostController:actionContacts')->add('ValidationMiddleware')->add('JsonMiddleware')->add('AuthMiddleware');
            $app->get('/{id}', 'GetController:actionContactsId')->add('AuthMiddleware');
            $app->patch('/{id}',
                'PatchController:actionContactsId')->add('ValidationMiddleware')->add('JsonMiddleware')->add('AuthMiddleware');
            $app->delete('/{id}', 'DeleteController:actionContactsId')->add('AuthMiddleware');
            $app->put('/{id}/star', 'PutController:actionContactsIdStar')->add('JsonMiddleware')->add('AuthMiddleware');
            $app->delete('/{id}/star', 'DeleteController:actionContactsIdStar')->add('AuthMiddleware');
            $app->get('/{id}/notes/', 'GetController:actionContactsIdNotes')->add('AuthMiddleware');
            $app->get('/{id}/notes/{nid}', 'GetController:actionContactsIdNotesId')->add('AuthMiddleware');
            $app->post('/{id}/notes',
                'PostController:actionContactsIdNotes')->add('ValidationMiddleware')->add('JsonMiddleware')->add('AuthMiddleware');
            $app->patch('/{id}/notes/{nid}',
                'PatchController:actionContactsIdNotesId')->add('ValidationMiddleware')->add('JsonMiddleware')->add('AuthMiddleware');
            $app->delete('/{id}/notes/{nid}', 'DeleteController:actionContactsIdNotesId')->add('AuthMiddleware');

        });
    });


});