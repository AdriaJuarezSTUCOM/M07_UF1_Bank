<?php namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:22 PM
 */

use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class WithdrawTransaction  extends BaseTransaction implements BankTransactionInterface 
{
    private $amountWithdraw;

    public function __construct($amount){
        parent::validateAmount($amount);
        $this->amountWithdraw = $amount;
    }
    public function applyTransaction(BackAccountInterface $account) : float{
        $newBalance = $account->getBalance() - $this->amountWithdraw;
        $account->setBalance($newBalance);
        return $newBalance;
    }
    public function getTransactionInfo() : string{
        return "WITHDRAW_TRANSACTION";
    }
    public function getAmount() : float{
        return $this->amountWithdraw;
    }
}
