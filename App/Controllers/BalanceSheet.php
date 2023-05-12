<?php

namespace App\Controllers;

use \Core\View;
use App\Models\Balance;

/**
 * Balance controller
 *
 * PHP version 8.2
 */
class BalanceSheet extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderTemplate('Balance/index.html');
    }

    /**
     * Show the balance sheet
     *
     * @return void
     */
    public function showAction()
    {
        $balance = new Balance($_POST);

        $balanceIncomes = Balance::getIncomes($_POST);
        $balanceExpenses = Balance::getExpenses($_POST);

        View::renderTemplate('Balance/show.html', [
            'incomes' => $balanceIncomes,
            'expenses' => $balanceExpenses
        ]);
    }
    
    /**
     * Show the edit page
     *
     * @return void
     */
    public function editAction()
    {
        echo 'Hello from the edit action in the Posts controller!';
        echo '<p>Route parameters: <pre>' .
             htmlspecialchars(print_r($this->route_params, true)) . '</pre></p>';
    }
}
