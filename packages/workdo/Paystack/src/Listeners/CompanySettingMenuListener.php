<?php

namespace Workdo\Paystack\Listeners;

use App\Events\CompanySettingMenuEvent;

class CompanySettingMenuListener
{
    /**
     * Handle the event.
     */
    public function handle(CompanySettingMenuEvent $event): void
    {
        $module = 'Paystack';
        $menu = $event->menu;
        $menu->add([
            'title' => 'Paystack',
            'name' => 'paystack',
            'order' => 1015,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => '',
            'navigation' => 'paystack-sidenav',
            'module' => $module,
            'permission' => 'paystack manage'
        ]);
    }
}