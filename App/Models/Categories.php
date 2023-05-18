<?php

namespace App\Models;

use PDO;
use App\Auth;
use Core\View;
use App\Flash;
use App\Controllers\Category;

/**
 * Categories model
 *
 * PHP version 8.2
 */
class Categories extends \Core\Model
{
    /**
     * Get all the incomes categories
     *
     * @return array
     */
    public static function getIncomesCategories()
    {
        try {
            //$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",
            //              $username, $password);
            $user_id = Auth::getUser()->id;

            $db = static::getDB();

            $sql = 'SELECT incomes_category_assigned_to_users.name "kategorie_przychodów"
                    FROM incomes_category_assigned_to_users 
                    WHERE incomes_category_assigned_to_users.user_id = :id 
                    ORDER BY kategorie_przychodów ASC';

            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);

            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getExpensesCategories()
    {
        try {
            //$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",
            //              $username, $password);
            $user_id = Auth::getUser()->id;

            $db = static::getDB();

            $sql = 'SELECT expenses_category_assigned_to_users.name "kategorie_wydatków"
                    FROM expenses_category_assigned_to_users 
                    WHERE expenses_category_assigned_to_users.user_id = :id 
                    ORDER BY kategorie_wydatków ASC';

            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);

            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    /**
     * Edit category
     *
     * @return boolean True if the data was updated, false otherwise
     */
    public static function editIncomesCategory($data)
    {
        if (isset($data['nameOfCategory'])){
            $name = $data['nameOfCategory'];
            $oldName = $data['oldCategoryName'];
            $user_id = Auth::getUser()->id;
            $idOfCategory = User::getIdOfIncomeCategory($oldName, $user_id);

            $sql = 'UPDATE incomes_category_assigned_to_users
                    SET name = :name
                    WHERE id=:idOfCategory';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':idOfCategory', $idOfCategory, PDO::PARAM_INT);

            return $stmt->execute();
    }
    else return false;
}

    /**
     * Edit category
     *
     * @return boolean True if the data was updated, false otherwise
     */
    public static function editExpensesCategory($data)
    {
        if (isset($data['nameOfCategory'])){
            $name = $data['nameOfCategory'];
            $oldName = $data['oldCategoryName'];
            $user_id = Auth::getUser()->id;
            $idOfCategory = User::getIdOfExpenseCategory($oldName, $user_id);

            $sql = 'UPDATE expenses_category_assigned_to_users
                    SET name = :name
                    WHERE id=:idOfCategory';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':idOfCategory', $idOfCategory, PDO::PARAM_INT);

            return $stmt->execute();
    }
    else return false;
}


    /**
     * Delete category
     *
     * @return boolean True if the data was updated, false otherwise
     */
    public static function deleteIncomesCategory($categoryName)
    {
            $user_id = Auth::getUser()->id;
            $idOfCategory = User::getIdOfIncomeCategory($categoryName, $user_id);

            $sql = 'DELETE FROM incomes_category_assigned_to_users
                    WHERE id=:idOfCategory';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            
            $stmt->bindValue(':idOfCategory', $idOfCategory, PDO::PARAM_INT);

            return $stmt->execute();
    
    

    }

        /**
     * Delete category
     *
     * @return boolean True if the data was updated, false otherwise
     */
    public static function deleteExpensesCategory($categoryName)
    {
            $user_id = Auth::getUser()->id;
            $idOfCategory = User::getIdOfExpenseCategory($categoryName, $user_id);

            $sql = 'DELETE FROM expenses_category_assigned_to_users
                    WHERE id=:idOfCategory';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            
            $stmt->bindValue(':idOfCategory', $idOfCategory, PDO::PARAM_INT);

            return $stmt->execute();
    
    }

    /**
     * Delete category
     *
     * @return boolean True if the data was updated, false otherwise
     */
    public static function addIncomesCategory($categoryName)
    {       
            $user_id = Auth::getUser()->id;

            if (self::ifIncomesCategoryExists($categoryName, $user_id)) {
                Flash::addMessage('Category already exists');
                $category = new Category($categoryName);
                $category->redirect('/category/addincomescategory');

            } else {

            $sql = 'INSERT INTO incomes_category_assigned_to_users (user_id, name)
                    VALUES (:user_id, :categoryName)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);

            return $stmt->execute();
            }

    }

     /**
     * Add expenses category
     *
     * @return boolean True if the data was updated, false otherwise
     */
    public static function addExpensesCategory($categoryName)
    {
            $user_id = Auth::getUser()->id;

            if (self::ifExpensesCategoryExists($categoryName, $user_id)) {
                Flash::addMessage('Category already exists');
                $category = new Category($categoryName);
                $category->redirect('/category/addexpensescategory');

            } else {

            $sql = 'INSERT INTO expenses_category_assigned_to_users (user_id, name)
                    VALUES (:user_id, :categoryName)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);

            return $stmt->execute();
            }
    

    }

    public static function ifIncomesCategoryExists($categoryName, $id)
    {

        $sql = 'SELECT incomes_category_assigned_to_users.name
                FROM incomes_category_assigned_to_users 
                WHERE incomes_category_assigned_to_users.name = :categoryName AND incomes_category_assigned_to_users.user_id = :id';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        
        $stmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $result = $stmt->fetch();
            return $result !== false; // Return true if the fetch result is not false (not null)
        } else {
            return false; // Return false if execute() returns false
        }
    
    }

    public static function ifExpensesCategoryExists($categoryName, $id)
    {

        $sql = 'SELECT expenses_category_assigned_to_users.name
                FROM expenses_category_assigned_to_users 
                WHERE expenses_category_assigned_to_users.name = :categoryName AND expenses_category_assigned_to_users.user_id = :id';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        
        $stmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $result = $stmt->fetch();
            return $result !== false; // Return true if the fetch result is not false (not null)
        } else {
            return false; // Return false if execute() returns false
        }
    
    }

     /**
     * Get all the payment methods
     *
     * @return array
     */
    public static function getPaymentMethods()
    {
        try {
            //$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",
            //              $username, $password);
            $user_id = Auth::getUser()->id;

            $db = static::getDB();

            $sql = 'SELECT payment_methods_assigned_to_users.name "metody_płatności"
                    FROM payment_methods_assigned_to_users 
                    WHERE payment_methods_assigned_to_users.user_id = :id 
                    ORDER BY metody_płatności ASC';

            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);

            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    /**
     * Edit payment method
     *
     * @return boolean True if the data was updated, false otherwise
     */
    public static function editPaymentMethod($data)
    {
        if (isset($data['nameOfPaymentMethod'])){
            $name = $data['nameOfPaymentMethod'];
            $oldName = $data['oldPaymentMethodName'];
            $user_id = Auth::getUser()->id;
            $idOfPaymentMethod = User::getIdOfPaymentMethod($oldName, $user_id);

            $sql = 'UPDATE payment_methods_assigned_to_users
                    SET name = :name
                    WHERE id=:idOfPaymentMethod';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':idOfPaymentMethod', $idOfPaymentMethod, PDO::PARAM_INT);

            return $stmt->execute();
    }
    else return false;
}


        /**
     * Delete category
     *
     * @return boolean True if the data was updated, false otherwise
     */
    public static function deletePaymentMethod($paymentMethodName)
    {
            $user_id = Auth::getUser()->id;
            $idOfPaymentMethod = User::getIdOfPaymentMethod($paymentMethodName, $user_id);

            $sql = 'DELETE FROM payment_methods_assigned_to_users
                    WHERE id=:idOfPaymentMethod';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            
            $stmt->bindValue(':idOfPaymentMethod', $idOfPaymentMethod, PDO::PARAM_INT);

            return $stmt->execute();
    
    }


    
     /**
     * Add payment method
     *
     * @return boolean True if the data was updated, false otherwise
     */
    public static function addPaymentMethod($nameOfPaymentMethod)
    {
            $user_id = Auth::getUser()->id;

            if (self::ifPaymentMethodExists($nameOfPaymentMethod, $user_id)) {
                Flash::addMessage('Payment method already exists');
                $category = new Category($nameOfPaymentMethod);
                $category->redirect('/category/addpaymentmethod');

            } else {

            $sql = 'INSERT INTO payment_methods_assigned_to_users (user_id, name)
                    VALUES (:user_id, :nameOfPaymentMethod)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':nameOfPaymentMethod', $nameOfPaymentMethod, PDO::PARAM_STR);

            return $stmt->execute();
            }
    

    }


    public static function ifPaymentMethodExists($nameOfPaymentMethod, $id)
    {

        $sql = 'SELECT payment_methods_assigned_to_users.name
                FROM payment_methods_assigned_to_users 
                WHERE payment_methods_assigned_to_users.name = :nameOfPaymentMethod AND payment_methods_assigned_to_users.user_id = :id';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        
        $stmt->bindValue(':nameOfPaymentMethod', $nameOfPaymentMethod, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $result = $stmt->fetch();
            return $result !== false; // Return true if the fetch result is not false (not null)
        } else {
            return false; // Return false if execute() returns false
        }
    
    }
}