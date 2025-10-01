<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Log;

class LogNewOrder
{
    public function handle(OrderPlaced $event)
    {
        Log::info("A new order has been placed. Order ID: " . $event->order->id);
    }
}
