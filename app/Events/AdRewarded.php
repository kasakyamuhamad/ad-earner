<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\UserReward;

class AdRewarded implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $reward;

    public function __construct(UserReward $reward)
    {
        $this->reward = $reward;
    }

    public function broadcastOn()
    {
        return new Channel('user.' . $this->reward->user_id);
    }

    public function broadcastWith()
    {
        return [
            'ad_id' => $this->reward->ad_id,
            'reward_amount' => $this->reward->reward_amount,
            'viewed_at' => $this->reward->viewed_at->toDateTimeString(),
        ];
    }
}
