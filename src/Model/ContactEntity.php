<?php
/**
 * Created by PhpStorm.
 * User: moof
 * Date: 8/2/17
 * Time: 4:05 AM
 */

namespace Model;


class ContactEntity
{
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $star;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return String
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param String $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return String
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param String $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return String
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param String $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return boolean
     */
    public function getStar()
    {
        return $this->star;
    }

    /**
     * @param boolean $star
     */
    public function setStar($star)
    {
        $this->star = $star;
    }


}