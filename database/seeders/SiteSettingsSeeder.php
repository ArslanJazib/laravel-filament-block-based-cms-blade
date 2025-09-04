<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::updateOrCreate(
            ['id' => 1],
            [
                'site_title' => 'KANDOR - Transform Your Life',
                'favicon'            => 'assets/images/favicon.ico',
                'favicon_16x16'      => 'assets/images/favicon-16x16.png',
                'favicon_32x32'      => 'assets/images/favicon-32x32.png',
                'logo'               => 'assets/images/icon.png',   
                'apple_touch_icon'   => 'assets/images/apple-touch-icon.png',   
                'android_chrome_512x512' => 'assets/images/android-chrome-512x512.png',   
                'android_chrome_192x192' => 'assets/images/android-chrome-192x192.png',   
                'google_tag_manager' => null,
                'header_menu' => [
                    [
                        'url' => '/home',
                        'label' => 'Home',
                        'submenu' => [],
                    ],
                    [
                        'url' => '/about',
                        'label' => 'About',
                        'submenu' => [
                            ['url' => '/blogs', 'label' => 'Blogs'],
                        ],
                    ],
                    [
                        'url' => '/contact-us',
                        'label' => 'Contact Us',
                        'submenu' => [],
                    ],
                ],
                'footer_menu' => [
                    [
                        'url' => '/privacy',
                        'label' => 'Privacy Policy',
                        'submenu' => [],
                    ],
                    [
                        'url' => '/terms',
                        'label' => 'Terms of Service',
                        'submenu' => [],
                    ],
                ],
                'meta_title' => 'KANDOR - Transform Your Life',
                'meta_description' => 'A platform to help you grow your Mind, Body, Soul & Entrepreneurship.',
                'meta_keywords' => 'mind, body, soul, entrepreneurship, personal growth, self improvement',
            ]
        );
    }
}
