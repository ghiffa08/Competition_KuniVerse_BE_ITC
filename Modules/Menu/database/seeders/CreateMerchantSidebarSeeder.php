<?php

namespace Modules\Menu\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Menu\Models\Menu;
use Modules\Menu\Models\MenuItem;

class CreateMerchantSidebarSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Menu
        // 1. Create Menu
        $menu = Menu::updateOrCreate(
            ['slug' => 'merchant-sidebar'],
            [
                'name' => 'Merchant Sidebar',
                'location' => 'merchant-sidebar',
                'is_active' => true,
                'is_visible' => true,
            ]
        );

        // 2. Clear existing items (idempotency)
        MenuItem::where('menu_id', $menu->id)->forceDelete();

        // 3. Add Items
        $items = [
            [
                'name' => 'Dashboard',
                'url' => '#',
                'route_name' => 'merchant.dashboard',
                'icon' => 'fa-solid fa-gauge',
                'sort_order' => 1,
                'permissions' => ['view_backend'], // Merchants have this
            ],
            [
                'name' => 'Wisata',
                'url' => '#',
                'route_name' => 'merchant.wisata.index',
                'icon' => 'fa-regular fa-sun',
                'sort_order' => 2,
                'permissions' => ['view_backend'], // or view_tourisms if separate
            ],
            [
                'name' => 'Kuliner',
                'url' => '#',
                'route_name' => 'merchant.kuliner.index',
                'icon' => 'fa-solid fa-utensils',
                'sort_order' => 3,
                'permissions' => ['view_backend'],
            ],
            [
                'name' => 'UMKM',
                'url' => '#',
                'route_name' => 'merchant.umkm.index',
                'icon' => 'fa-solid fa-store',
                'sort_order' => 4,
                'permissions' => ['view_backend'],
            ],
        ];

        foreach ($items as $itemData) {
            MenuItem::create([
                'menu_id' => $menu->id,
                'name' => $itemData['name'],
                'url' => $itemData['url'],
                'route_name' => $itemData['route_name'],
                'icon' => $itemData['icon'],
                'sort_order' => $itemData['sort_order'],
                'permissions' => $itemData['permissions'],
                'is_active' => true,
                'is_visible' => true,
            ]);
        }
        
        // Clear cache
        \Illuminate\Support\Facades\Cache::forget('spatie.permission.cache');
        \Illuminate\Support\Facades\Cache::flush();
        
        $this->command->info("Merchant Sidebar created successfully with correct routes.");
    }
}
