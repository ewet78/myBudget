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
class Balance extends \Core\Model
{

    /**
     * Get all the incomes as an associative array
     *
     * @return array
     */
    public static function getIncomes($data)
    {  

        if ($data['zakresDat'] === 'currentMonth')
        {
            $Month = date('m');
            $Year = date('Y');
            $start_date = $Year. '-' . $Month . '-01';
            if ($Month == '01' || $Month == '03' || $Month == '05' || $Month == '07' || $Month == '08' || $Month == '10' || $Month == '12') {
                $end_date = $Year. '-' . $Month . '-31';
            }
            if ($Month == '04' || $Month == '06' || $Month == '09' || $Month == '11') {
                $end_date = $Year. '-' . $Month . '-30';
            }
            if ($Month == '02')
            {
                if(($Year%4==0 && $Year%100!=0) || $Year%400==0) {
                    $end_date = $Year. '-' . $Month . '-29';
                } else {
                    $end_date = $Year. '-' . $Month . '-28';
                }
            }

        }

        if ($data['zakresDat'] === 'previousMonth')
        {
            $Month = date('m');
            $Year = date('Y');
            if ($Month == '01') {
                $Month = '12';
                $Year--;
            } else {
                $Month--;
                if ($Month != '10' || $Month != '11' || $Month != '12'){
                    $Month = '0' . $Month;
                }
            }

            $start_date = $Year. '-' . $Month . '-01';

            if ($Month == '01' || $Month == '03' || $Month == '05' || $Month == '07' || $Month == '08' || $Month == '10' || $Month == '12') {
                $end_date = $Year. '-' . $Month . '-31';
            }
            if ($Month == '04' || $Month == '06' || $Month == '09' || $Month == '11') {
                $end_date = $Year. '-' . $Month . '-30';
            }
            if ($Month == '02')
            {
                if(($Year%4==0 && $Year%100!=0) || $Year%400==0) {
                    $end_date = $Year. '-' . $Month . '-29';
                } else {
                    $end_date = $Year. '-' . $Month . '-28';
                }
            }
            

        }

        if ($data['zakresDat'] === 'currentYear')
        {
            $Year = date('Y');
            
            $start_date = $Year. '-01-01';
            $end_date = $Year. '-12-31';

        }

        if ($data['zakresDat'] === 'another')
        {
            View::renderTemplate('Balance/indexmodal.html');
            exit();           

        }
        
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

        if ($data['zakresDat'] === 'currentMonth')
        {
            $Month = date('m');
            $Year = date('Y');
            $start_date = $Year. '-' . $Month . '-01';
            if ($Month == '01' || $Month == '03' || $Month == '05' || $Month == '07' || $Month == '08' || $Month == '10' || $Month == '12') {
                $end_date = $Year. '-' . $Month . '-31';
            }
            if ($Month == '04' || $Month == '06' || $Month == '09' || $Month == '11') {
                $end_date = $Year. '-' . $Month . '-30';
            }
            if ($Month == '02')
            {
                if(($Year%4==0 && $Year%100!=0) || $Year%400==0) {
                    $end_date = $Year. '-' . $Month . '-29';
                } else {
                    $end_date = $Year. '-' . $Month . '-28';
                }
            }

        }

        if ($data['zakresDat'] === 'previousMonth')
        {
            $Month = date('m');
            $Year = date('Y');
            if ($Month == '01') {
                $Month = '12';
                $Year--;
            } else {
                $Month--;
                if ($Month != '10' || $Month != '11' || $Month != '12'){
                    $Month = '0' . $Month;
                }
            }

            $start_date = $Year. '-' . $Month . '-01';

            if ($Month == '01' || $Month == '03' || $Month == '05' || $Month == '07' || $Month == '08' || $Month == '10' || $Month == '12') {
                $end_date = $Year. '-' . $Month . '-31';
            }
            if ($Month == '04' || $Month == '06' || $Month == '09' || $Month == '11') {
                $end_date = $Year. '-' . $Month . '-30';
            }
            if ($Month == '02')
            {
                if(($Year%4==0 && $Year%100!=0) || $Year%400==0) {
                    $end_date = $Year. '-' . $Month . '-29';
                } else {
                    $end_date = $Year. '-' . $Month . '-28';
                }
            }
            

        }

        if ($data['zakresDat'] === 'currentYear')
        {
            $Year = date('Y');
            
            $start_date = $Year. '-01-01';
            $end_date = $Year. '-12-31';

        }

        if ($data['zakresDat'] === 'another')
        {
            View::renderTemplate('Balance/indexmodal.html');
            exit();           

        }
        
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
