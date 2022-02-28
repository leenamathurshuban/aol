<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Response;

class JsonController extends Controller
{
    public function isResult($reponse = null, $msg, $array = array()) {
    	if($reponse) {
    		return $this->respondWithJson([
    			'status' => $reponse,
    			'message' => $msg,
    			'data' => $array
			]);
    	} else {
    		return [
    			'status' => $reponse,
    			'message' => $msg,
                'data' => $array
    		];
    	}
    }

    public function isRequired($input = array(), $requiredParameter = array()) {
    	$contains = Arr::has($input, $requiredParameter);
    	if($contains) {
    		return 1;
    	} else {
    		return [
    			'status' => 0,
    			'message' => 'Required Parameter Missing.'
    		];
    	}
    }

    public function validateError($validator) {
        return [
            'status' => 0,
            'message' => $validator->errors()->all()
        ];
    }

    public function respondWithJson($data) {
    	$options = ['accept-charset' => 'utf-8'];
    	return response()->json($data, 200, $options, JSON_UNESCAPED_SLASHES);
	}

	/*public function filePath($path=null) {
        
        if ($path) {
            return url('public/'.$path);
        }else{
           return url('public').'/'; 
        }
    }*/

    public function checkNull($value='')
    {
        if ($value) {
            return $value;
        }else{
            return '';
        }
    }
}
