<?php

if (!function_exists('sum_store_transactions')) {

    /**
     * description
     *
     * @param array transactions
     * @param string type debt|paid|receiveable
     * @return array
     */
    function sum_store_transactions($transactions, $type)
    {
        $total = 0;
        $interest = 0;
        foreach ($transactions as $transaction) {
            if ($transaction->type != $type) {
                continue;
            }

            $total_amount = ($transaction->amount * ($transaction->interest / 100)) + $transaction->amount;
            $total += $total_amount;
            $interest += $transaction->interest;
        }

        $interest = $interest;

        return [
            'sum_transactions' => $total,
            'sum_interest' => $interest
        ];
    }
}

if (!function_exists('prepare_store_data')) {

    /**
     * prepare data for business dashbard
     *
     * @param object store_data
     * @param object transactions
     * @return array
     */
    function prepare_store_data($store_data, $transactions)
    {
        $data = [];
        $data['store']              = new stdClass;
        $data['currency']           = null;

        if (isset($store_data->store->store_admin_ref->currencyPreference)) {
            $data['currency']       = $store_data->store->store_admin_ref->currencyPreference;
        }

        $data['store']->_id           = $store_data->store->_id;
        $data['store']->store_name    = $store_data->store->store_name;
        $data['store']->email         = $store_data->store->email;
        $data['store']->phone_number  = $store_data->store->phone_number;
        $data['store']->shop_address  = $store_data->store->shop_address;
        $data['store']->tagline       = $store_data->store->tagline;

        $data['transactions']       = $transactions;
        $data['chart']              = $store_data->transactionChart;
        $data['total_customers']    = count($store_data->store->customers);
        $data['total_assistants']   = count($store_data->store->assistants);

        $debts = sum_store_transactions($transactions, 'debt');
        $payments = sum_store_transactions($transactions, 'paid');

        $data['total_revenues']       = $payments['sum_transactions'];
        $data['total_debts']          = $debts['sum_transactions'];
        $data['interest_revenues']    = $payments['sum_interest'];
        $data['interest_debts']       = $debts['sum_interest'];

        return $data;
    }
}
