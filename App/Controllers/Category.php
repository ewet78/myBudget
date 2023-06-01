<?php

namespace App\Controllers;

use \Core\View;
use \App\Flash;
use App\Models\Categories;

/**
 * Categories controller
 *
 * PHP version 8.2
 */
class Category extends \Core\Controller
{
     /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderTemplate('Profile/showeditcategory.html');
    }
    
    /**
     * Show the edit page
     *
     * @return void
     */
    public function updateincomescategoryAction()
    {
        $category = new Categories;
        if (Categories::editIncomesCategory($_POST)) {
            Flash::addMessage('Changes saved');
            $this->redirect('/profile/showeditcategory');
        }
        else $this->redirect('/profile/editcategory');
    }

     /**
     * Show the edit page
     *
     * @return void
     */
    public function updateexpensescategoryAction()
    {
        $category = new Categories;
        if (Categories::editExpensesCategory($_POST)) {
            Flash::addMessage('Changes saved');
            $this->redirect('/profile/showeditcategory');
        }
        else $this->redirect('/profile/editexpensescategory');
    }

    /**
     * Delete the incomes category
     *
     * @return void
     */
    public function deleteincomescategoryAction()
    {
        $categoryName = $_GET['categoryName'];
        $category = new Categories;
        $incomesAssignedToCategory = Categories::checkIfTheCategoryHasIncome($categoryName);
        if(!empty(Categories::checkIfTheCategoryHasIncome($categoryName))){
            View::renderTemplate('Category/deleteincomescategory.html', [
                'incomesAssignedToCategory' => $incomesAssignedToCategory,
                'categoryName' => $categoryName,
            ]);
        } else {
        if (Categories::deleteIncomesCategory($categoryName)) {
            Flash::addMessage('Category deleted');
            $this->redirect('/profile/showeditcategory');
        }
        else $this->redirect('/profile/editcategory');
    }
    }

    /**
     * Executing delete the incomes category
     *
     * @return void
     */
    public function executedeleteincomescategoryAction()
    {
        $categoryName = $_POST['categoryName'];
        $category = new Categories;
        
        if (Categories::deleteIncomesCategory($categoryName)) {
            Flash::addMessage('Category deleted');
            $this->redirect('/profile/showeditcategory');
        }
        else $this->redirect('/profile/editcategory');
    
    }

     /**
     * Delete the expenses category
     *
     * @return void
     */
    public function deleteexpensescategoryAction()
    {
        $categoryName = $_GET['categoryName'];
        $category = new Categories;
        $expensesAssignedToCategory = Categories::checkIfTheCategoryHasExpense($categoryName);
        if (!empty(Categories::checkIfTheCategoryHasExpense($categoryName))) {
            View::renderTemplate('Category/deleteexpensescategory.html', [
                'expensesAssignedToCategory' => $expensesAssignedToCategory,
                'categoryName' => $categoryName,
            ]);
        } else {
        if (Categories::deleteExpensesCategory($categoryName)) {
            Flash::addMessage('Category deleted');
            $this->redirect('/profile/showeditcategory');
        }
        else $this->redirect('/profile/editcategory');
    }
    }

       /**
     * Executing delete the expenses category
     *
     * @return void
     */
    public function executedeleteexpensescategoryAction()
    {
        $categoryName = $_POST['categoryName'];
        $category = new Categories;
        
        if (Categories::deleteExpensesCategory($categoryName)) {
            Flash::addMessage('Category deleted');
            $this->redirect('/profile/showeditcategory');
        }
        else $this->redirect('/profile/editcategory');
    
    }

     /**
     * Add the incomes category
     *
     * @return void
     */
    public function addincomescategoryAction()
    {   
        View::renderTemplate('Category/addincomescategory.html');
    }

    /**
     * Add the expenses category
     *
     * @return void
     */
    public function addexpensescategoryAction()
    {   
        View::renderTemplate('Category/addexpensescategory.html');
    }

    
    public function updateaddedincomescategoryAction()
    {   
        $categoryName = $_POST['nameOfCategory'];
        $category = new Categories;
        if (Categories::addIncomesCategory($categoryName)) {
            Flash::addMessage('Category added');
            $this->redirect('/profile/showeditcategory');
        }
        else $this->redirect('/profile/editincomescategory');
    }

        
    public function updateaddedexpensescategoryAction()
    {   
        $categoryName = $_POST['nameOfCategory'];
        if (isset($_POST['limit'])) {
            $limit = $_POST['limitValue'];
        } else {
            $limit = 0 ;
        }
        $category = new Categories;
        if (Categories::addExpensesCategory($categoryName, $limit)) {
            Flash::addMessage('Category added');
            $this->redirect('/profile/showeditcategory');
        }
        else $this->redirect('/profile/editexpensescategory');
    }


    public function showeditpaymentmethodsAction()
    {
        $category = new Categories;
        $paymentMethods = Categories::getPaymentMethods();

        View::renderTemplate('Category/showeditpaymentmethods.html',[
            'paymentMethods' => $paymentMethods,
        ]);

    }


       /**
     * Show the edit page
     *
     * @return void
     */
    public function updatepaymentmethodAction()
    {
        $category = new Categories;
        if (Categories::editPaymentMethod($_POST)) {
            Flash::addMessage('Changes saved');
            $this->redirect('/category/showeditpaymentmethods');
        }
        else $this->redirect('/category/editpaymentmethods');
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


    
     /**
     * Delete the payment method
     *
     * @return void
     */
    public function deletepaymentmethodAction()
    {
        $paymentMethodName = $_GET['paymentMethod'];
        $category = new Categories;
        $expensesAssignedToPaymentMethod = Categories::checkIfThePaymentMethodHasExpense($paymentMethodName);
        if (!empty(Categories::checkIfThePaymentMethodHasExpense($paymentMethodName))) {
            View::renderTemplate('Category/deletepaymentmethodname.html', [
                'expensesAssignedToPaymentMethod' => $expensesAssignedToPaymentMethod,
                'paymentMethodName' => $paymentMethodName,
            ]);
        } else {
        if (Categories::deletePaymentMethod($paymentMethodName)) {
            Flash::addMessage('Payment method deleted');
            $this->redirect('/category/showeditpaymentmethods');
        }
        else $this->redirect('/category/editpaymentmethod');
    }
    }

    /**
     * Executing delete the payment method
     *
     * @return void
     */
    public function executedeletepaymentmethodAction()
    {
        $paymentMethodName = $_POST['paymentMethodName'];
        $category = new Categories;
        
        if (Categories::deletePaymentMethod($paymentMethodName)) {
            Flash::addMessage('Payment method deleted');
            $this->redirect('/category/showeditpaymentmethods');
        }
        else $this->redirect('/category/editpaymentmethod');
    
    }
    

        /**
     * Add the expenses category
     *
     * @return void
     */
    public function addpaymentmethodAction()
    {   
        View::renderTemplate('Category/addpaymentmethod.html');
    }


    public function updateaddedpaymentmethodAction()
    {   
        $categoryName = $_POST['nameOfPaymentMethod'];
        $category = new Categories;
        if (Categories::addPaymentMethod($categoryName)) {
            Flash::addMessage('Category added');
            $this->redirect('/category/showeditpaymentmethods');
        }
        else $this->redirect('/category/editpaymentmethod');
    }
}