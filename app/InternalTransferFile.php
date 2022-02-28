<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternalTransferFile extends Model
{
    public function internalTransferDetail($value='')
    {
    	return $this->hasOne('\App\InternalTransfer','id','internal_transfer_id');
    }
}
