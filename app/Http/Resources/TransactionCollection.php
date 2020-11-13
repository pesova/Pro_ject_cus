<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function (Transaction $transaction) {
            return (new Transaction($transaction))->additional($this->additional);
        });

        return [
            'status' => 'success',
            'message' => 'ok. Successful',
            'data' => $this->collection,
            'recordsFiltered' => $this->collection->count(),
        ];
    }
}
