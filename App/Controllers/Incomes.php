<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Flash;

/**
 * Expenses controller
 *
 * PHP version 8.2
 */
#[\AllowDynamicProperties]
class Incomes extends Authenticated
{

    /**
     * Show an adding expenses form
     *
     * @return void
     */
    public function addAction()
    {
        View::renderTemplate('Incomes/add.html');
    }

    /**
     * Adding a new expense
     *
     * @return void
     */
    public function newAction()
    {
        $user = new User($_POST);

        if ($user->addNewIncome($_POST)) {

            Flash::addMessage('Income added');

            $this->redirect('/incomes/add');
        }
    }

}
