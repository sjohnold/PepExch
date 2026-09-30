<?php

namespace App\Console\Commands;

use App\Models\SellingPost;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteOldTrashedPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-old-trashed-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete trashed posts older than 7 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $DaysAgo = Carbon::now()->subDays(7)->startOfDay();

        $deletedCount = SellingPost::onlyTrashed()
            ->where('deleted_at', '<=', $DaysAgo)
            ->forceDelete();

        $this->info("Deleted $deletedCount old trashed posts.");
    }
}
