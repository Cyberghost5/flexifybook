<?php

namespace Workdo\Paystack\Providers;

use App\Models\Business;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use App\Facades\ModuleFacade as Module;

class ViewComposer extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */

    public function boot()
    {
        view()->composer(['plans.planpayment', 'plans.marketplace'], function ($view) {
            if (Auth::check() && Module::isEnabled('Paystack')) {
                $admin_settings = getAdminAllSetting();
                if ((isset($admin_settings['paystack_is_on']) ? $admin_settings['paystack_is_on'] : 'off') == 'on' && !empty($admin_settings['paystack_public_key']) && !empty($admin_settings['paystack_secret_key'])) {
                    $view->getFactory()->startPush('company_plan_payment', view('paystack::payment.plan_payment'));
                }
            }
        });

        view()->composer(['web_layouts.appointment-form', 'form_layout.*.index'], function ($view) {
            try {
                $slug = Request::segment(2);
                if (!$slug && function_exists('frontend_bussiness_slug')) {
                    $slug = frontend_bussiness_slug();
                }
                if ($slug) {
                    $business = Business::where('slug', $slug)->first();
                    if ($business) {
                        $settings = getCompanyAllSetting($business->created_by, $business->id);
                        if (module_is_active('Paystack', $business->created_by) && (isset($settings['paystack_is_on']) ? $settings['paystack_is_on'] : 'off') == 'on' && !empty($settings['paystack_public_key']) && !empty($settings['paystack_secret_key'])) {
                            $view->getFactory()->startPush('appointment_payment', view('paystack::payment.appointment'));
                        }
                    }
                }
            } catch (\Exception $e) {
                // Silently fail to prevent breaking the view
                Log::error('Paystack ViewComposer error: ' . $e->getMessage());
            }
        });
    }

    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}