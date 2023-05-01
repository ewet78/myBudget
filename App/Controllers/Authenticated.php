<?php

namespace App\Controllers;

/**
 * Authenticatedf base controller
 * 
 * PHP version 8.2
 */
abstract class Authenticated extends \Core\Controller
{
   
    /**
     * Require the user to be authenticated before giving access to all methods in the controller
     * 
     * @return void
     */
    protected function before()
    {
        $this->requireLogin();
    }
 
}