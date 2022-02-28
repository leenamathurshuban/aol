<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class CityRequest extends FormRequest
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
        $name=$this->name;
        $state=$this->state;
        $data=\App\City::where('slug',$this->slug)->first();
        $c_id=$data->id ?? '';
        return [
                'name'=>['required',
                             Rule::unique('cities')->where(function ($query) use($name,$state,$c_id) {
                               return $query->where(['name'=> $name,'state_id'=>$state])->where('id','!=', $c_id);
                             })
                         ],
                'state'=>'required|numeric',
                'image'=>'mimes:jpeg,png,jpg,gif,svg|max:2048'];
    }
}
