<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderFile extends Model
{
    public function poDetail($value='')
    {
    	return $this->hasOne('\App\PurchaseOrder','id','po_id');
    }
}
