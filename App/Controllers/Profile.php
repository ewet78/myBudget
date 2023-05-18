<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Flash;
use \App\Models\Categories;
use \App\Models\User;

/**
 * Profile controller
 * 
 * PHP version 8.2
 */
#[\AllowDynamicProperties]
class Profile extends Authenticated
{

    /**
     * Before filter - called beafore each action method
     * 
     * @return void
     */
    protected function before()
    {
        parent::before();

        $this->user = Auth::getUser();
    }




    /**
     * Show the profile
     * 
     * @return void
     */
    public function showAction()
    {
       View::renderTemplate('Profile/show.html', [
            'user' => $this->user
       ]); 
    }



    /**
     * Show the form for editing the profile
     * 
     * @return void
     */
    public function editAction()
    {
        View::renderTemplate('Profile/edit.html', [
            'user' => $this->user
        ]);
    }


    /**
     * Update the profile
     * 
     * @return void
     */
    public function updateAction()
    {

        if ($this->user->updateProfile($_POST)) {

            Flash::addMessage('Changes saved');

            $this->redirect('/profile/show');
        } else {

            View::renderTemplate('Profile/edit.html', [
                'user' => $this->user
            ]);
        }

    }

     /**
     * Show the form for editing all the categories
     * 
     * @return void
     */
    public function showeditcategoryAction()
    {
        $category = new Categories;
        $categoriesOfIncomes = Categories::getIncomesCategories();
        $categoriesOfExpenses = Categories::getExpensesCategories();

        View::renderTemplate('Profile/showeditcategory.html', [
            'incomesCategories' => $categoriesOfIncomes,
            'expensesCategories' => $categoriesOfExpenses
        ]);
    }

      /**
     * Show the form for editing the chosen categories
     * 
     * @return void
     */
    public function editincomescategoryAction()
    {   
        if(isset($_POST['editButton'])){
            $index = $_POST['editButton'];
            $categoryName = $_POST['categoryName'][$index];

            View::renderTemplate('Profile/editincomescategory.html', [
                'categoryName' => $categoryName, // Pass the category value to the view
            ]);
        }
        else View::renderTemplate('Profile/editincomescategory.html');

    
    }

        /**
     * Show the form for editing the chosen categories
     * 
     * @return void
     */
    public function editexpensescategoryAction()
    {   
        if(isset($_POST['editButton'])){
            $index = $_POST['editButton'];
            $categoryName = $_POST['categoryName'][$index];

            View::renderTemplate('Profile/editexpensescategory.html', [
                'categoryName' => $categoryName, // Pass the category value to the view
            ]);
        }
        else View::renderTemplate('Profile/editexpensescategory.html');

    
    }

    public function editpaymentmethodAction()
    {
        if(isset($_POST['editButton'])){
            $index = $_POST['editButton'];
            $paymentMethod = $_POST['paymentMethod'][$index];

            View::renderTemplate('Category/editpaymentmethods.html', [
                'paymentMethod' => $paymentMethod, // Pass the category value to the view
            ]);
        }
        else View::renderTemplate('Category/showeditpaymentmethods.html');
    }

    
    public function deleteaccountAction()
    {
        View::renderTemplate('Profile/deleteaccount.html');
    }

    public function deleteaccountconfirmAction()
    {
        $user = new User;
        if (User::deleteAccount()) 
        {
            Flash::addMessage('Account deleted');
            $this->redirect('/');
        } else View::renderTemplate('Profile/deleteaccount.html');

    }


    
}