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
class Expenses extends Authenticated
{

    /**
     * Show an adding expenses form
     *
     * @return void
     */
    public function addAction()
    {
        View::renderTemplate('Expenses/add.html');
    }

    /**
     * Adding a new expense
     *
     * @return void
     */
    public function newAction()
    {
        $user = new User($_POST);

        if ($user->addNewExpense($_POST)) {

            Flash::addMessage('Expense added');

            $this->redirect('/expenses/add');
        }
    }

}
