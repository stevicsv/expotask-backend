<?php

namespace App\Providers;

use Domain\Team\Models\Membership;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Domain\Team\Observers\MembershipObserver;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
	];

	/**
	 * Register any events for your application.
	 *
	 * @return void
	 */
	public function boot()
	{
		Membership::observe(MembershipObserver::class);
	}
}
