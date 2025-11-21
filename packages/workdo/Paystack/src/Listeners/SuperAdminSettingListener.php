<?php

namespace Workdo\Paystack\Listeners;

use App\Events\SuperAdminSettingEvent;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class SuperAdminSettingListener
{
    /**
     * Handle the event.
     */
    public function handle(SuperAdminSettingEvent $event): void
    {
        try {
            $module = 'Paystack';
            $methodName = 'index';
            $controllerClass = "Workdo\\Paystack\\Http\\Controllers\\SuperAdmin\\SettingsController";
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
            // Silently fail to prevent breaking admin settings
            Log::error('Paystack SuperAdminSettingListener error: ' . $e->getMessage());
        }
    }
}