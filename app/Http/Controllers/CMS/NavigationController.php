<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\NavigationItem;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NavigationController extends Controller
{
    public function index()
    {
        $items = NavigationItem::query()
            ->with('parent')
            ->orderBy('location')
            ->orderBy('sort_order')
            ->orderBy('label')
            ->get();

        $parents = NavigationItem::query()
            ->whereNull('parent_id')
            ->orderBy('location')
            ->orderBy('label')
            ->get();

        return view('admin.cms.navigation.index', compact('items', 'parents'));
    }

    public function store(Request $request): RedirectResponse
    {
        NavigationItem::create($this->validated($request));
        SettingsService::clearCache();

        return redirect()->route('cms-navigation.index')->with('success', 'Navigation item created.');
    }

    public function update(Request $request, NavigationItem $navigationItem): RedirectResponse
    {
        $navigationItem->update($this->validated($request, $navigationItem));
        SettingsService::clearCache();

        return redirect()->route('cms-navigation.index')->with('success', 'Navigation item updated.');
    }

    public function destroy(NavigationItem $navigationItem): RedirectResponse
    {
        $navigationItem->delete();
        SettingsService::clearCache();

        return redirect()->route('cms-navigation.index')->with('success', 'Navigation item deleted.');
    }

    public function installDefaults(): RedirectResponse
    {
        $defaults = [
            ['main', 'Home', 'route', 'home', null, 10, 'public', 'fas fa-home'],
            ['main', 'Category', 'category_dropdown', null, null, 20, 'public', 'fas fa-th-large'],
            ['main', 'Oglasi', 'route', 'products', null, 30, 'public', 'fas fa-search'],
            ['main', 'About Us', 'route', 'about.us', null, 40, 'public', 'fas fa-info-circle'],
            ['main', 'Contact', 'route', 'contact.us', null, 50, 'public', 'fas fa-comment-dots'],
            ['sidebar', 'Početna', 'route', 'home', null, 10, 'public', 'fas fa-home'],
            ['sidebar', 'Oglasi', 'route', 'products', null, 20, 'public', 'fas fa-search'],
            ['sidebar', 'Ponude', 'route', 'user.offers', null, 30, 'auth', 'fas fa-handshake'],
            ['sidebar', 'Moji oglasi', 'route', 'user.my-ads', null, 40, 'auth', 'fas fa-list'],
            ['sidebar', 'Poruke', 'route', 'chat.index', null, 50, 'auth', 'fas fa-envelope'],
            ['sidebar', 'Obaveštenja', 'route', 'user.show-notifications', null, 60, 'auth', 'fas fa-bell'],
            ['sidebar', 'Omiljeno', 'route', 'wishlist.index', null, 70, 'auth', 'fas fa-heart'],
            ['sidebar', 'Profil', 'route', 'user.profile', null, 80, 'auth', 'fas fa-user'],
            ['sidebar', 'Podrška', 'route', 'contact.us', null, 90, 'public', 'fas fa-comment-dots'],
            ['sidebar', 'O PepExchu', 'route', 'about.us', null, 100, 'public', 'fas fa-info-circle'],
        ];

        foreach ($defaults as [$location, $label, $type, $route, $url, $order, $visibility, $icon]) {
            NavigationItem::updateOrCreate(
                ['location' => $location, 'label' => $label, 'parent_id' => null],
                [
                    'type' => $type,
                    'route_name' => $route,
                    'url' => $url,
                    'sort_order' => $order,
                    'visibility' => $visibility,
                    'icon' => $icon,
                    'is_visible' => true,
                    'target' => '_self',
                ]
            );
        }

        SettingsService::clearCache();

        return redirect()->route('cms-navigation.index')->with('success', 'Default navigation installed.');
    }

    private function validated(Request $request, ?NavigationItem $item = null): array
    {
        $validated = $request->validate([
            'location' => ['required', Rule::in(['main', 'sidebar', 'footer'])],
            'parent_id' => ['nullable', 'exists:navigation_items,id'],
            'label' => ['required', 'string', 'max:120'],
            'icon' => ['nullable', 'string', 'max:120'],
            'type' => ['required', Rule::in(['route', 'url', 'category_dropdown'])],
            'route_name' => ['nullable', 'string', 'max:120'],
            'url' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
            'visibility' => ['required', Rule::in(['public', 'auth', 'guest'])],
            'target' => ['required', Rule::in(['_self', '_blank'])],
        ]);

        $validated['is_visible'] = $request->boolean('is_visible');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['parent_id'] = $validated['parent_id'] ?: null;

        if ($item && $validated['parent_id'] == $item->id) {
            $validated['parent_id'] = null;
        }

        if ($validated['type'] === 'category_dropdown') {
            $validated['route_name'] = null;
            $validated['url'] = null;
        }

        return $validated;
    }
}
