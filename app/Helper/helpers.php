<?php

use App\Models\Transaction;
use App\Models\Wishlist;
use App\Repositories\BoostPlanRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\LanguageRepository;
use App\Repositories\MessageRepository;
use App\Repositories\NotificationHistoryRepository;
use App\Repositories\SellingPostRepository;
use App\Repositories\SettingRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

if (!function_exists('countUserByStatus')) {
    function countUser($status = null)
    {
        $colors = [
            'Pending' => ['bg-warning', 'fas fa-hourglass-half'],
            'Approve' => ['bg-success', 'fas fa-check-circle'],
            'BlockSelling' => ['bg-danger', 'fas fa-ban'],
            'Block' => ['bg-dark', 'fas fa-user-slash'],
            'Hold' => ['bg-info', 'fas fa-pause-circle'],
        ];
        return [
            'countNo' => UserRepository::countByStatus($status),
            'color' => isset($colors[$status]) ? $colors[$status][0] : 'bg-secondary',
            'icon' => isset($colors[$status]) ? $colors[$status][1] : 'fas fa-user',
        ];
    }
}

if (!function_exists('countPostByStatus')) {
    function countPost($status = null)
    {
        $colors = [
            'Pending' => ['bg-warning', 'fas fa-hourglass-half'],
            'In-Review' => ['bg-info', 'fas fa-search'],
            'Approve' => ['bg-success', 'fas fa-check-circle'],
            'Reject' => ['bg-danger', 'fas fa-times-circle'],
            'Soled' => ['bg-primary', 'fas fa-dollar-sign'],
            'Cancel' => ['bg-dark', 'fas fa-ban'],
        ];
        return [
            'countNo' => SellingPostRepository::countByStatus($status),
            'color' => isset($colors[$status]) ? $colors[$status][0] : 'bg-secondary',
            'icon' => isset($colors[$status]) ? $colors[$status][1] : 'fas fa-user',


        ];
    }
}
if (!function_exists('countTransaction')) {
    function countTransaction($status = null)
    {
        $colors = [
            'pending' => ['bg-warning', 'fas fa-hourglass-half'],
            'complete' => ['bg-success', 'fas fa-check-circle'],
            'cancel' => ['bg-dark', 'fas fa-user-slash'],
        ];

        return [
            'countNo' => TransactionRepository::countByStatus($status),
            'color' => $colors[$status][0] ?? 'bg-secondary',
            'icon' => $colors[$status][1] ?? 'fas fa-user',
        ];
    }
}

if (!function_exists('countTrashPosts')) {
    function countTrashPosts()
    {
        return SellingPostRepository::getTrashed()->count();
    }
}
if (!function_exists('countTrashUsers')) {
    function countTrashUsers()
    {
        return UserRepository::getTrashed()->count();
    }
}

if (!function_exists('countBoostPlans')) {
    function countBoostPlans()
    {
        return BoostPlanRepository::countByPlans();
    }
}

if (!function_exists('countSoldtPlans')) {
    function countSoldtPlans()
    {
        return BoostPlanRepository::countBySold();
    }
}

if (!function_exists('countDeletedPlans')) {
    function countDeletedPlans()
    {
        return BoostPlanRepository::countByTrash();
    }
}

if (!function_exists('socialMediaGenerate')) {
    function socialMediaGenerate($request = null)
    {
        $youtubeImg = asset('media/social/youtube.png');
        $fbImg = asset('media/social/facebook.png');
        $linkImg = asset('media/social/linkedin.png');
        $instaImg = asset('media/social/instagram.png');

        $links = [
            "facebook" => [
                'icon' => $fbImg,
                'url' => $request?->facebook,
            ],
            "linkedin" => [
                'icon' => $linkImg,
                'url' => $request?->linkedin,
            ],
            "instagram" => [
                'icon' => $instaImg,
                'url' => $request?->instagram,
            ],
            "youtube" => [
                'icon' => $youtubeImg,
                'url' => $request?->youtube,
            ],
        ];

        return $links;
    }
}

// Currency - >
if (!function_exists('formatCurrency')) {
    function currencyFormat($amount)
    {
        $currency = SettingRepository::getCurrencySetting();
        if (!$currency) {
            return (string) $amount;
        }

        if ($currency->position == 'left') {
            return $currency->symbol . $amount;
        } else {
            return $amount . $currency->symbol;
        }
    }
}


function getLocationName($latitude, $longitude)
{
    if (empty($latitude) || empty($longitude)) {
        return 'Coordinates Missing';
    }

    $cacheKey = "location_{$latitude}_{$longitude}";

    return Cache::remember($cacheKey, now()->addDays(7), function () use ($latitude, $longitude) {
        try {

            $response = Http::withHeaders([
                'User-Agent' => 'PepExch/1.0 (admin@pepexch.example)',
                'Accept-Language' => 'en',
            ])->timeout(10)->get('https://nominatim.openstreetmap.org/reverse', [
                'format' => 'jsonv2',
                'lat' => $latitude,
                'lon' => $longitude,
                'addressdetails' => 1,
            ]);

            $data = $response->json();

            if (!isset($data['address'])) {
                return 'Unknown Location';
            }

            $address = $data['address'];

            $house = $address['house_number'] ?? '';
            $road = $address['road'] ?? '';
            $suburb = $address['suburb']
                ?? $address['village']
                ?? $address['town']
                ?? $address['city']
                ?? $address['county']
                ?? $address['state']
                ?? '';

            $parts = array_filter([$house, $road, $suburb]);

            return !empty($parts) ? implode(', ', $parts) : 'Unknown Location';
        } catch (\Exception $e) {
            Log::error('Location fetch failed: ' . $e->getMessage());
            return 'Error fetching location';
        }
    });
}


//   set currency into .env

if (!function_exists('setEnv')) {
    function setEnv($key, $value)
    {
        $envPath = base_path('.env');
        if (!file_exists($envPath)) {
            return false;
        }

        $envContent = file_get_contents($envPath);
        $pattern = "/^{$key}=.*/m";


        if (preg_match($pattern, $envContent)) {
            $envContent = preg_replace($pattern, "{$key}={$value}", $envContent);
        } else {
            $envContent .= "\n{$key}={$value}";
        }

        file_put_contents($envPath, $envContent);

        return true;
    }
}


function getNotifications($isAdmin = null, $perPage = 10)
{
    $query = NotificationHistoryRepository::query();

    if ($isAdmin === null) {
        return $query->whereNull('receiver_id')
            ->latest()
            ->paginate($perPage);
    } else {
        return $query->where('receiver_id', auth()->id())
            ->latest()
            ->paginate($perPage);
    }
}


if (!function_exists('getUnreadNotificationsCount')) {
    function getUnreadNotificationsCount($isAdmin = null)
    {
        if ($isAdmin === null) {
            $count = NotificationHistoryRepository::query()
                ->where('receiver_id', null)
                ->where('is_read', false)
                ->count();
        } else {
            $count = NotificationHistoryRepository::query()
                ->where('receiver_id', auth()->id())
                ->where('is_read', false)
                ->count();
        }
        return $count;
    }
}

if (!function_exists('unreadUserCount')) {

    function unreadUserCount()
    {
        $authId = Auth::id();
        if (!$authId) return 0;

        // join messages with conversations to get sender_id
        $unreadUsers = MessageRepository::query()
            ->join('conversations', 'messages.conversation_id', '=', 'conversations.id')
            ->where('messages.receiver_id', $authId)
            ->where('messages.is_read', false)
            ->select('conversations.sender_id')
            ->distinct()
            ->count('conversations.sender_id');

        return $unreadUsers;
    }
}

function transactionCount($type)
{
    if ($type === 'wallet') {
        return Transaction::whereNotNull('boost_plan_id')
            ->whereNotNull('selling_post_id')
            ->whereNull('payment_method_id')
            ->count();
    }
    if ($type === 'walletRecherge') {
        return Transaction::whereNull('boost_plan_id')
            ->whereNull('selling_post_id')
            ->whereNotNull('payment_method_id')
            ->count();
    }

    if ($type === 'boost') {
        return Transaction::whereNotNull('boost_plan_id')
            ->whereNotNull('selling_post_id')
            ->whereNotNull('payment_method_id')
            ->count();
    }

    return 0;
}


if (!function_exists('getWishlistIds')) {
    function getWishlistIds()
    {
        return Wishlist::where('user_id', Auth::id())
            ->pluck('selling_post_id')
            ->toArray();
    }
}
