<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerCollection;
use App\Models\Customers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomersController extends Controller
{
    protected $user_id;
    protected $user_role;

    public function __construct(Request $request)
    {
        $this->user_id = $request['request_user_id'];
        $this->user_role = $request['request_user_role'];
    }

    public function index(Request $request, $store_id)
    {
        if ($this->user_role == 'super_admin') {
            $store_id = '';
        }

        $start          = (int) $request->get('start') ?? 0;
        $length         = (int) $request->get('length') ?? 10;
        $draw           = (int) $request->get('draw') ?? 1;
        $search         = $request->get('search');
        $search         = isset($search['value']) ? (string) $search['value'] : '';;

        try {
            $result = Customers::ofStore($store_id)
                ->search($search)
                ->skip($start)
                ->take($length)
                ->get();

            $recordsTotal = Customers::ofStore($store_id)->count();
        } catch (Exception $e) {
            Log::error('API CustomersController - ' . $e->getMessage());
            return api_error_response($e);

        }

        $result = (new CustomerCollection($result ?? []))
            ->additional([
                'draw' => $draw + 1,
                'recordsTotal' => $recordsTotal ?? 0,
            ]);
        return $result;
    }
}
