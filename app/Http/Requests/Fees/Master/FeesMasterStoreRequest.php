<?php

namespace App\Http\Requests\Fees\Master;

use App\Enums\FineType;
use Illuminate\Foundation\Http\FormRequest;

class FeesMasterStoreRequest extends FormRequest
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
     * fees_group_id
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if(Request()->fine_type == FineType::NONE){
            return [
                'fees_type_id'      => 'required|max:25',
                'fees_group_id'     => 'required|max:25',
                'due_date'          => 'required|max:25',
                'amount'            => 'required|max:10',
                'fine_type'         => 'required|max:10',
            ];
        }
        elseif(Request()->fine_type == FineType::PERCENTAGE){
            return [
                'fees_type_id'      => 'required|max:25',
                'fees_group_id'     => 'required|max:25',
                'due_date'          => 'required|max:25',
                'amount'            => 'required|max:10',
                'fine_type'         => 'required|max:10',
                'percentage'        => 'required|max:10',
                'fine_amount'       => 'required|max:10'
            ];
        }
        elseif(Request()->fine_type == FineType::FIX_AMOUNT){
            return [
                'fees_type_id'      => 'required|max:25',
                'fees_group_id'     => 'required|max:25',
                'due_date'          => 'required|max:25',
                'amount'            => 'required|max:10',
                'fine_type'         => 'required|max:10',
                'fine_amount'       => 'required|max:10'
            ];
        }
    }
}
