<?php

namespace Workdo\Paystack\Listeners;

use App\Events\CompanySettingEvent;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class CompanySettingListener
{
    /**
     * Handle the event.
     */
    public function handle(CompanySettingEvent $event): void
    {
        try {
            $module = 'Paystack';
            $methodName = 'index';
            $controllerClass = "Workdo\\Paystack\\Http\\Controllers\\Company\\SettingsController";
            if (class_exists($controllerClass)) {
                $controller = App::make($controllerClass);
                if (method_exists($controller, $methodName)) {
                    $html = $event->html;
                    $settings = $html->getSettings();
                    $output =  $controller->{$methodName}($settings);
                    $html->add([
                        'html' => $output->toHtml(),
                        'order' => 1015,
                        'module' => $module,
                        'permission' => 'paystack manage'
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Silently fail to prevent breaking company settings
            Log::error('Paystack CompanySettingListener error: ' . $e->getMessage());
        }
    }
}