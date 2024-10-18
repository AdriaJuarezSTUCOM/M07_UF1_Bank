<?php namespace ComBank\Bank;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:25 PM
 */

use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\InvalidArgsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\OverdraftStrategy\NoOverdraft;
use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;
use ComBank\Support\Traits\AmountValidationTrait;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use PHPUnit\TextUI\XmlConfiguration\ValidationResult;

use function PHPUnit\Framework\throwException;

class BankAccount implements BackAccountInterface
{
    private $balance;
    private $status;
    private $overdraft;
    
    public function __construct($balance) {
        
        $this->balance = $balance;
        $this->status = BackAccountInterface::STATUS_OPEN;
        $this->overdraft = new NoOverdraft;

    }

    public function transaction(BankTransactionInterface $transaction):void{
        $this->status==BackAccountInterface::STATUS_CLOSED
            ? throw new BankAccountException("Cuenta cerrada")
            : $transaction->applyTransaction($this);
    }

    public function openAccount() : bool{
        return $this->status == BackAccountInterface::STATUS_OPEN;
    }
    public function reopenAccount() : void{
        if($this->status == BackAccountInterface::STATUS_OPEN){
            throw new BankAccountException("Account is already open");
        }else{
            $this->status = BackAccountInterface::STATUS_OPEN;
        }
    }
    public function closeAccount() : void{
        $this->status = BackAccountInterface::STATUS_CLOSED;
    }
    public function getBalance() : float{
        return $this->balance;
    }
    public function getOverdraft() : OverdraftInterface{
        return $this->overdraft;
    }
    public function applyOverdraft(OverdraftInterface $overdraft) : void{
        $this->overdraft=$overdraft;
    }
    public function setBalance(float $balance) : void{
        $this->balance = $balance;
    }
} 