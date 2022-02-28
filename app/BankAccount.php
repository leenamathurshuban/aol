<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
	public static function bnkHeadOfcPluck($value='')
    {
    	return BankAccount::where('apexe_id',5)->pluck('bank_account_number','bank_account_number');
    }
    public static function bnkHeadOfcWidIdPluck($value='')
    {
    	return BankAccount::where('apexe_id',5)->pluck('bank_account_number','id');
    }
    public static function bnkPluck($value='')
    {
    	return BankAccount::pluck('bank_account_number','bank_account_number');
    }
}
