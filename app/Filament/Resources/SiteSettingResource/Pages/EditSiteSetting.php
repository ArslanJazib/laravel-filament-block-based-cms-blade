<?php

namespace App\Filament\Resources\SiteSettingResource\Pages;

use App\Filament\Resources\SiteSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Arr;

class EditSiteSetting extends EditRecord
{
    protected static string $resource = SiteSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Get the model instance
        $record = $this->record;

        // Loop through defined media fields
        $mediaFields = [
            'favicon' => 'favicons',
            'favicon_16x16' => 'favicons_16x16',
            'favicon_32x32' => 'favicons_32x32',
            'logo' => 'site_logos',
            'apple_touch_icon' => 'apple_touch_icons',
            'android_chrome_512x512' => 'android_chrome_icons_512x512',
            'android_chrome_192x192' => 'android_chrome_icons_192x192',
        ];

        foreach ($mediaFields as $column => $collection) {
            $mediaItem = $record->getFirstMedia($collection);

            if ($mediaItem) {
                // Save the media ID in DB column (as integer)
                $data[$column] = $mediaItem->id;
            } else {
                // Clear if no media is present
                $data[$column] = null;
            }
        }

        return $data;
    }
}
