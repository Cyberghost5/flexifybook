{{-- Country Code Phone Number Input Component --}}
@php
    $uniqueId = uniqid('phone_');
@endphp

<div class="form-group">
    <label for="contact_{{ $uniqueId }}">{{ __('Contact') }}</label>
    <div class="phone-group row">
        <div class="col-6">
            <select name="country_code" id="country_code_{{ $uniqueId }}" style="display: block !important">
                <option value="+93" data-country="AF">🇦🇫 +93</option>
                <option value="+355" data-country="AL">🇦🇱 +355</option>
                <option value="+213" data-country="DZ">🇩🇿 +213</option>
                <option value="+1" data-country="US">🇺🇸 +1</option>
                <option value="+376" data-country="AD">🇦🇩 +376</option>
                <option value="+244" data-country="AO">🇦🇴 +244</option>
                <option value="+1" data-country="AG">🇦🇬 +1</option>
                <option value="+54" data-country="AR">🇦🇷 +54</option>
                <option value="+374" data-country="AM">🇦🇲 +374</option>
                <option value="+61" data-country="AU">🇦🇺 +61</option>
                <option value="+43" data-country="AT">🇦🇹 +43</option>
                <option value="+994" data-country="AZ">🇦🇿 +994</option>
                <option value="+1" data-country="BS">🇧🇸 +1</option>
                <option value="+973" data-country="BH">🇧🇭 +973</option>
                <option value="+880" data-country="BD">🇧🇩 +880</option>
                <option value="+1" data-country="BB">🇧🇧 +1</option>
                <option value="+375" data-country="BY">🇧🇾 +375</option>
                <option value="+32" data-country="BE">🇧🇪 +32</option>
                <option value="+501" data-country="BZ">🇧🇿 +501</option>
                <option value="+229" data-country="BJ">🇧🇯 +229</option>
                <option value="+975" data-country="BT">🇧🇹 +975</option>
                <option value="+591" data-country="BO">🇧🇴 +591</option>
                <option value="+387" data-country="BA">🇧🇦 +387</option>
                <option value="+267" data-country="BW">🇧🇼 +267</option>
                <option value="+55" data-country="BR">🇧🇷 +55</option>
                <option value="+673" data-country="BN">🇧🇳 +673</option>
                <option value="+359" data-country="BG">🇧🇬 +359</option>
                <option value="+226" data-country="BF">🇧🇫 +226</option>
                <option value="+257" data-country="BI">🇧🇮 +257</option>
                <option value="+855" data-country="KH">🇰🇭 +855</option>
                <option value="+237" data-country="CM">🇨🇲 +237</option>
                <option value="+1" data-country="CA">🇨🇦 +1</option>
                <option value="+238" data-country="CV">🇨🇻 +238</option>
                <option value="+236" data-country="CF">🇨🇫 +236</option>
                <option value="+235" data-country="TD">🇹🇩 +235</option>
                <option value="+56" data-country="CL">🇨🇱 +56</option>
                <option value="+86" data-country="CN">🇨🇳 +86</option>
                <option value="+57" data-country="CO">🇨🇴 +57</option>
                <option value="+269" data-country="KM">🇰🇲 +269</option>
                <option value="+242" data-country="CG">🇨🇬 +242</option>
                <option value="+243" data-country="CD">🇨🇩 +243</option>
                <option value="+682" data-country="CK">🇨🇰 +682</option>
                <option value="+506" data-country="CR">🇨🇷 +506</option>
                <option value="+225" data-country="CI">🇨🇮 +225</option>
                <option value="+385" data-country="HR">🇭🇷 +385</option>
                <option value="+53" data-country="CU">🇨🇺 +53</option>
                <option value="+357" data-country="CY">🇨🇾 +357</option>
                <option value="+420" data-country="CZ">🇨🇿 +420</option>
                <option value="+45" data-country="DK">🇩🇰 +45</option>
                <option value="+253" data-country="DJ">🇩🇯 +253</option>
                <option value="+1" data-country="DM">🇩🇲 +1</option>
                <option value="+1" data-country="DO">🇩🇴 +1</option>
                <option value="+593" data-country="EC">🇪🇨 +593</option>
                <option value="+20" data-country="EG">🇪🇬 +20</option>
                <option value="+503" data-country="SV">🇸🇻 +503</option>
                <option value="+240" data-country="GQ">🇬🇶 +240</option>
                <option value="+291" data-country="ER">🇪🇷 +291</option>
                <option value="+372" data-country="EE">🇪🇪 +372</option>
                <option value="+251" data-country="ET">🇪🇹 +251</option>
                <option value="+679" data-country="FJ">🇫🇯 +679</option>
                <option value="+358" data-country="FI">🇫🇮 +358</option>
                <option value="+33" data-country="FR">🇫🇷 +33</option>
                <option value="+241" data-country="GA">🇬🇦 +241</option>
                <option value="+220" data-country="GM">🇬🇲 +220</option>
                <option value="+995" data-country="GE">🇬🇪 +995</option>
                <option value="+49" data-country="DE">🇩🇪 +49</option>
                <option value="+233" data-country="GH">🇬🇭 +233</option>
                <option value="+30" data-country="GR">🇬🇷 +30</option>
                <option value="+1" data-country="GD">🇬🇩 +1</option>
                <option value="+502" data-country="GT">🇬🇹 +502</option>
                <option value="+224" data-country="GN">🇬🇳 +224</option>
                <option value="+245" data-country="GW">🇬🇼 +245</option>
                <option value="+592" data-country="GY">🇬🇾 +592</option>
                <option value="+509" data-country="HT">🇭🇹 +509</option>
                <option value="+504" data-country="HN">🇭🇳 +504</option>
                <option value="+36" data-country="HU">🇭🇺 +36</option>
                <option value="+354" data-country="IS">🇮🇸 +354</option>
                <option value="+91" data-country="IN">🇮🇳 +91</option>
                <option value="+62" data-country="ID">🇮🇩 +62</option>
                <option value="+98" data-country="IR">🇮🇷 +98</option>
                <option value="+964" data-country="IQ">🇮🇶 +964</option>
                <option value="+353" data-country="IE">🇮🇪 +353</option>
                <option value="+972" data-country="IL">🇮🇱 +972</option>
                <option value="+39" data-country="IT">🇮🇹 +39</option>
                <option value="+1" data-country="JM">🇯🇲 +1</option>
                <option value="+81" data-country="JP">🇯🇵 +81</option>
                <option value="+962" data-country="JO">🇯🇴 +962</option>
                <option value="+7" data-country="KZ">🇰🇿 +7</option>
                <option value="+254" data-country="KE">🇰🇪 +254</option>
                <option value="+686" data-country="KI">🇰🇮 +686</option>
                <option value="+850" data-country="KP">🇰🇵 +850</option>
                <option value="+82" data-country="KR">🇰🇷 +82</option>
                <option value="+965" data-country="KW">🇰🇼 +965</option>
                <option value="+996" data-country="KG">🇰🇬 +996</option>
                <option value="+856" data-country="LA">🇱🇦 +856</option>
                <option value="+371" data-country="LV">🇱🇻 +371</option>
                <option value="+961" data-country="LB">🇱🇧 +961</option>
                <option value="+266" data-country="LS">🇱🇸 +266</option>
                <option value="+231" data-country="LR">🇱🇷 +231</option>
                <option value="+218" data-country="LY">🇱🇾 +218</option>
                <option value="+423" data-country="LI">🇱🇮 +423</option>
                <option value="+370" data-country="LT">🇱🇹 +370</option>
                <option value="+352" data-country="LU">🇱🇺 +352</option>
                <option value="+389" data-country="MK">🇲🇰 +389</option>
                <option value="+261" data-country="MG">🇲🇬 +261</option>
                <option value="+265" data-country="MW">🇲🇼 +265</option>
                <option value="+60" data-country="MY">🇲🇾 +60</option>
                <option value="+960" data-country="MV">🇲🇻 +960</option>
                <option value="+223" data-country="ML">🇲🇱 +223</option>
                <option value="+356" data-country="MT">🇲🇹 +356</option>
                <option value="+692" data-country="MH">🇲🇭 +692</option>
                <option value="+222" data-country="MR">🇲🇷 +222</option>
                <option value="+230" data-country="MU">🇲🇺 +230</option>
                <option value="+52" data-country="MX">🇲🇽 +52</option>
                <option value="+691" data-country="FM">🇫🇲 +691</option>
                <option value="+373" data-country="MD">🇲🇩 +373</option>
                <option value="+377" data-country="MC">🇲🇨 +377</option>
                <option value="+976" data-country="MN">🇲🇳 +976</option>
                <option value="+382" data-country="ME">🇲🇪 +382</option>
                <option value="+212" data-country="MA">🇲🇦 +212</option>
                <option value="+258" data-country="MZ">🇲🇿 +258</option>
                <option value="+95" data-country="MM">🇲🇲 +95</option>
                <option value="+264" data-country="NA">🇳🇦 +264</option>
                <option value="+674" data-country="NR">🇳🇷 +674</option>
                <option value="+977" data-country="NP">🇳🇵 +977</option>
                <option value="+31" data-country="NL">🇳🇱 +31</option>
                <option value="+64" data-country="NZ">🇳🇿 +64</option>
                <option value="+505" data-country="NI">🇳🇮 +505</option>
                <option value="+227" data-country="NE">🇳🇪 +227</option>
                <option value="+234" data-country="NG" selected>🇳🇬 +234</option>
                <option value="+683" data-country="NU">🇳🇺 +683</option>
                <option value="+47" data-country="NO">🇳🇴 +47</option>
                <option value="+968" data-country="OM">🇴🇲 +968</option>
                <option value="+92" data-country="PK">🇵🇰 +92</option>
                <option value="+680" data-country="PW">🇵🇼 +680</option>
                <option value="+970" data-country="PS">🇵🇸 +970</option>
                <option value="+507" data-country="PA">🇵🇦 +507</option>
                <option value="+675" data-country="PG">🇵🇬 +675</option>
                <option value="+595" data-country="PY">🇵🇾 +595</option>
                <option value="+51" data-country="PE">🇵🇪 +51</option>
                <option value="+63" data-country="PH">🇵🇭 +63</option>
                <option value="+48" data-country="PL">🇵🇱 +48</option>
                <option value="+351" data-country="PT">🇵🇹 +351</option>
                <option value="+974" data-country="QA">🇶🇦 +974</option>
                <option value="+40" data-country="RO">🇷🇴 +40</option>
                <option value="+7" data-country="RU">🇷🇺 +7</option>
                <option value="+250" data-country="RW">🇷🇼 +250</option>
                <option value="+1" data-country="KN">🇰🇳 +1</option>
                <option value="+1" data-country="LC">🇱🇨 +1</option>
                <option value="+1" data-country="VC">🇻🇨 +1</option>
                <option value="+685" data-country="WS">🇼🇸 +685</option>
                <option value="+378" data-country="SM">🇸🇲 +378</option>
                <option value="+239" data-country="ST">🇸🇹 +239</option>
                <option value="+966" data-country="SA">🇸🇦 +966</option>
                <option value="+221" data-country="SN">🇸🇳 +221</option>
                <option value="+381" data-country="RS">🇷🇸 +381</option>
                <option value="+248" data-country="SC">🇸🇨 +248</option>
                <option value="+232" data-country="SL">🇸🇱 +232</option>
                <option value="+65" data-country="SG">🇸🇬 +65</option>
                <option value="+421" data-country="SK">🇸🇰 +421</option>
                <option value="+386" data-country="SI">🇸🇮 +386</option>
                <option value="+677" data-country="SB">🇸🇧 +677</option>
                <option value="+252" data-country="SO">🇸🇴 +252</option>
                <option value="+27" data-country="ZA">🇿🇦 +27</option>
                <option value="+211" data-country="SS">🇸🇸 +211</option>
                <option value="+34" data-country="ES">🇪🇸 +34</option>
                <option value="+94" data-country="LK">🇱🇰 +94</option>
                <option value="+249" data-country="SD">🇸🇩 +249</option>
                <option value="+597" data-country="SR">🇸🇷 +597</option>
                <option value="+268" data-country="SZ">🇸🇿 +268</option>
                <option value="+46" data-country="SE">🇸🇪 +46</option>
                <option value="+41" data-country="CH">🇨🇭 +41</option>
                <option value="+963" data-country="SY">🇸🇾 +963</option>
                <option value="+886" data-country="TW">🇹🇼 +886</option>
                <option value="+992" data-country="TJ">🇹🇯 +992</option>
                <option value="+255" data-country="TZ">🇹🇿 +255</option>
                <option value="+66" data-country="TH">🇹🇭 +66</option>
                <option value="+670" data-country="TL">🇹🇱 +670</option>
                <option value="+228" data-country="TG">🇹🇬 +228</option>
                <option value="+690" data-country="TK">🇹🇰 +690</option>
                <option value="+676" data-country="TO">🇹🇴 +676</option>
                <option value="+1" data-country="TT">🇹🇹 +1</option>
                <option value="+216" data-country="TN">🇹🇳 +216</option>
                <option value="+90" data-country="TR">🇹🇷 +90</option>
                <option value="+993" data-country="TM">🇹🇲 +993</option>
                <option value="+688" data-country="TV">🇹🇻 +688</option>
                <option value="+256" data-country="UG">🇺🇬 +256</option>
                <option value="+380" data-country="UA">🇺🇦 +380</option>
                <option value="+971" data-country="AE">🇦🇪 +971</option>
                <option value="+44" data-country="GB">🇬🇧 +44</option>
                <option value="+598" data-country="UY">🇺🇾 +598</option>
                <option value="+998" data-country="UZ">🇺🇿 +998</option>
                <option value="+678" data-country="VU">🇻🇺 +678</option>
                <option value="+379" data-country="VA">🇻🇦 +379</option>
                <option value="+58" data-country="VE">🇻🇪 +58</option>
                <option value="+84" data-country="VN">🇻🇳 +84</option>
                <option value="+967" data-country="YE">🇾🇪 +967</option>
                <option value="+260" data-country="ZM">🇿🇲 +260</option>
                <option value="+263" data-country="ZW">🇿🇼 +263</option>
            </select>
        </div>
        <div class="col-6">
            <input type="tel" class="form-control phone-input" name="contact" id="contact_{{ $uniqueId }}" placeholder="{{ __('Phone Number') }}" />
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-detect user's country based on IP geolocation
    detectUserCountry();
    
    function detectUserCountry() {
        fetch('https://ipapi.co/json/')
            .then(response => response.json())
            .then(data => {
                if (data.country_code) {
                    const countrySelect = document.getElementById('country_code_{{ $uniqueId }}');
                    const option = countrySelect.querySelector(`[data-country="${data.country_code}"]`);
                    if (option) {
                        countrySelect.value = option.value;
                    }
                }
            })
            .catch(error => {
                console.log('Could not detect country, using default');
                // Default to Nigeria (+234) if detection fails
                const countrySelect = document.getElementById('country_code_{{ $uniqueId }}');
                if (countrySelect) {
                    countrySelect.value = '+234';
                }
            });
    }
});
</script>

<style>
/* Country Phone Input Bootstrap Styling */
.country-phone-input .input-group {
    position: relative;
    display: flex;
    flex-wrap: wrap;
    align-items: stretch;
    width: 100%;
}

.country-phone-input .input-group-prepend {
    display: flex;
    margin-right: 0;
}

.country-phone-input .country-code-select {
    position: relative;
    flex: 0 0 auto;
    width: auto;
    min-width: 110px;
    max-width: 120px;
    margin-bottom: 0;
    border-right: 0;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    background-color: #f8f9fa;
    border-color: #ced4da;
    font-size: 0.875rem;
    height: calc(1.5em + 0.75rem + 2px);
}

.country-phone-input .country-code-select:focus {
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    z-index: 3;
}

.country-phone-input .form-control {
    position: relative;
    flex: 1 1 auto;
    width: 1%;
    min-width: 0;
    margin-bottom: 0;
    border-left: 0;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    border-color: #ced4da;
    padding-left: 12px;
}

.country-phone-input .form-control:focus {
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    z-index: 3;
}

/* Ensure proper connection between select and input */
.country-phone-input .input-group-prepend:not(:first-child) > .country-code-select,
.country-phone-input .input-group-prepend:not(:first-child) > .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

.country-phone-input .input-group > .input-group-prepend > .country-code-select {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .country-phone-input .country-code-select {
        min-width: 95px;
        max-width: 105px;
        font-size: 0.8rem;
    }
}

/* Dark mode support */

/* Validation states */
.country-phone-input .is-valid .country-code-select,
.country-phone-input .is-valid .form-control {
    border-color: #28a745;
}

.country-phone-input .is-invalid .country-code-select,
.country-phone-input .is-invalid .form-control {
    border-color: #dc3545;
}

.country-phone-input .is-valid .country-code-select:focus,
.country-phone-input .is-valid .form-control:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.country-phone-input .is-invalid .country-code-select:focus,
.country-phone-input .is-invalid .form-control:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

/* Hover effects */
.country-phone-input .country-code-select:hover,
.country-phone-input .form-control:hover {
    border-color: #b0b8c1;
}

/* Disabled state */
.country-phone-input .country-code-select:disabled,
.country-phone-input .form-control:disabled {
    background-color: #e9ecef;
    opacity: 1;
}
</style>