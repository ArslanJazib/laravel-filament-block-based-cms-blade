<?php

namespace App\Filament\Resources\SiteSettingResource\Pages;

use App\Filament\Resources\SiteSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSiteSetting extends CreateRecord
{
    protected static string $resource = SiteSettingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // When the record is first created, media files aren’t yet attached
        // So, we’ll save normally and handle media ID syncing in afterSave
        return $data;
    }

    protected function afterCreate(): void
    {
        $record = $this->record;

        // Define media field => collection mapping
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
                $record->update([$column => $mediaItem->id]);
            }
        }
    }
}
