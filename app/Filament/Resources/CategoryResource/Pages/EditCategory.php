<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $record = $this->record;

        $mediaFields = [
            'featured_image' => 'course_category_images',
        ];

        foreach ($mediaFields as $column => $collection) {
            $mediaItem = $record->getFirstMedia($collection);

            $data[$column] = $mediaItem ? $mediaItem->id : null;
        }

        return $data;
    }
}
