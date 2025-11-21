{{-- Terms and Conditions Checkbox Component --}}
@if (!empty($business->terms_conditions))
<div class="form-group terms-conditions-section mb-4 col-12 m-3" style="margin: 10px;padding: 10px;">
    <div class="card border border-warning">
        <div class="card-header bg-warning-subtle">
            <h6 class="mb-0" style="margin:10px;">
                <i class="ti ti-file-text me-2"></i>
                {{ __('Terms & Conditions') }}
            </h6>
        </div>
        <div class="card-body">
            <div class="terms-conditions-content" style="max-height: 200px; overflow-y: auto; padding: 15px; background-color: #f8f9fa; border-radius: 5px;">
                {!! nl2br(e($business->terms_conditions)) !!}
            </div>
            
            <div class="form-check mt-3" style="margin: 10px;">
                <input type="checkbox" style="float:right;width:19px !important;height:19px !important;" name="terms_accepted" id="terms_accepted" value="1" style="width: 19px !important;height: 19px !important;" required>
                <label class="form-check-label" for="terms_accepted">
                    <strong>{{ __('I have read and agree to the terms and conditions') }}</strong>
                    <span class="text-danger">*</span>
                </label>
            </div>
            
            <small class="text-muted mt-2 d-block" style="margin: 10px;">
                <i class="ti ti-info-circle me-1"></i>
                {{ __('You must accept the terms and conditions to proceed with your appointment booking.') }}
            </small>
        </div>
    </div>
</div>

<style>
.form-check {
    display: block;
    min-height: 1.3125rem;
    padding-left: 1.75em;
    margin-bottom: 0.125rem;
}

.form-check .form-check-input {
    float: left;
    margin-left: -1.5em
}

.form-check-reverse {
    padding-right: 1.5em;
    padding-left: 0;
    text-align: right
}

.form-check-reverse .form-check-input {
    float: right;
    margin-right: -1.5em;
    margin-left: 0
}

.form-check-input {
    width: 1.25em;
    height: 1.25em;
    margin-top: 0.125em;
    vertical-align: top;
    background-color: #ffffff;
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;
    border: 1px solid rgba(0, 0, 0, 0.25);
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    print-color-adjust: exact;
    transition: background-color 0.15s 
ease-in-out, background-position 0.15s 
ease-in-out, border-color 0.15s 
ease-in-out, box-shadow 0.15s 
ease-in-out;
}

.form-check-input[type=checkbox] {
    border-radius: .25em
}

.form-check-input[type=radio] {
    border-radius: 50%
}

.form-check-input:active {
    filter: brightness(90%)
}

.form-check-input:focus {
    border-color: var(--border-color);
    outline: 0;
    box-shadow: 0 0 0 .25rem rgba(13,110,253,.25)
}

.form-check-input:checked {
    background-color: var(--theme-color);
    border-color: var(--border-color);
}

.form-check-input:disabled {
    pointer-events: none;
    filter: none;
    opacity: .5
}

.terms-conditions-section .card {
    border-left: 4px solid #000000ff;
}

.terms-conditions-content {
    font-size: 14px;
    line-height: 1.6;
    color: #333;
}

.terms-conditions-section .form-check-input:checked {
    background-color: var(--theme-color);
    border-color: var(--border-color);
}

.terms-conditions-section .form-check-label {
    font-size: 14px;
    margin-left: 5px;
}

.terms-conditions-section .text-danger {
    color: #dc3545 !important;
    font-weight: bold;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .terms-conditions-content {
        max-height: 150px;
        font-size: 13px;
    }
    
    .terms-conditions-section .form-check-label {
        font-size: 13px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validate terms acceptance before form submission
    const termsCheckbox = document.getElementById('terms_accepted');
    const appointmentForm = document.getElementById('appointment-form');
    
    if (termsCheckbox && appointmentForm) {
        appointmentForm.addEventListener('submit', function(e) {
            if (!termsCheckbox.checked) {
                e.preventDefault();
                alert('{{ __("Please accept the terms and conditions to proceed.") }}');
                termsCheckbox.scrollIntoView({ behavior: 'smooth', block: 'center' });
                termsCheckbox.focus();
                return false;
            }
        });
    }
    
    // Enable/disable payment buttons based on terms acceptance
    if (termsCheckbox) {
        function togglePaymentButtons() {
            const paymentButtons = document.querySelectorAll('.payment-method-form button[type="submit"], .payment-method-form .btn-primary');
            const freeServiceButton = document.querySelector('.free-appointment button, .btn-finish');
            
            paymentButtons.forEach(button => {
                button.disabled = !termsCheckbox.checked;
                if (termsCheckbox.checked) {
                    button.classList.remove('btn-secondary');
                    button.classList.add('btn-primary');
                } else {
                    button.classList.remove('btn-primary');
                    button.classList.add('btn-secondary');
                }
            });
            
            if (freeServiceButton) {
                freeServiceButton.disabled = !termsCheckbox.checked;
                if (termsCheckbox.checked) {
                    freeServiceButton.classList.remove('btn-secondary');
                    freeServiceButton.classList.add('btn-primary');
                } else {
                    freeServiceButton.classList.remove('btn-primary');
                    freeServiceButton.classList.add('btn-secondary');
                }
            }
        }
        
        termsCheckbox.addEventListener('change', togglePaymentButtons);
        
        // Initial state
        setTimeout(togglePaymentButtons, 100);
    }
});
</script>
@endif