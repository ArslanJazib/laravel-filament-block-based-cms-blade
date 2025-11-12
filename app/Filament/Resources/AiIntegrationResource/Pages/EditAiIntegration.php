<?php

namespace App\Filament\Resources\AiIntegrationResource\Pages;

use App\Filament\Resources\AiIntegrationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAiIntegration extends EditRecord
{
    protected static string $resource = AiIntegrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
