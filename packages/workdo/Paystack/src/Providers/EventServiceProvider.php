<?php

namespace Workdo\Paystack\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as Provider;
use App\Events\CompanySettingEvent;
use App\Events\CompanySettingMenuEvent;
use App\Events\SuperAdminSettingEvent;
use App\Events\SuperAdminSettingMenuEvent;
use Workdo\Paystack\Listeners\SuperAdminSettingListener;
use Workdo\Paystack\Listeners\SuperAdminSettingMenuListener;
use Workdo\Paystack\Listeners\CompanySettingListener;
use Workdo\Paystack\Listeners\CompanySettingMenuListener;

class EventServiceProvider extends Provider
{
    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    protected $listen = [
        CompanySettingEvent::class => [
            CompanySettingListener::class,
        ],
        CompanySettingMenuEvent::class => [
            CompanySettingMenuListener::class,
        ],
        SuperAdminSettingEvent::class => [
            SuperAdminSettingListener::class,
        ],
        SuperAdminSettingMenuEvent::class => [
            SuperAdminSettingMenuListener::class,
        ],
    ];

    /**
     * Get the listener directories that should be used to discover events.
     *
     * @return array
     */
    protected function discoverEventsWithin()
    {
        return [
            __DIR__ . '/../Listeners',
        ];
    }
}