<?php

namespace Controller;

abstract class AbstractController
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;

    }


}