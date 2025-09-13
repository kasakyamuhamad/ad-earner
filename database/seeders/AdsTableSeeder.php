<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ad;

class AdsTableSeeder extends Seeder
{
    public function run()
    {
        Ad::create([
            'title' => 'Mobile Game Promotion',
            'description' => 'Check out this exciting new mobile game!',
            'reward_amount' => 15,
            'view_duration' => 30,
            'cooldown_minutes' => 60,
            'is_active' => true,
            'payout' => 0,
            'embed_code' => '<iframe src="https://example.com/ad.html"></iframe>', // ✅ Add this
        ]);

        Ad::create([
            'title' => 'E-commerce Special Offer',
            'description' => 'Great deals on popular products!',
            'reward_amount' => 10,
            'view_duration' => 20,
            'cooldown_minutes' => 30,
            'is_active' => true,
            'payout' => 0,
            'embed_code' => '<iframe src="https://example.com/ad2.html"></iframe>', // ✅ Add this
        ]);

        Ad::create([
            'title' => 'Streaming Service Trial',
            'description' => 'Start your free trial today!',
            'reward_amount' => 20,
            'view_duration' => 45,
            'cooldown_minutes' => 120,
            'is_active' => true,
            'embed_code' => '<iframe src="https://example.com/ad3.html"></iframe>', // ✅ Add this
            'payout' => 0,
        ]);
    }
}