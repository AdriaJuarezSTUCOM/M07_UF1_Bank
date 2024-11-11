<?php namespace ComBank\Bank;

use ComBank\Bank\BankAccount;

class NationalBankAccount extends BankAccount{
    public function __construct($balance = 100){
        parent::__construct($balance);
        $this->currency = "€ (Euros)";
    }
}