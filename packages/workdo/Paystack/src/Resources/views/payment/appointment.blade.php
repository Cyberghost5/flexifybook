<div class="col-sm-6 col-lg-4 col-12">
    <div class="radio-group">
        <input class="form-check-input payment_method" name="payment_method" id="paystack-payment" type="radio"
            data-payment="PAYSTACK" data-payment-action="{{ route('appointment.pay.with.paystack') }}">
        <label for="paystack-payment">
            <div class="radio-img">
                <img src="{{ get_module_img('Paystack') }}" alt="paystack">
            </div>
            <p>{{ Module_Alias_Name('Paystack') }}</p>
        </label>
    </div>
</div>