<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;
use App\Constants\CacheKey;
use App\Services\SettingsService;

class HomeCacheObserver
{
    public function created()
    {
        $this->clearCaches();
    }

    public function updated()
    {
        $this->clearCaches();
    }

    public function deleted()
    {
        $this->clearCaches();
    }

    private function clearCaches()
    {
        Cache::forget(CacheKey::HOME_PAGE);
        SettingsService::clearCache();
    }
}
