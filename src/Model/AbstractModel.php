<?php
/**
 * Created by PhpStorm.
 * User: moof
 * Date: 8/2/17
 * Time: 4:07 AM
 */

namespace Model;


use Slim\Container;

class AbstractModel
{
    protected $db;

    public function __construct(Container $container)
    {
        $this->db = $container['db'];
    }
}