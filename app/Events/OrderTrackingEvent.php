<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderTrackingEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    private $order_status;
    private $order_id;

    public function __construct($orderId, $order_status)
    {
        $this->order_status = $order_status;
        $this->order_id = $orderId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new Channel('channel-name');
        return new Channel('order_tracking.'.$this->order_id);
    }

    public function broadcastAs()
    {
        return 'OrderTracking';
    }

    public function broadcastWith()
    {
        return [
          'OrderStatus' => $this->order_status,  
        ];
    }
}
