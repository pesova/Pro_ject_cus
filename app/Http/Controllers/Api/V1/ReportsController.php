<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Customer;
use App\Http\Resources\ReportCollection;
use App\Http\Resources\TransactionCollection;
use App\Models\Customers;
use App\Models\Stores;
use App\Models\Transactions;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportsController extends Controller
{
    public function StoreReport(Request $request, $store_id)
    {

        $length = (int) $request->get('length') ?? 10;
        $result = [];

        try {
            $paidTransactionReport = Transactions::groupby('currency')->perStoreCurrency('paid', $store_id);
            $debtTransactionReport = Transactions::groupby('currency')->perStoreCurrency('debt', $store_id);
            $creditTransactionReport = Transactions::groupby('currency')->perStoreCurrency('credit', $store_id);
            // $creditDebtTransactionReport = Transactions::groupby('currency')->perStoreCurrency('credit_ebt', $store_id);

            $latestTransactions = Transactions::orderBy('date_recorded', 'desc')
                ->take($length)
                ->get();

            $store = Stores::find($store_id);
            $result = [
                'debts' => $debtTransactionReport,
                'paids' => $paidTransactionReport,
                'credits' => $creditTransactionReport,
                'latest_transactions' => (new TransactionCollection($latestTransactions)),
            ];
        } catch (Exception $e) {
            Log::error('API ReportsController - ' . $e->getMessage());
            return api_error_response($e);
        }

        return (new ReportCollection($result))->additional([
            '_id' => $store->_id,
            'store_name' => $store->store_name,
            'shop_address' => $store->shop_address,
            'tagline' => $store->tagline,
            'phone_number' => $store->phone_number,
            'email' => $store->email,
        ]);
    }

    public function CustomerReport(Request $request, $customer_id)
    {
        $length = (int) $request->get('length') ?? 10;
        $result = [];

        try {
            $paidTransactionReport = Transactions::groupby('currency')->perCustomerCurrency('paid', $customer_id);
            $debtTransactionReport = Transactions::groupby('currency')->perCustomerCurrency('debt', $customer_id);
            $creditTransactionReport = Transactions::groupby('currency')->perCustomerCurrency('credit', $customer_id);
            // $creditDebtTransactionReport = Transactions::groupby('currency')->perCustomerCurrency('credit_ebt', $store_id);

            $latestTransactions = Transactions::orderBy('date_recorded', 'desc')
                ->ofCustomer($customer_id)
                ->take($length)
                ->get();

            $customer = Customers::find($customer_id);
            $result = [
                'debts' => $debtTransactionReport,
                'paids' => $paidTransactionReport,
                'credits' => $creditTransactionReport,
                'latest_transactions' => (new TransactionCollection($latestTransactions)),
            ];
        } catch (Exception $e) {
            Log::error('Reports Controller - ' . $e->getMessage());
            return api_error_response($e);
        }

        $customer = (new Customer($customer))->toArray($customer);

        return (new ReportCollection($result))->additional($customer);
    }
}
