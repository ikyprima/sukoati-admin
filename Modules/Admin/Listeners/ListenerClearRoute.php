<?php

namespace Modules\Admin\Listeners;
use Log;
use Modules\Admin\Events\ClearRoute;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ListenerClearRoute
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ClearRoute $event
     * @return void
     */
    public function handle(ClearRoute $event)
    {
        Log::info("Handling ClearRoute event.");
        try {
            \Artisan::call('route:clear');
            \Artisan::call('cache:clear');
            Log::info("Route cache cleared successfully.");
        } catch (\Exception $e) {
            Log::error("Error clearing route cache: " . $e->getMessage());
        }
    }
}
