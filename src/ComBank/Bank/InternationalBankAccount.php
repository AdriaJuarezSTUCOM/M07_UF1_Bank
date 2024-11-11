<?php namespace ComBank\Bank;

use ComBank\Bank\BankAccount;
use ComBank\Support\Traits\APITrait;

class InternationalBankAccount extends BankAccount{

    use APITrait;

    public function __construct($balance = 100){
        parent::__construct($balance);
        $this->currency = "$ (USD)";
    }

    public function getConvertedBalance() : float{
        return $this->convertBalance($this->balance);
    }

    public function getConvertedCurrency() : string{
        return ($this->getConvertedBalance() . " " . $this->currency);
    }
}