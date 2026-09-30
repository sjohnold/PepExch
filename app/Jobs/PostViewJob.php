<?php

namespace App\Jobs;

use App\Models\PostView;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostViewJob implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, Queueable, SerializesModels;

    protected $postId;
    protected $userId;
    protected $ip;

    public function __construct($postId, $userId, $ip)
    {
        $this->postId = $postId;
        $this->userId = $userId;
        $this->ip = $ip;
    }


    /**
     * Execute the job.
     */
    public function handle()
    {
        
        PostView::firstOrCreate(
            [
                'selling_post_id' => $this->postId,
                'ip_address' => $this->ip,
            ],
            [
                'user_id' => $this->userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
