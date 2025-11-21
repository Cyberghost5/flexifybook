<?php

// Paystack Integration Test Script
// This script can be used to test Paystack API connectivity

require_once __DIR__ . '/../../../vendor/autoload.php';

use Illuminate\Support\Facades\Http;

class PaystackTest
{
    private $secretKey;

    public function __construct($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    public function testConnection()
    {
        try {
            echo "Testing Paystack API connection...\n";
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
            ])->get('https://api.paystack.co/bank');

            if ($response->successful()) {
                echo "✅ Paystack API connection successful!\n";
                return true;
            } else {
                echo "❌ Paystack API connection failed: " . $response->body() . "\n";
                return false;
            }
        } catch (Exception $e) {
            echo "❌ Connection error: " . $e->getMessage() . "\n";
            return false;
        }
    }

    public function testPaymentInitialization()
    {
        try {
            echo "Testing payment initialization...\n";
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.paystack.co/transaction/initialize', [
                'email' => 'test@example.com',
                'amount' => 1000, // 10 NGN in kobo
                'currency' => 'NGN',
                'reference' => 'test_' . time(),
                'metadata' => [
                    'test' => true,
                    'description' => 'Paystack integration test'
                ],
            ]);

            $responseData = $response->json();

            if ($response->successful() && $responseData['status']) {
                echo "✅ Payment initialization successful!\n";
                echo "Payment URL: " . $responseData['data']['authorization_url'] . "\n";
                return $responseData['data']['reference'];
            } else {
                echo "❌ Payment initialization failed: " . ($responseData['message'] ?? 'Unknown error') . "\n";
                return false;
            }
        } catch (Exception $e) {
            echo "❌ Initialization error: " . $e->getMessage() . "\n";
            return false;
        }
    }
}

// Usage example:
echo "Paystack Integration Test\n";
echo "========================\n\n";

echo "To test your Paystack integration:\n";
echo "1. Replace 'sk_test_your_secret_key' with your actual Paystack test secret key\n";
echo "2. Run: php test_paystack.php\n\n";

$testSecretKey = 'sk_test_your_secret_key_here';

if ($testSecretKey === 'sk_test_your_secret_key_here') {
    echo "⚠️  Please set your Paystack test secret key in this script first.\n";
    echo "Get your test keys from: https://dashboard.paystack.com/#/settings/developer\n";
} else {
    $tester = new PaystackTest($testSecretKey);
    
    if ($tester->testConnection()) {
        $reference = $tester->testPaymentInitialization();
        if ($reference) {
            echo "\n✅ All tests passed! Your Paystack integration is working correctly.\n";
        }
    }
}