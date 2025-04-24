<?php

namespace App\Listeners;

use App\Events\BarangChanged;
use App\Models\Notifikasi;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateNotifikasi
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BarangChanged $event): void
    {
        Notifikasi::create([
            'user_id' => $event->userId,
            'message' => $event->message,
        ]);
    }
}
