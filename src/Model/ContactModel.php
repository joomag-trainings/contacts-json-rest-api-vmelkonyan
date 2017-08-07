<?php


namespace Model;


class ContactModel extends AbstractModel
{


    public function actionSelectAllWithProp($page, $order, $limit)
    {
        switch ($order) {
            case 'firstName' :
                $order = 'first_name ASC';
                break;
            case '-firstName' :
                $order = 'first_name DESC';
                break;
            case 'lastName' :
                $order = 'last_name ASC';
                break;
            case '-lastName' :
                $order = 'last_name DESC';
                break;
            case 'id' :
                $order = 'id ASC';
                break;
            case '-id' :
                $order = 'id DESC';
                break;
        }


        $offset = ($page - 1) * $limit;
        $contactsArr = [];
        $connection = $this->db;
        $statement = $connection->prepare('SELECT COUNT(*) AS "rowCount" FROM `contacts`');
        $statement->execute();
        $rslt = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $rowCount = $rslt[0]["rowCount"];
        if ($page - 1 > $rowCount / $limit) {
            return false;
        } else {
            $statement = $connection->prepare('SELECT * FROM `contacts` ' . ' ORDER BY ' . $order . ' LIMIT ' . (int)$limit . ' OFFSET ' . (int)$offset);
            $statement->execute();
            $rslt = $statement->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($rslt as $row) {
                array_push($contactsArr, [
                    'id' => (int)$row['id'],
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'email' => $row['email'],
                    'star' => (bool)$row['star']
                ]);
            }
            return !empty($contactsArr) ? $contactsArr : false;
        }
    }

    public function actionSelectAll()
    {
        $contactsArr = [];
        $connection = $this->db;
        foreach ($connection->query('SELECT * FROM `contacts`') as $row) {
            array_push($contactsArr, [
                'id' => (int)$row['id'],
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'email' => $row['email'],
                'star' => (bool)$row['star']
            ]);
        }

        return !empty($contactsArr) ? $contactsArr : false;
    }

    public function actionSelectById($id)
    {
        $contactsArr = [];
        $connection = $this->db;
        $statement = $connection->prepare('SELECT * FROM `contacts` WHERE `id` = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            array_push($contactsArr, [
                'id' => (int)$row['id'],
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'email' => $row['email'],
                'star' => (bool)$row['star']
            ]);
        }

        return !empty($contactsArr) ? $contactsArr : false;
    }


    public function actionAdd(ContactEntity $contactEntity)
    {

        $firstName = $contactEntity->getFirstName();
        $lastName = $contactEntity->getLastName();
        $email = $contactEntity->getEmail();
        $connection = $this->db;
        $statement = $connection->prepare('INSERT INTO `contacts` VALUES(NULL, :firstName, :lastName, :email, 0)');
        $statement->bindParam(':firstName', $firstName);
        $statement->bindParam(':lastName', $lastName);
        $statement->bindParam(':email', $email);;
        if ($statement->execute()) {
            $statement = $connection->prepare('SELECT * FROM `contacts` WHERE `email` = :email 
                                              AND `first_name` = :firstName AND `last_name` = :lastName
                                               AND `id` = (SELECT max(id) FROM `contacts`)');
            $statement->bindParam(':email', $email);
            $statement->bindParam(':firstName', $firstName);
            $statement->bindParam(':lastName', $lastName);
            if ($statement->execute()) {
                return $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
            }
        }
        return false;
    }

    public function actionUpdate(ContactEntity $contactEntity)
    {
        $firstName = $contactEntity->getFirstName();
        $lastName = $contactEntity->getLastName();
        $email = $contactEntity->getEmail();
        $id = $contactEntity->getId();
        $connection = $this->db;
        $statement = $connection->prepare('UPDATE `contacts` SET `first_name` = :firstName, `last_name` = :lastName, `email` = :email WHERE `id` = :id');
        $statement->bindParam(':firstName', $firstName);
        $statement->bindParam(':lastName', $lastName);
        $statement->bindParam(':email', $email);;
        $statement->bindParam(':id', $id);;
        return $statement->execute();
    }

    public function actionDeleteContact(ContactEntity $contactEntity)
    {
        $id = $contactEntity->getId();
        if ($result = $this->actionSelectById($id)) {
            $connection = $this->db;
            $statement = $connection->prepare('DELETE FROM `contacts` WHERE `id` = :id');
            $statement->bindParam(':id', $id);
            return $statement->execute();
        } else {
            return false;
        }
    }

    public function actionAddStar($contactEntity)
    {

        $id = $contactEntity->getId();
        if ($result = $this->actionSelectById($id)) {

            $connection = $this->db;
            $statement = $connection->prepare('UPDATE `contacts` SET `star` =  1 WHERE `id`=:id');
            $statement->bindParam(':id', $id);

            return $statement->execute();
        } else {
            return false;
        }
    }

    public function actionDeleteStar($contactEntity)
    {
        $id = $contactEntity->getId();
        $connection = $this->db;
        $statement = $connection->prepare('UPDATE `contacts` SET `star` =  0 WHERE `id`=:id');
        $statement->bindParam(':id', $id);
        return $statement->execute();
    }
}