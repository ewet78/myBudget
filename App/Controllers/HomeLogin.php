<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;

/**
 * Home controller
 *
 * PHP version 8.2
 */
#[\AllowDynamicProperties]
class HomeLogin extends Authenticated
{

    /**
     * Before filter
     *
     * @return void
     */
    protected function before()
    {
        parent::before();

        $this->user = Auth::getUser();
    }

    /**
     * After filter
     *
     * @return void
     */
    protected function after()
    {
        
    }

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        
        View::renderTemplate('Homelogin/index.html', [
            'user' => $this->user
        ]);
    }
}
