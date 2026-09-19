<?php

namespace Modules\MainApp\Http\Requests\Package;

use App\Enums\PricingDuration;
use Illuminate\Foundation\Http\FormRequest;
use Modules\MainApp\Enums\PackagePaymentType;

class StoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {

        $price         = 'required';
        $student_limit = 'required';
        $staff_limit   = 'required';
        $duration      = 'required';
        $duration_number = 'required';
        $features        = 'required';

        $per_student_price        = 'required';

        if($this->payment_type == PackagePaymentType::PREPAID) {

            $per_student_price        = 'nullable';

            $price         = 'required';
            $student_limit = 'required';
            $staff_limit   = 'required';
            $duration      = 'required';
            $duration_number = 'required';
            $features        = 'required';

        } elseif($this->payment_type == PackagePaymentType::POSTPAID) {
            $per_student_price        = 'required';

            $price         = 'nullable';
            $student_limit = 'nullable';
            $staff_limit   = 'nullable';
            $duration      = 'nullable';
            $duration_number = 'nullable';
            $features        = 'nullable';
        }

        if($this->duration == PricingDuration::LIFETIME) {
            $duration_number = 'nullable';
        }

        return [
            'payment_type'             => 'required',
            'name'             => 'required|max:255|unique:packages,name',
            'price'            => $price,
            'student_limit'    => $student_limit,
            'staff_limit'      => $staff_limit,
            'duration'         => $duration,
            'duration_number'  => $duration_number,
            'description'      => 'required',
            'popular'          => 'required',
            'features'         => $features,

            'per_student_price'         => $per_student_price
        ];
    }
}
