# Paystack Integration Setup Guide

## Overview
Paystack payment gateway has been successfully integrated into your FlexifyBook application, following the same pattern as Stripe integration.

## Features
- ✅ Plan/Subscription Payments
- ✅ Appointment Payments  
- ✅ Multiple Currency Support (NGN, USD, etc.)
- ✅ Payment Verification
- ✅ Admin Configuration (Super Admin & Company Level)
- ✅ Receipt Management

## Setup Instructions

### 1. Get Paystack API Keys
1. Visit [Paystack.com](https://paystack.com) and create an account
2. Navigate to Settings → API Keys & Webhooks
3. Copy your **Public Key** (starts with `pk_test_` for test mode)
4. Copy your **Secret Key** (starts with `sk_test_` for test mode)

### 2. Configure in Admin Panel

#### Super Admin Configuration:
1. Login as Super Admin
2. Go to **Settings** → **Payment Methods**
3. Find **Paystack** section
4. Toggle **"Enable Paystack"** to ON
5. Enter your **Paystack Public Key**
6. Enter your **Paystack Secret Key** 
7. Save changes

#### Company Level Configuration:
1. Each business can configure their own Paystack keys
2. Go to **Company Settings** → **Payment Methods**
3. Configure Paystack settings per company

### 3. Test Integration

#### Test API Keys:
- **Public Key**: `pk_test_xxxxxxxxxxxxx` (your test public key)
- **Secret Key**: `sk_test_xxxxxxxxxxxxx` (your test secret key)

#### Test Card Details:
- **Card Number**: 4084084084084081
- **Expiry**: Any future date (e.g., 12/25)
- **CVV**: 408

### 4. Currency Support
Paystack supports multiple currencies:
- **NGN** (Nigerian Naira) - Primary
- **USD** (US Dollar)
- **GHS** (Ghanaian Cedi)
- **ZAR** (South African Rand)
- **KES** (Kenyan Shilling)

### 5. Going Live

#### Production Setup:
1. Replace test keys with live keys:
   - **Live Public Key**: `pk_live_xxxxxxxxxxxxx`
   - **Live Secret Key**: `sk_live_xxxxxxxxxxxxx`
2. Ensure your Paystack account is fully verified
3. Test with small amounts first

### 6. Webhook Configuration (Optional)
For advanced payment notifications:
1. In Paystack Dashboard → Settings → Webhooks
2. Add webhook URL: `https://yourdomain.com/paystack/webhook`
3. Select events: `charge.success`, `charge.failed`

### 7. Troubleshooting

#### Common Issues:
1. **Module not visible**: Clear cache with `php artisan cache:clear`
2. **Routes not working**: Run `php artisan route:clear`
3. **Keys not working**: Verify test vs live mode
4. **Payment fails**: Check currency support and key validity

#### Debug Steps:
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Check if routes are registered
php artisan route:list | findstr paystack
```

### 8. Support
- **Paystack Documentation**: https://paystack.com/docs
- **Test Cards**: https://paystack.com/docs/payments/test-payments
- **API Reference**: https://paystack.com/docs/api

## Integration Complete! 🎉
Your Paystack integration is now ready to accept payments alongside your existing Stripe integration.