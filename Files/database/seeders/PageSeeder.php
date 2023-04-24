<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $pages = [
            [
                'title' => 'WHOIS Lookup',
                'slug' => 'whois',
                'content' => '<h1>WHOIS Lookup</h1><p>Whois domain lookup allows you to trace the ownership and tenure of a domain name. Similar to how all houses are registered with governing authority, all domain name registries maintain a record of information about every domain name purchased through them, along with who owns it, and the date till which it has been purchased.</p><p>[split]</p><p>You can search for an unlimited number of domains!</p>',
                'meta' => null,
                'header' => null
            ],
        ];
        foreach ($pages as $page) {
            if (!Page::where('slug', $page['slug'])->exists()) {
                Page::create([
                    'title' => $page['title'],
                    'slug' => $page['slug'],
                    'content' => $page['content'],
                    'meta' => $page['meta'],
                    'header' => $page['header'],
                ]);
            }
        }
    }
}
