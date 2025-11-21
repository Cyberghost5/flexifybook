@php
    $business = \App\Models\Business::find(getActiveBusiness());
    // Get the first service as default, will be updated via JavaScript
    $defaultService = isset($services) && $services->count() > 0 ? $services->first() : (isset($service) ? $service : null);
@endphp

<div id="payment-options-container" class="payment-option-section mt-3 mb-3 col-12" style="display: block;">
    <div class="card">
        <div class="card-header md-4">
            <h6 class="mb-3">{{ __('Payment Options') }}</h6>
        </div>
        <div class="card-body">
            <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
                <div class="col-12">
                    <div class="form-group">
                        <div class="d-flex flex-column gap-2">
                            <div class="custom-radio">
                                <input type="radio" id="full_payment" name="payment_option" value="full" checked>
                                <label for="full_payment" class="d-flex justify-content-between align-items-center">
                                    <span>
                                        <strong>{{ __('Pay Full Amount') }}</strong>
                                        <small class="text-muted d-block">{{ __('Complete payment now') }}</small>
                                    </span>
                                    <span class="payment-amount fw-bold" id="full-amount-display">
                                        {{ __('Loading...') }}
                                    </span>
                                </label>
                            </div>
                            
                            <div class="custom-radio">
                                <input type="radio" id="partial_payment" name="payment_option" value="partial">
                                <label for="partial_payment" class="d-flex justify-content-between align-items-center">
                                    <span>
                                        <strong>{{ __('Pay Deposit') }}</strong>
                                        <small class="text-muted d-block" id="deposit-description">
                                            {{ __('Deposit payment') }}
                                        </small>
                                    </span>
                                    <span class="payment-amount fw-bold" id="partial-amount-display">
                                        {{ __('Loading...') }}
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="payment-info" class="mt-3 p-3 bg-light rounded">
                <div class="row">
                    <div class="col-6">
                        <strong>{{ __('Today') }}</strong>
                        <div class="payment-today text-primary fs-5 fw-bold" id="today-payment-amount">
                            {{ __('Loading...') }}
                        </div>
                    </div>
                    <div class="col-6" id="remaining-section">
                        <strong>{{ __('Remaining') }}</strong>
                        <div class="payment-remaining text-muted fs-6" id="remaining-payment-amount">
                            {{ __('Loading...') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Global variables for payment calculations
    window.currentServiceData = null;
    window.currencySetting = '{{ $currency_setting ?? '{}' }}';
    
    // Function to update payment options based on selected service
    window.updatePaymentOptions = function(serviceData) {
        console.log('updatePaymentOptions called with:', serviceData); // Debug
        
        if (!serviceData) {
            console.log('No service data provided');
            return;
        }
        
        window.currentServiceData = serviceData;
        const paymentContainer = document.getElementById('payment-options-container');
        const fullPaymentRadio = document.getElementById('full_payment');
        const partialPaymentRadio = document.getElementById('partial_payment');
        
        // Check if service allows partial payments
        const allowPartial = serviceData.allow_partial_payment === 1 || serviceData.allow_partial_payment === true;
        const partialAmount = parseFloat(serviceData.partial_payment_amount) || 0;
        const servicePrice = parseFloat(serviceData.price) || 0;
        
        console.log('Service details:', {
            allowPartial,
            partialAmount,
            servicePrice,
            is_free: serviceData.is_free
        }); // Debug
        
        // Only show payment options if partial payment is enabled AND amounts are different
        if (allowPartial && partialAmount > 0 && partialAmount < servicePrice && !serviceData.is_free) {
            console.log('Showing payment options'); // Debug
            // Show payment options
            paymentContainer.style.display = 'block';
            
            const depositAmount = Math.min(partialAmount, servicePrice);
            const remainingAmount = servicePrice - depositAmount;
            
            // Update descriptions
            document.getElementById('deposit-description').innerHTML = 
                '{{ __("Pay now, complete after service") }}<br>' + 
                '<small class="text-muted">{{ __("Remaining:") }} ' + formatCurrency(remainingAmount, window.currencySetting) + '</small>';
            
            // Update display amounts
            document.getElementById('full-amount-display').textContent = formatCurrency(servicePrice, window.currencySetting);
            document.getElementById('partial-amount-display').textContent = formatCurrency(depositAmount, window.currencySetting);
            
            // Update payment info section
            updatePaymentInfo(servicePrice, depositAmount, remainingAmount);
            
            // Attach event listeners
            attachPaymentOptionListeners(servicePrice, depositAmount, remainingAmount);
        } else {
            console.log('Hiding payment options - conditions not met'); // Debug
            // Hide payment options if amounts are same or partial not allowed
            paymentContainer.style.display = 'none';
        }
    };
    
    function updatePaymentInfo(fullAmount, depositAmount, remainingAmount) {
        const fullPaymentRadio = document.getElementById('full_payment');
        const todayPaymentElement = document.getElementById('today-payment-amount');
        const remainingPaymentElement = document.getElementById('remaining-payment-amount');
        const remainingSection = document.getElementById('remaining-section');
        
        if (fullPaymentRadio.checked) {
            todayPaymentElement.textContent = formatCurrency(fullAmount, window.currencySetting);
            remainingPaymentElement.textContent = formatCurrency(0, window.currencySetting);
            remainingSection.style.display = 'none';
        } else {
            todayPaymentElement.textContent = formatCurrency(depositAmount, window.currencySetting);
            remainingPaymentElement.textContent = formatCurrency(remainingAmount, window.currencySetting);
            remainingSection.style.display = 'block';
        }
    }
    
    function attachPaymentOptionListeners(fullAmount, depositAmount, remainingAmount) {
        const fullPaymentRadio = document.getElementById('full_payment');
        const partialPaymentRadio = document.getElementById('partial_payment');
        const serviceAmount = document.getElementById('serviceAmount');
        
        // Remove existing listeners
        fullPaymentRadio.replaceWith(fullPaymentRadio.cloneNode(true));
        partialPaymentRadio.replaceWith(partialPaymentRadio.cloneNode(true));
        
        // Re-get elements after cloning
        const newFullRadio = document.getElementById('full_payment');
        const newPartialRadio = document.getElementById('partial_payment');
        
        newFullRadio.addEventListener('change', function() {
            updatePaymentInfo(fullAmount, depositAmount, remainingAmount);
            if (serviceAmount) {
                serviceAmount.innerHTML = 'Total Amount: ' + formatCurrency(fullAmount, window.currencySetting);
            }
        });
        
        newPartialRadio.addEventListener('change', function() {
            updatePaymentInfo(fullAmount, depositAmount, remainingAmount);
            if (serviceAmount) {
                serviceAmount.innerHTML = 'Deposit Amount: ' + formatCurrency(depositAmount, window.currencySetting);
            }
        });
    }
    
    // Initialize with first service if available
    const services = @json($services ?? []);
    if (services && services.length > 0) {
        window.updatePaymentOptions(services[0]);
    }
});
</script>

<style>
.custom-radio {
    position: relative;
    margin-bottom: 15px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 0;
    transition: all 0.3s ease;
}

.custom-radio:hover {
    border-color: #007bff;
    background-color: #f8f9fa;
}

.custom-radio input[type="radio"] {
    position: absolute;
    opacity: 0;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
    z-index: 2;
}

.custom-radio input[type="radio"]:checked + label {
    background-color: #007bff;
    color: white;
}

.custom-radio input[type="radio"]:checked + label .text-muted {
    color: rgba(255, 255, 255, 0.8) !important;
}

.custom-radio label {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    margin: 0;
    cursor: pointer;
    border-radius: 6px;
    transition: all 0.3s ease;
    width: 100%;
}

.payment-amount {
    font-size: 1.1em;
}
</style>