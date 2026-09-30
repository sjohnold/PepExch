<?php

namespace App\Services;

use App\Enums\Seting;
use App\Models\Category;
use App\Models\NavigationItem;
use App\Repositories\CategoryRepository;
use App\Repositories\LanguageRepository;
use App\Repositories\SettingRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class SettingsService
{
    public const CACHE_KEY = 'shared_data';

    public function sharedData(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            $languages = LanguageRepository::query()->get();
            $categories = CategoryRepository::query()
                ->with('child')
                ->whereNull('parent_id')
                ->get();
            $settings = SettingRepository::getAll()->keyBy('type');

            return [
                'languages' => $languages,
                'categories' => $categories,
                'settings' => $settings,
                'themeColors' => $this->themeColorsFrom($settings),
                'footerMenuCards' => $this->footerMenuCardsFrom($settings),
                'navigation' => [
                    'main' => $this->navigation('main', $categories),
                    'sidebar' => $this->navigation('sidebar', $categories),
                    'footer' => $this->navigation('footer', $categories),
                ],
            ];
        });
    }

    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
        Cache::forget('all_settings_keyed');
        Cache::forget('currency_setting');
    }

    public function decodedSetting(string $type, mixed $default = null): mixed
    {
        $setting = $this->sharedData()['settings']->get($type);

        if (!$setting) {
            return $default;
        }

        return json_decode($setting->data, true) ?? $default;
    }

    private function themeColorsFrom($settings): array
    {
        $theme = !empty($settings[Seting::ThemeColor->value])
            ? json_decode($settings[Seting::ThemeColor->value]->data, true) ?? []
            : [];

        return array_merge([
            'primary_color' => '#10b981',
            'secondary_color' => '#059669',
            'text_color' => '#17181d',
            'font_family' => "'Poppins', sans-serif",
        ], $theme);
    }

    private function footerMenuCardsFrom($settings): array
    {
        if (empty($settings[Seting::FooterMenuOrder->value])) {
            return [];
        }

        $data = json_decode($settings[Seting::FooterMenuOrder->value]->data, true);
        $cards = $data['cards'] ?? [];

        usort($cards, fn ($a, $b) => ($a['order'] ?? 0) <=> ($b['order'] ?? 0));
        $cards = array_values(array_filter($cards, fn ($card) => $card['is_active'] ?? false));

        foreach ($cards as &$card) {
            $items = $card['items'] ?? [];
            usort($items, fn ($a, $b) => ($a['order'] ?? 0) <=> ($b['order'] ?? 0));
            $card['items'] = array_values(array_filter($items, fn ($item) => $item['is_active'] ?? false));
        }

        return $cards;
    }

    private function navigation(string $location, $categories): array
    {
        if (!Schema::hasTable('navigation_items')) {
            return $this->defaultNavigation($location, $categories);
        }

        $items = NavigationItem::query()
            ->with('children')
            ->where('location', $location)
            ->where('is_visible', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->orderBy('label')
            ->get();

        if ($items->isEmpty()) {
            return $this->defaultNavigation($location, $categories);
        }

        return $items->map(fn (NavigationItem $item) => $this->serializeNavigationItem($item, $categories))->all();
    }

    private function serializeNavigationItem(NavigationItem $item, $categories): array
    {
        return [
            'id' => $item->id,
            'location' => $item->location,
            'label' => $item->label,
            'icon' => $item->icon,
            'type' => $item->type,
            'route_name' => $item->route_name,
            'url' => $item->resolved_url,
            'sort_order' => $item->sort_order,
            'is_visible' => $item->is_visible,
            'visibility' => $item->visibility,
            'target' => $item->target,
            'categories' => $item->type === 'category_dropdown' ? $this->serializeCategories($categories) : [],
            'children' => $item->children
                ->where('is_visible', true)
                ->map(fn (NavigationItem $child) => $this->serializeNavigationItem($child, $categories))
                ->values()
                ->all(),
        ];
    }

    private function defaultNavigation(string $location, $categories): array
    {
        return match ($location) {
            'main' => [
                $this->nav('Home', 'route', 'home', null, 10),
                $this->nav('Category', 'category_dropdown', null, null, 20, 'public', 'fas fa-th-large', $categories),
                $this->nav('Oglasi', 'route', 'products', null, 30),
                $this->nav('About Us', 'route', 'about.us', null, 40),
                $this->nav('Contact', 'route', 'contact.us', null, 50),
            ],
            'sidebar' => [
                $this->nav('Početna', 'route', 'home', 'Home', 10, 'public', 'fas fa-home'),
                $this->nav('Oglasi', 'route', 'products', 'Feed', 20, 'public', 'fas fa-search'),
                $this->nav('Ponude', 'route', 'user.offers', 'MyOffers', 30, 'auth', 'fas fa-handshake'),
                $this->nav('Moji oglasi', 'route', 'user.my-ads', 'MyAds', 40, 'auth', 'fas fa-list'),
                $this->nav('Poruke', 'route', 'chat.index', 'Chat', 50, 'auth', 'fas fa-envelope'),
                $this->nav('Obaveštenja', 'route', 'user.show-notifications', 'Notifications', 60, 'auth', 'fas fa-bell'),
                $this->nav('Omiljeno', 'route', 'wishlist.index', 'Wishlist', 70, 'auth', 'fas fa-heart'),
                $this->nav('Profil', 'route', 'user.profile', 'Profile', 80, 'auth', 'fas fa-user'),
                $this->nav('Podrška', 'route', 'contact.us', 'Contact', 90, 'public', 'fas fa-comment-dots'),
                $this->nav('O PepExchu', 'route', 'about.us', 'About', 100, 'public', 'fas fa-info-circle'),
            ],
            default => [],
        };
    }

    private function nav(
        string $label,
        string $type,
        ?string $routeName,
        ?string $page,
        int $order,
        string $visibility = 'public',
        ?string $icon = null,
        $categories = null
    ): array {
        return [
            'id' => "{$type}-{$order}",
            'label' => $label,
            'icon' => $icon,
            'type' => $type,
            'route_name' => $routeName,
            'page' => $page,
            'url' => $routeName && \Illuminate\Support\Facades\Route::has($routeName) ? route($routeName) : '#',
            'sort_order' => $order,
            'is_visible' => true,
            'visibility' => $visibility,
            'target' => '_self',
            'categories' => $type === 'category_dropdown' ? $this->serializeCategories($categories ?? collect()) : [],
            'children' => [],
        ];
    }

    private function serializeCategories($categories): array
    {
        return collect($categories)->map(fn (Category $category) => [
            'id' => $category->id,
            'name' => $category->name,
            'url' => route('products', $category->id),
            'thumbnail' => $category->thumbnailPath,
            'children' => $category->child->map(fn (Category $child) => [
                'id' => $child->id,
                'name' => $child->name,
                'url' => route('products', $child->id),
                'thumbnail' => $child->thumbnailPath,
            ])->all(),
        ])->all();
    }
}
