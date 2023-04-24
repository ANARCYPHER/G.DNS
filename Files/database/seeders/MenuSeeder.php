<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $nextOrder = Menu::max('order');
        $menus = [
            [
                'name' => 'WHOIS Lookup',
                'link' => '/whois',
                'order' => ($nextOrder + 1)
            ],
        ];
        foreach ($menus as $menu) {
            if (!Menu::where('name', $menu['name'])->exists()) {
                Menu::create([
                    'name' => $menu['name'],
                    'link' => $menu['link'],
                    'order' => $menu['order']
                ]);
            }
        }
    }
}
