<?php

namespace App\Filament\Instructor\Resources\LessonResource\Pages;

use App\Filament\Instructor\Resources\LessonResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLesson extends CreateRecord
{
    protected static string $resource = LessonResource::class;
}
