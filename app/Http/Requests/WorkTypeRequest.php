<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkTypeRequest extends FormRequest
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
        if(in_array($this->method(), ['PUT', 'PATCH'])){
            $id = $this->segment(2);
        }
        return [
            'name' => 'required|max:255|unique:work_types,name'.(isset($id)?','.$id:''),
            'equipment_type_id' => 'integer|nullable'
        ];
    }
}
