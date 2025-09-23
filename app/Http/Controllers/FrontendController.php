<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    /**
     * Render any frontend page.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function page(string $slug = '/')
    {
        // Get site settings
        $siteSettings = SiteSetting::first();

        $page = Page::with([
            'blocks' => function ($q) {
                $q->select('id', 'page_id', 'block_id', 'sort_order', 'content')
                ->with(['block:id,slug,view']);
            }
        ])
        ->where('slug', $slug)
        ->firstOrFail();

        // Get header/footer from settings if needed
        $siteSettings = \App\Models\SiteSetting::first();

        // Pass to the view
        return view('frontend.page', [
            'page' => $page,
            'blocks' => $page->blocks,
            'menuItems' => $siteSettings->header_menu ?? [],
            'footerMenu' => $siteSettings->footer_menu ?? [],
            'settings' => $siteSettings,
        ]);
    }
}