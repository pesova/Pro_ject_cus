<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Customer;

class CustomerCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $this->collection->transform(function (Customer $customer) {
            return (new Customer($customer))->additional($this->additional);
        });

        return [
            'status' => 'success',
            'message' => 'ok. Successful',
            'data' => $this->collection,
            'recordsFiltered' => $this->collection->count(),
        ];
    }
}
