<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // When the record is first created, media files aren’t yet attached
        // So, we’ll save normally and handle media ID syncing in afterSave        
        return $data;
    }

    protected function afterCreate(): void
    {
        $record = $this->record;

        // Map your media field → collection name
        $mediaFields = [
            'featured_image' => 'course_category_images',
        ];

        foreach ($mediaFields as $column => $collection) {
            $mediaItem = $record->getFirstMedia($collection);

            if ($mediaItem) {
                $record->update([$column => $mediaItem->id]);
            }
        }
    }
}
