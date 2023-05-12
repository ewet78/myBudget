<?php

namespace App\Models;

use PDO;
use App\Auth;
use Core\View;

/**
 * Post model
 *
 * PHP version 7.4
 */
class BalanceRange extends \Core\Model
{

    /**
     * Get all the incomes as an associative array
     *
     * @return array
     */
    public static function getIncomes($data)
    {  

      $start_date = $data['start_date'];
      $end_date = $data['end_date'];
        
        try {
            //$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",
            //              $username, $password);
            $user_id = Auth::getUser()->id;

            $db = static::getDB();

            $sql = 'SELECT SUM(incomes.amount) "suma_przychodów", incomes_category_assigned_to_users.name "nazwa_kategorii"
                    FROM incomes
                    INNER JOIN incomes_category_assigned_to_users ON incomes.income_category_assigned_to_user_id = incomes_category_assigned_to_users.id
                    WHERE incomes.user_id = :id AND incomes.date_of_income BETWEEN :start_date AND :end_date
                    GROUP BY incomes.income_category_assigned_to_user_id
                    ORDER BY "suma przychodów" DESC';

            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':start_date', $start_date, PDO::PARAM_STR);
            $stmt->bindValue(':end_date', $end_date, PDO::PARAM_STR);

            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    /**
     * Get all the expenses as an associative array
     *
     * @return array
     */
    public static function getExpenses($data)
    {  
        
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];
        
        
        try {
            //$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",
            //              $username, $password);
            $user_id = Auth::getUser()->id;

            $db = static::getDB();

            $sql = 'SELECT SUM(expenses.amount) "suma_wydatków", expenses_category_assigned_to_users.name "nazwa_kategorii"
                    FROM expenses
                    INNER JOIN expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id
                    WHERE expenses.user_id = :id AND expenses.date_of_expense BETWEEN :start_date AND :end_date
                    GROUP BY expenses.expense_category_assigned_to_user_id
                    ORDER BY "suma_wydatków" DESC';

            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':start_date', $start_date, PDO::PARAM_STR);
            $stmt->bindValue(':end_date', $end_date, PDO::PARAM_STR);

            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

 
}
