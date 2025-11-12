<?php

namespace App\Filament\Resources\CourseResource\Pages;

use App\Filament\Resources\CourseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;

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

    protected function getHeaderActions(): array
    {
        return [
            Actions\ActionGroup::make([
                Actions\Action::make('aiThumbnail')
                    ->label('AI: Generate Course Thumbnail')
                    ->icon('heroicon-o-photo')
                    ->form([
                        \Filament\Forms\Components\Textarea::make('instructor_prompt')
                            ->label('Additional prompt details')
                            ->rows(3)
                            ->placeholder('Add details to guide the thumbnail generation (colors, style, text overlays, etc.)'),
                    ])
                    ->action(function (array $data) {
                        $options = ['prompt' => $data['instructor_prompt'] ?? null];
                        \App\Jobs\GenerateCourseThumbnailJob::dispatch($this->record->id, $options);
                        Notification::make()->title('Thumbnail generation queued')->success()->send();
                    }),
                Actions\Action::make('aiIntro')
                    ->label('AI: Generate Intro Video')
                    ->icon('heroicon-o-video-camera')
                    ->form([
                        \Filament\Forms\Components\Textarea::make('instructor_prompt')
                            ->label('Additional prompt details')
                            ->rows(4)
                            ->placeholder('Provide guidance for the intro video: tone, key points, voice style, on-screen text'),
                    ])
                    ->action(function (array $data) {
                        $options = ['prompt' => $data['instructor_prompt'] ?? null];
                        \App\Jobs\GenerateCourseIntroVideoJob::dispatch($this->record->id, $options);
                        Notification::make()->title('Intro video job queued')->success()->send();
                    }),
                Actions\Action::make('aiOutline')
                    ->label('AI: Generate Topics & Lessons')
                    ->icon('heroicon-o-document-text')
                    ->form([
                        \Filament\Forms\Components\TextInput::make('industry'),
                        \Filament\Forms\Components\TextInput::make('audience'),
                        \Filament\Forms\Components\TextInput::make('duration')->numeric(),
                        \Filament\Forms\Components\Textarea::make('outcomes')->rows(3),
                        \Filament\Forms\Components\Textarea::make('instructor_prompt')
                            ->label('Extra guidance for outline')
                            ->rows(4)
                            ->placeholder('Add extra instructions for the course outline: teaching approach, prerequisites, emphasis areas'),
                    ])
                    ->action(function (array $data) {
                        $options = $data;
                        $options['prompt'] = $data['instructor_prompt'] ?? null;
                        \App\Jobs\GenerateCourseOutlineJob::dispatch($this->record->id, $options);
                        Notification::make()->title('Outline generation queued')->success()->send();
                    })
            ])->button()->label('AI Assistant')->icon('heroicon-o-sparkles'),
        ];
    }
}
