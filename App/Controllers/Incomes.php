<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Flash;
use \App\Models\Categories;

/**
 * Incomes controller
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
        $category = new Categories;
        $categoriesOfIncomes = Categories::getIncomesCategories();
        View::renderTemplate('Incomes/add.html', [
            'incomesCategories' => $categoriesOfIncomes
        ]);
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
