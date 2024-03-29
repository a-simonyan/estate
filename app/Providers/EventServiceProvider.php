<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\PropertyPublished;
use App\Events\PropertyDelete;
use App\Listeners\SendPropertyPublished;
use App\Listeners\ThingToDoAfterPropertyDelete;
use App\Events\SendMailSuggestsPrice;
use App\Listeners\SendMailSuggestsPriceListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PropertyPublished::class => [
            SendPropertyPublished::class
        ],
        PropertyDelete::class => [
            ThingToDoAfterPropertyDelete::class
        ],
        SendMailSuggestsPrice::class => [
            SendMailSuggestsPriceListener::class
        ],
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            'SocialiteProviders\\Apple\\AppleExtendSocialite@handle',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
