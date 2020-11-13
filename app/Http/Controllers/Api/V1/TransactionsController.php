<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionCollection;
use App\Models\Transactions;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransactionsController extends Controller
{
    protected $user_id;
    protected $user_role;

    public function __construct(Request $request)
    {
        $this->user_id = $request['request_user_id'];
        $this->user_role = $request['request_user_role'];
    }

    public function index(Request $request, $store_id, $type)
    {
        if ($this->user_role == 'super_admin') {
            $store_id = '';
        }

        $start          = (int) $request->get('start') ?? 0;
        $length         = (int) $request->get('length') ?? 10;
        $draw           = (int) $request->get('draw') ?? 1;
        $search         = $request->get('search');
        $search         = isset($search['value']) ? (string) $search['value'] : '';

        try {
            $result = Transactions::ofStore($store_id)
                ->ofType($type)
                ->search($search)
                ->skip($start)
                ->take($length)
                ->get();

            $recordsTotal = Transactions::ofStore($store_id)->count();
        } catch (Exception $e) {
            Log::error('API TransactionsController - ' . $e->getMessage());
            return api_error_response($e);
        }

        return (new TransactionCollection($result ?? []))
            ->additional([
                'draw' => $draw + 1,
                'recordsTotal' => $recordsTotal ?? 0,
            ]);
    }

    public function debts(Request $request, $store_id)
    {
        return $this->index($request, $store_id, 'debt');
    }

    public function payments(Request $request, $store_id)
    {
        return $this->index($request, $store_id, 'paid');
    }

    public function credits(Request $request, $store_id)
    {
        return $this->index($request, $store_id, 'credit');
    }
}
