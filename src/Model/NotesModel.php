<?php
/**
 * Created by PhpStorm.
 * User: moof
 * Date: 8/2/17
 * Time: 4:59 AM
 */

namespace Model;


class NotesModel extends AbstractModel
{
    public function actionSelectAllWithProp($page, $order, $limit)
    {
        switch ($order) {
            case 'text' :
                $order = 'text ASC';
                break;
            case '-text' :
                $order = 'text DESC';
                break;
            case 'id' :
                $order = 'id ASC';
                break;
            case '-id' :
                $order = 'id DESC';
                break;
        }

        $offset = ($page - 1) * $limit;
        $notesArr = [];
        $connection = $this->db;
        $statement = $connection->prepare('SELECT COUNT(*) AS "rowCount" FROM `notes`');
        $statement->execute();
        $rslt = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $rowCount = $rslt[0]["rowCount"];
        if ($page - 1 > $rowCount / $limit) {
            return false;
        } else {
            $statement = $connection->prepare('SELECT * FROM `notes` ' . ' ORDER BY ' . $order . ' LIMIT ' . (int)$limit . ' OFFSET ' . (int)$offset);
            $statement->execute();
            $rslt = $statement->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($rslt as $row) {
                array_push($notesArr, [
                    'id' => (int)$row['id'],
                    'text' => $row['text'],
                ]);
            }
            return !empty($notesArr) ? $notesArr : false;
        }
    }

    public
    function actionSelectAll(
        $id
    ) {
        $notesArr = [];
        $connection = $this->db;
        $statement = $connection->prepare('SELECT * FROM `notes` WHERE `contact_id` = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
        $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($results as $row) {
            array_push($notesArr, [
                'id' => (int)$row['id'],
                'text' => $row['text']
            ]);
        }

        return !empty($notesArr) ? $notesArr : false;
    }


    public
    function actionSelectById(
        $id,
        $nid
    ) {
        $notesArr = [];
        $connection = $this->db;
        $statement = $connection->prepare('SELECT * FROM `notes` WHERE `contact_id` = :id AND `id` = :nid');
        $statement->bindParam(':id', $id);
        $statement->bindParam(':nid', $nid);
        $statement->execute();
        $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($results as $row) {
            array_push($notesArr, [
                'id' => (int)$row['id'],
                'text' => $row['text']
            ]);
        }
        return !empty($notesArr) ? $notesArr : false;

    }

    public
    function actionAdd(
        $entity
    ) {
        $contactId = $entity->getContactId();
        $text = $entity->getText();
        $connection = $this->db;
        $statement = $connection->prepare('INSERT INTO `notes` VALUES(NULL, :text, :contact_id)');
        $statement->bindParam(':text', $text);
        $statement->bindParam(':contact_id', $contactId);
        if ($statement->execute()) {
            $statement = $connection->prepare('SELECT * FROM `notes` WHERE `text` = :text AND `contact_id` = :contact_id');
            $statement->bindParam(':text', $text);
            $statement->bindParam(':contact_id', $contactId);
            if ($statement->execute()) {
                return $statement->fetchAll(\PDO::FETCH_ASSOC);
            }

        } else {
            return false;
        }
        return false;
    }

    public
    function actionUpdate(
        $entity
    ) {
        $noteId = $entity->getId();
        $noteText = $entity->getText();
        $noteContactId = $entity->getContactId();
        $connection = $this->db;
        $statement = $connection->prepare('UPDATE `notes` SET `text` = :text WHERE `contact_id` = :contactId AND `id` = :id');
        $statement->bindParam(':text', $noteText);
        $statement->bindParam(':contactId', $noteContactId);
        $statement->bindParam(':id', $noteId);
        return $statement->execute();
    }

    public
    function actionDelete(
        NotesEntity $entity
    ) {
        $noteId = $entity->getId();
        $contId = $entity->getContactId();
        $connection = $this->db;
        $statement = $connection->prepare('DELETE * FROM `notes` WHERE `id` = :noteId AND `contact_id` = :contId');
        $statement->bindParam(':noteId', $noteId);
        $statement->bindParam(':contId', $contId);
        return $statement->execute();
    }

}