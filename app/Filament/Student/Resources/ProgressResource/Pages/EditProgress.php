<?php

namespace App\Filament\Student\Resources\ProgressResource\Pages;

use App\Filament\Student\Resources\ProgressResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProgress extends EditRecord
{
    protected static string $resource = ProgressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
