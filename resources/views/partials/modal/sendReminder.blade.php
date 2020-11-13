<div class="modal fade" id="sendReminderModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                @isset($transaction)
                <form action="{{ route('reminder') }}" method="POST">
                    @csrf
                    <input type="hidden" name="transaction_id" value="{{old('transaction_id', $transaction->_id)}}">
                    <input type="hidden" name="customer_id"
                        value="{{old('customer_id', $transaction->customer_ref_id)}}">
                    <input type="hidden" name="store_id" value="{{old('store_id', $transaction->store_ref_id)}}">
                    <div class="form-group">
                        <label>Message</label>
                        <textarea name="message" class="counter form-control" rows="4" id="reminderMessage"
                            placeholder="Message"
                            maxlength="140">Kindly pay up your debt of {{ format_money($transaction->total_amount, $transaction->currency) }} which is due on {{ \Carbon\Carbon::parse($transaction->expected_pay_date)->format('D') }} {{ \Carbon\Carbon::parse($transaction->expected_pay_date)->format('d/m/Y') }}. PAY NOW - {{ url('/').'/'. $transaction->currency .'/'.$transaction->_id }}</textarea>
                        <p class="charNum m-0 p-0"></p>
                    </div>
                    @else
                    <form action="{{ route('reminder') }}" method="POST">
                        @csrf
                        <input type="hidden" name="transaction_id" value="{{old('transaction_id', $debtor->_id)}}">
                        <input type="hidden" name="customer_id"
                            value="{{old('customer_id', $debtor->customer_ref_id)}}">
                        <input type="hidden" name="store_id" value="{{old('store_id', $debtor->store_ref_id)}}">

                        <div class="form-group">
                            <label>Message</label>

                            <textarea name="message" class="counter form-control" rows="4" id="reminderMessage"
                                placeholder="Message"
                                maxlength="140">Kindly pay up your debt of {{ format_money($debtor->total_amount, $debtor->currency) }} which is due on {{ \Carbon\Carbon::parse($debtor->expected_pay_date)->format('D') }} {{ app_format_date($debtor->expected_pay_date) }}. PAY here - {{ url('/'.  $debtor->currency . '/' . $debtor->_id ) }}</textarea>
                            <p class="charNum m-0 p-0"></p>
                        </div>
                        @endisset

                        <button type="submit" class="btn btn-primary btn-block">Send Reminder</button>
                    </form>
            </div>
        </div>
    </div>
</div>