    <div class="card" id="paystack-sidenav">
        {{ Form::open(['route' => 'paystack.setting.store', 'enctype' => 'multipart/form-data']) }}
        @csrf
        <div class="card-header p-3">
            <div class="row align-items-center">
                <div class="col-sm-10 col-9">
                    <h5 class="">{{ __('Paystack') }}</h5>
                    <small>{{ __('These details will be used to collect appointment payments. Each appointment will have a payment button based on the below configuration.') }}</small>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 text-end">
                    <div class="form-check form-switch custom-switch-v1 float-end">
                        <input type="checkbox" name="paystack_is_on" class="form-check-input input-primary" id="paystack_is_on"
                            {{ (isset($settings['paystack_is_on']) ? $settings['paystack_is_on'] : 'off') == 'on' ? ' checked ' : '' }}>
                        <label class="form-check-label" for="paystack_is_on"></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-3 pb-0">
            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="paystack_public_key" class="form-label">{{ __('Paystack Public Key') }}</label>
                        <input class="form-control paystack_webhook" placeholder="{{ __('Paystack Public Key') }}" name="paystack_public_key"
                            type="text" value="{{ isset($settings['paystack_public_key']) ? $settings['paystack_public_key'] : '' }}"
                            {{ (isset($settings['paystack_is_on']) ? $settings['paystack_is_on'] : 'off')  == 'on' ? '' : ' disabled' }} id="paystack_public_key">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="paystack_secret_key" class="form-label">{{ __('Paystack Secret Key') }}</label>
                        <input class="form-control paystack_webhook" placeholder="{{ __('Paystack Secret Key') }}"
                            name="paystack_secret_key" type="text" value="{{ isset($settings['paystack_secret_key']) ? $settings['paystack_secret_key'] : '' }}"
                            {{ (isset($settings['paystack_is_on']) ? $settings['paystack_is_on'] : 'off')  == 'on' ? '' : ' disabled' }} id="paystack_secret_key">
                    </div>
                </div>
            </div>

        </div>
        <div class="card-footer p-3 text-end">
            <input class="btn btn-print-invoice  btn-primary m-r-10" type="submit" value="{{ __('Save Changes') }}">
        </div>
        {{ Form::close() }}
    </div>
    <script>
        "use strict";
        $(document).on('click', '#paystack_is_on', function() {
            if ($('#paystack_is_on').prop('checked')) {
                $(".paystack_webhook").removeAttr("disabled");
            } else {
                $('.paystack_webhook').attr("disabled", "disabled");
            }
        });
    </script>