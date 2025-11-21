<?php

namespace Workdo\Paystack\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use App\Traits\PaymentTrait;

class PaystackController extends Controller
{
    use PaymentTrait;

    public $paystack_secret_key;

    public function settingConfig(Request $request)
    {
        return $this->paymentSetting($request, 'paystack manage', 'paystack_is_on', ['paystack_public_key' => 'required|string', 'paystack_secret_key' => 'required|string']);
    }

    public function paystackPayment($paystack_secret_key, $pay, $currency, $price)
    {
        try {
            $paystack_formatted_price = $price * 100; // Paystack works in kobo for NGN and cents for other currencies
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $paystack_secret_key,
                'Content-Type' => 'application/json',
            ])->post('https://api.paystack.co/transaction/initialize', [
                'email' => $pay['email'] ?? 'customer@example.com',
                'amount' => (int) $paystack_formatted_price,
                'currency' => $currency ?? 'NGN',
                'reference' => 'ref_' . time(),
                'callback_url' => $pay['success_url'] ?? '',
                'metadata' => [
                    'user_id' => $pay['user_id'] ?? '',
                    'package_id' => $pay['package_id'] ?? '',
                    'payment_frequency' => $pay['payment_frequency'] ?? '',
                    'code' => $pay['code'] ?? '',
                    'name' => $pay['name'] ?? '',
                    'description' => $pay['description'] ?? '',
                ],
            ]);

            $responseData = $response->json();

            if ($response->successful() && $responseData['status']) {
                return (object) [
                    'status' => 'success', 
                    'session' => (object) [
                        'url' => $responseData['data']['authorization_url'],
                        'reference' => $responseData['data']['reference']
                    ]
                ];
            } else {
                return (object) ['status' => 'error', 'message' => $responseData['message'] ?? 'Payment initialization failed'];
            }
        } catch (\Exception $e) {
            return (object) ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function verifyPayment($reference, $paystack_secret_key)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $paystack_secret_key,
                'Content-Type' => 'application/json',
            ])->get("https://api.paystack.co/transaction/verify/{$reference}");

            $responseData = $response->json();

            if ($response->successful() && $responseData['status'] && $responseData['data']['status'] === 'success') {
                return (object) ['status' => 'success', 'data' => $responseData['data']];
            } else {
                return (object) ['status' => 'error', 'message' => $responseData['message'] ?? 'Payment verification failed'];
            }
        } catch (\Exception $e) {
            return (object) ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // Plan Payment
    public function planPayWithPaystack(Request $request)
    {
        $pre_pay = $this->payThisPlan($request, 'Paystack');
        if ($pre_pay->status == 'success' && $pre_pay->plan_type !== 'free') {

            $this->paystack_secret_key = isset($pre_pay->settings['paystack_secret_key']) ? $pre_pay->settings['paystack_secret_key'] : '';
            $duration = $pre_pay->duration;
            $payment_type = $pre_pay->Order['payment_type'];

            $return_url_parameters = function ($return_type) use ($duration, $payment_type) {
                return '&return_type=' . $return_type . '&payment_processor=paystack&payment_frequency=' . $duration . '&payment_type=' . $payment_type;
            };

            $pay = $this->paystackPayment($this->paystack_secret_key, [
                'name' => !empty($pre_pay->plan->name) ? $pre_pay->plan->name : 'Basic Package',
                'description' => $pre_pay->duration,
                'email' => $pre_pay->user->email,
                'user_id' => $pre_pay->user->id,
                'package_id' => $pre_pay->plan->id,
                'payment_frequency' => $pre_pay->plan->duration,
                'success_url' => route('plan.get.paystack.status', ['plan_id' => $pre_pay->plan->id, 'order_id' => $pre_pay->order_id, 'other_order_id' => $pre_pay->other_order_id, $return_url_parameters('success')]),
                'cancel_url' => route('plan.get.paystack.status', ['plan_id' => $pre_pay->order_id, 'order_id' => $pre_pay->order_id, 'other_order_id' => $pre_pay->other_order_id, $return_url_parameters('cancel')]),
            ], $pre_pay->currency, $pre_pay->price);

            if ($pay->status == 'success') {
                Session::put($pre_pay->other_order_id, $pay->session);
                Order::create($pre_pay->Order);
                $paystack_session = $pay->session;
                return view('paystack::plan.request', compact('paystack_session'));
            } else {
                return redirect()->route('plans.index')->with($pay->status, $pay->message);
            }
        } else {
            return redirect()->route('plans.index')->with($pre_pay->status, $pre_pay->message);
        }
    }

    public function planGetPaystackStatus(Request $request)
    {
        if ($request->return_type == 'success') {
            $adminSetting = getAdminAllSetting();
            $paystack_secret_key = !empty($adminSetting['paystack_secret_key']) ? $adminSetting['paystack_secret_key'] : '';
            $paystack_session = Session::get($request->other_order_id);
            $reference = $paystack_session->reference ?? $request->reference;

            $verification = $this->verifyPayment($reference, $paystack_secret_key);
            
            $receipt_url = "";
            if ($verification->status == 'success') {
                $receipt_url = $verification->data['receipt_url'] ?? '';
            }

            Session::forget($request->other_order_id);
            $verify = $this->statusThisPlan($request, $request->return_type, false, $receipt_url);
            return redirect()->route('plans.index')->with($verify->status, $verify->message);
        } else {
            return redirect()->route('plans.index')->with('error', __("The transaction has been failed"));
        }
    }

    // Appointment Payment
    public function appointmentPayWithPaystack(Request $request)
    {
        $pre_pay = $this->payThisAppointment($request);

        $this->paystack_secret_key = isset($pre_pay->settings['paystack_secret_key']) ? $pre_pay->settings['paystack_secret_key'] : '';

        $return_url_parameters = function ($return_type) {
            return '&return_type=' . $return_type;
        };

        $comapany_paystack_pay = $this->paystackPayment($this->paystack_secret_key, [
            'name' => 'Booking',
            'description' => $pre_pay->business['slug'],
            'email' => $pre_pay->customer_email ?? 'customer@example.com',
            'user_id' => '',
            'package_id' => $pre_pay->business['slug'],
            'payment_frequency' => "Appointment",
            'success_url' => route('appointment.paystack.status', ['slug' => $pre_pay->business['slug'], 'order_id' => $pre_pay->order_id, 'other_order_id' => $pre_pay->other_order_id, $return_url_parameters('success')]),
            'cancel_url' => route('appointments.form', ['slug' => $pre_pay->business['slug'], 'order_id' => $pre_pay->order_id, 'other_order_id' => $pre_pay->other_order_id, $return_url_parameters('cancel')]),
        ], $pre_pay->currency, $pre_pay->price);

        if ($comapany_paystack_pay->status == 'success') {
            Session::put($pre_pay->other_order_id, $comapany_paystack_pay->session);
            $comapany_paystack_pay = $comapany_paystack_pay ?? false;
            return response()->json(['status' => 'success', 'url' => $comapany_paystack_pay->session->url, 'message' => $pre_pay->message]);
        } else {
            isset($pre_pay->attachment) ? delete_file($pre_pay->attachment) : '';
            return response()->json(['status' => $comapany_paystack_pay->status, 'url' => $pre_pay->fail_url, 'message' => $comapany_paystack_pay->message]);
        }
    }

    public function getAppointmentPaymentStatus(Request $request, $slug)
    {
        if ($request->return_type == 'success') {
            $paystack_session = Session::get($request->other_order_id);
            $data_session = Cache::get($request->order_id);
            $paystack_secret_key = !empty(company_setting('paystack_secret_key', $data_session['business']['created_by'], $data_session['business']['id'])) ? company_setting('paystack_secret_key', $data_session['business']['created_by'], $data_session['business']['id']) : '';
            $reference = $paystack_session->reference ?? $request->reference;

            $verification = $this->verifyPayment($reference, $paystack_secret_key);
            
            $receipt_url = "";
            if ($verification->status == 'success') {
                $receipt_url = $verification->data['receipt_url'] ?? '';
            }

            $status = $this->statusThisAppointment($request, $slug, $request->return_type, false, $receipt_url);
            return redirect()->route('appointments.form', ['slug' => $status->slug, 'appointment' => $status->appointment])->withFragment('appointment')->with($status->status, $status->message);
        } else {
            return redirect()->route('appointments.form', ['slug' => $slug, 'appointment' => 'failed'])->withFragment('appointment')->with('error', __("The transaction has been failed"));
        }
    }
}