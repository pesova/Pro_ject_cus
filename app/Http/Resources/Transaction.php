<?php

namespace App\Http\Resources;

use App\Models\Customers;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class Transaction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            '_id' => $this->_id,
            'description' => $this->description,
            'status' => $this->status,
            'type' => $this->type,
            'amount' => $this->amount,
            'interest' => $this->interest ?? 0,
            'total_amount' => $this->total_amount ?? $this->amount,
            'date_recorded' => $this->date_recorded->__toString(),
            'store_id' => $this->store_ref_id->__toString(),
            'customer_id' => $this->customer_ref_id->__toString(),
            'store_admin_id' => $this->store_admin_ref->__toString(),
            'expected_pay_date' =>  is_null($this->expected_pay_date) ? '' : $this->expected_pay_date->__toString(),
            'customer' => new Customer(Customers::find($this->customer_ref_id)),
            // 'store' => (stores::find($this->customer_ref_id)),
        ];
    }
}
