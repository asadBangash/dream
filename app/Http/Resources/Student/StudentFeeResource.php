<?php

namespace App\Http\Resources\Student;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentFeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $fineAmount = 0;

        if(date('Y-m-d') > @$this->feesMaster->due_date) {
            $fineAmount = (float) @$this->feesMaster->fine_amount;
        }

        $status = @$this->feesCollect->created_at ? 'Paid' : 'Unpaid';

        return [
            'fee_assign_children_id'    => $this->id,
            'title'                     => @$this->feesMaster->type->name,
            'slug'                      => Str::slug(@$this->feesMaster->type->name) . '-' . $this->id,
            'amount'                    => (float) @$this->feesMaster->amount,
            'fine_amount'               => $fineAmount,
            'total_amount'              => @$this->feesMaster->amount + $fineAmount,
            'currency_symbol'           => Setting('currency_symbol'),
            'due_date'                  => date('d M Y', strtotime(@$this->feesMaster->due_date)),
            'paid_at'                   => $status == 'Paid' ? date('d M Y', strtotime(@$this->feesCollect->created_at)) : null,
            'status'                    => $status,
            'payment_gateway'           => $status == 'Paid' ? @$this->feesCollect->payment_gateway : null,
        ];
    }
}
