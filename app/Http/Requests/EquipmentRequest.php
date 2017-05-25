<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class EquipmentRequest extends FormRequest
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
            'inventory_number' => 'required|max:100|unique:equipments,inventory_number'.(isset($id)?','.$id:''),
            'name' => 'required|max:100',
            'equipment_type_id' => 'required|integer'
        ];
    }
}
