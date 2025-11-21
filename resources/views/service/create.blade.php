{{ Form::open(['route' => ['service.store', ['business_id' => $business->id]], 'method' => 'post', 'enctype' => 'multipart/form-data','class'=>'needs-validation','novalidate']) }}
@php
    if (module_is_active('FlexibleDuration')) {
        $duration_class = 'col-md-4';
    } else {
        $duration_class = 'col-md-12';
    }
    $currency_data = get_currency_format_and_symbol(creatorId(), $business->id);
    $currency_symbol = $currency_data['currancy_symbol'] ?? '$';
@endphp
<div class="modal-body">
    <div class="text-start mb-3">
        @if (module_is_active('AIAssistant'))
            @php
                $admin_settings = getAdminAllSetting();
            @endphp
            @if (module_is_active('AIAssistant') && !empty($admin_settings['chatgpt_is']) && $admin_settings['chatgpt_is'] == 'on')
                @include('aiassistant::ai.generate_ai_btn', [
                    'template_module' => 'service',
                    'module' => 'General',
                ])
            @endif
        @endif
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('name', __('Service Name'), ['class' => 'form-label']) }}
                {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Service Name'), 'required' => 'required']) }}
                @error('name')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>

        @if (module_is_active('CompoundService') && module_is_active('CollaborativeServices'))
            @stack('compound_and_collaborative_service_create')
        @elseif (module_is_active('CollaborativeServices'))
            @stack('collaborative_service_create')
        @elseif (module_is_active('CompoundService'))
            @stack('compound_service_create')
        @endif

        <div class="col-md-12">
            <div class="form-group">
                <div class="form-file">
                    {{Form::label('image',__('Image'),['class'=>'form-label']) }}
                    <input type="file" class="form-control mb-2" name="service_image" id="service_image" aria-label="file example" onchange="previewImage(this)" required>
                    <img class="rounded overflow-hidden" src="" id="blah" width="15%" style="display: none;"/>
                </div>
            </div>
        </div>

        <div class="{{ module_is_active('ServiceTax', getActiveBusiness()) ? 'col-md-6' : 'col-md-12' }}">
            <div class="form-group">
                {{ Form::label('category', __('category'), ['class' => 'form-label']) }}
                {{ Form::select('category', $category, null, ['class' => 'form-control', 'required' => 'required']) }}
                @permission('category create')
                    <div class=" text-xs mt-1">{{ __('Create category here. ') }}
                        <a href="#" data-ajax-popup="true" data-size="md"
                            data-title="{{ __('Create New Category') }}"
                            data-url="{{ route('category.create', ['business_id' => $business->id]) }}"
                            data-bs-toggle="tooltip" data-bs-original-title="{{ __('Create') }}">
                            <b>{{ __('Create category') }}</b>
                        </a>
                    </div>
                @endpermission
                @error('category')
                    <small class="invalid-category" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            @stack('service_tax')
        </div>

        <div class="col-md-12">
            @stack('discount')
        </div>

        <div class="col-md-12 mb-3">
            <div class="form-check form-switch custom-switch-v1">
                <label class="form-check-label" for="is_free">{{ __('Free Service') }}</label>
                <input type="checkbox" class="form-check-input input-primary" name="is_service_free"
                    id="is_service_free" checked>
            </div>
        </div>

        <div class="col-md-12 d-none" id="price">
            <div class="form-group">
                {{ Form::label('price', __('Price'), ['class' => 'form-label']) }}
                {{ Form::number('price', null, ['class' => 'form-control', 'placeholder' => __('Enter Price')]) }}
                @error('price')
                    <small class="invalid-price" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>

        {{-- Partial Payment Settings --}}
        <div class="col-md-12 d-none" id="partial-payment-section">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">{{ __('Partial Payment Options') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-check form-switch custom-switch-v1">
                                <label class="form-check-label" for="allow_partial_payment">{{ __('Allow Partial Payment') }}</label>
                                <input type="checkbox" class="form-check-input input-primary" name="allow_partial_payment"
                                    id="allow_partial_payment">
                            </div>
                        </div>
                        
                        <div class="col-md-6 d-none" id="partial-amount-section">
                            <div class="form-group">
                                {{ Form::label('partial_payment_amount', __('Partial Payment Amount'), ['class' => 'form-label']) }}
                                <div class="input-group">
                                    <span class="input-group-text">{{ $currency_symbol }}</span>
                                    {{ Form::number('partial_payment_amount', null, [
                                        'class' => 'form-control',
                                        'placeholder' => __('Enter partial amount'),
                                        'min' => '1',
                                        'step' => '0.01',
                                        'id' => 'partial_payment_amount'
                                    ]) }}
                                </div>
                                <small class="text-muted">
                                    {{ __('Amount customers can pay initially. Remaining balance will be collected after service.') }}
                                </small>
                                @error('partial_payment_amount')
                                    <small class="invalid-partial_payment_amount" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6 d-none" id="remaining-amount-display">
                            <div class="form-group">
                                {{ Form::label('remaining_amount_display', __('Remaining Amount'), ['class' => 'form-label']) }}
                                <div class="form-control-plaintext" id="remaining-amount">
                                    {{ $currency_symbol }}<span id="remaining-value">0.00</span>
                                </div>
                                <small class="text-muted">
                                    {{ __('Amount to be paid after service completion.') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="{{ $duration_class }}">
            <div class="form-group">
                {{ Form::label('duration', __('Duration (minute)'), ['class' => 'form-label']) }}
                {{ Form::number('duration', null, ['class' => 'form-control', 'placeholder' => __('Enter Duration in Minute 30'), 'required' => 'required', 'min' => '0', 'max' => '510']) }}
                @error('duration')
                    <small class="invalid-duration" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>

        @stack('unit_setup')

        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
                {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Enter Description'), 'required' => 'required', 'rows' => '4']) }}
                @error('description')
                    <small class="invalid-description" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        @stack('repeat_enable_disable')
    </div>
</div>
<div class="modal-footer gap-3">
    <button type="button" class="btn m-0 btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    {{ Form::submit(__('Create'), ['class' => 'btn m-0 btn-primary']) }}
</div>
{{ Form::close() }}

<script>
    $(document).ready(function() {
        $('#is_service_free').change(function() {
            if ($('#is_service_free').prop('checked')) {
                $('#price').addClass('d-none');
                $('#partial-payment-section').addClass('d-none');
            } else {
                $('#price').removeClass('d-none');
                $('#partial-payment-section').removeClass('d-none');
            }
        });

        $('#allow_partial_payment').change(function() {
            if ($(this).prop('checked')) {
                $('#partial-amount-section').removeClass('d-none');
                $('#remaining-amount-display').removeClass('d-none');
            } else {
                $('#partial-amount-section').addClass('d-none');
                $('#remaining-amount-display').addClass('d-none');
            }
        });

        // Calculate remaining amount when price or partial amount changes
        function updateRemainingAmount() {
            const servicePrice = parseFloat($('#price').val()) || 0;
            const partialAmount = parseFloat($('#partial_payment_amount').val()) || 0;
            const remainingAmount = Math.max(0, servicePrice - partialAmount);
            $('#remaining-value').text(remainingAmount.toFixed(2));
        }

        $('#price, #partial_payment_amount').on('input', updateRemainingAmount);
    });
</script>
