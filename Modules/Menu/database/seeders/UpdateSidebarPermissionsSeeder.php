<?php

namespace Modules\Menu\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Menu\Models\Menu;
use Modules\Menu\Models\MenuItem;

class UpdateSidebarPermissionsSeeder extends Seeder
{
    public function run()
    {
        $menu = Menu::where('name', 'admin-sidebar')->first();

        if (!$menu) {
            $this->command->error("Menu 'admin-sidebar' not found!");
            return;
        }

        $items = [
            // Merchant & Admin Access (view_backend is enough for merchants)
            'Dashboard' => ['view_backend'],
            'Wisata' => ['view_backend'],
            'Kuliner' => ['view_backend'],
            'UMKM' => ['view_backend'],
            
            // Admin Only Access (requires specific admin permissions)
            'Access' => ['manage_users'], // Parent for Users/Roles
            'Users' => ['manage_users'],
            'Roles' => ['manage_roles'],
            'Settings' => ['edit_settings'],
            'Backups' => ['view_backups'],
            'Logs' => ['view_logs'],
            'System' => ['view_backend'], // Maybe restrict?
        ];

        foreach ($items as $name => $permissions) {
            $item = MenuItem::where('menu_id', $menu->id)
                ->where('name', $name)
                ->first();

            if ($item) {
                $item->permissions = $permissions;
                $item->save();
                $this->command->info("Updated permissions for '{$name}'");
            } else {
                // Try searching by similar name or loose match if needed
                 $this->command->warn("Item '{$name}' not found in menu.");
            }
        }
        
        // Clear cache
        \Illuminate\Support\Facades\Cache::forget('spatie.permission.cache');
        \Illuminate\Support\Facades\Cache::flush(); 
    }
}
