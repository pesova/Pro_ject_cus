<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Customer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            '_id' => $this->_id,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'store_id' => $this->store_ref_id->__toString(),
            'createdAt' => Carbon::createFromTimestamp($this->createdAt->__toString())->toDateTimeString(),
        ];
    }
}
