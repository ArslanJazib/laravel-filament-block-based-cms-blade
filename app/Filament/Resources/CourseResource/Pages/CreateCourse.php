<?php

namespace App\Filament\Resources\CourseResource\Pages;

use App\Filament\Resources\CourseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCourse extends CreateRecord
{
    protected static string $resource = CourseResource::class;

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
            'thumbnail' => 'course-thumbnails',
            'intro_video' => 'course-videos',
        ];

        foreach ($mediaFields as $column => $collection) {
            $mediaItem = $record->getFirstMedia($collection);

            if ($mediaItem) {
                $record->update([$column => $mediaItem->id]);
            }
        }
    }
}
