<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BulkCsvUpload extends Model
{
    public function bulkUpload($value='')
    {
    	return $this->hasOne('\App\BulkUpload','id','bulk_upload_id');
    }
}
