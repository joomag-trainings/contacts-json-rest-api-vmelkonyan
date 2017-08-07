<?php
/**
 * Created by PhpStorm.
 * User: moof
 * Date: 8/4/17
 * Time: 4:42 PM
 */

namespace Model;


class TokenModel extends AbstractModel
{
    public function verify($token)
    {
        $token = $token[0];
        $connection = $this->db;
        $statement = $connection->prepare('SELECT * FROM `tokens` WHERE `text` = :token');
        $statement->bindParam(':token', $token);
        if ($statement->execute() && !empty($statement->fetchAll(\PDO::FETCH_ASSOC))) {
            return true;
        } else {
            return false;
        }
    }
}