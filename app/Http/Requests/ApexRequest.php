<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $data=\App\Apex::where('slug',$this->slug)->first();
        $id=$data->id ?? '';
        return [
                'name'=>'required|unique:apexes,name,'.$id
            ];
    }
}
