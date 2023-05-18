<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Flash;
use \App\Models\Categories;

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
        $category = new Categories;
        $categoriesOfExpenses = Categories::getExpensesCategories();
        $paymentMethods = Categories::getPaymentMethods();
        View::renderTemplate('Expenses/add.html', [
            'expensesCategories' => $categoriesOfExpenses,
            'paymentMethods' => $paymentMethods
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

        if ($user->addNewExpense($_POST)) {

            Flash::addMessage('Expense added');

            $this->redirect('/expenses/add');
        }
    }

}
