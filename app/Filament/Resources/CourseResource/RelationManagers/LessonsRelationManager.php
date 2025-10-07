<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Database\Eloquent\Model;

class LessonsRelationManager extends RelationManager
{
    protected static string $relationship = 'lessons';

    public function form(Form $form): Form
    {
        return $form->schema([
            // Basic Lesson Info
            Forms\Components\Section::make('Lesson Details')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Lesson Title')
                        ->required(),

                    Forms\Components\Select::make('topic_id')
                        ->label('Topic')
                        ->options(fn () =>
                            $this->getOwnerRecord()
                                ?->topics()
                                ->orderBy('order')
                                ->pluck('title', 'id')
                        )
                        ->searchable()
                        ->preload()
                        ->required(),

                    Forms\Components\TextInput::make('order')
                        ->label('Lesson Order')
                        ->numeric()
                        ->default(0),

                    Forms\Components\TextInput::make('duration')
                        ->label('Approx Duration (minutes)')
                        ->numeric()
                        ->minValue(1)
                        ->nullable(),
                ]),

            // Main Content Grid
            Forms\Components\Grid::make(2)
                ->schema([
                    Forms\Components\RichEditor::make('content')
                        ->label('Lesson Notes')
                        ->required()
                        ->toolbarButtons([
                            'bold', 'italic', 'underline', 'strike',
                            'h2', 'h3', 'h4', 'blockquote', 'codeBlock',
                            'bulletList', 'orderedList', 'link', 'image', 'redo', 'undo', 'hr',
                        ])
                        ->disableAllToolbarButtons(false)
                        ->columnSpan(2)
                        ->extraAttributes(['style' => 'min-height: 600px;'])
                        ->nullable(),

                    Forms\Components\Card::make([
                        SpatieMediaLibraryFileUpload::make('video_url')
                            ->label('Video File')
                            ->collection('lesson-videos')
                            ->preserveFilenames()
                            ->maxSize(204800)
                            ->acceptedFileTypes([
                                'video/mp4',
                                'video/quicktime',
                                'video/x-msvideo',
                                'video/x-matroska',
                            ])
                            ->nullable()
                            ->multiple(false),

                        SpatieMediaLibraryFileUpload::make('resource_files')
                            ->label('Lesson Resources')
                            ->collection('lesson-resources')
                            ->preserveFilenames()
                            ->multiple()
                            ->downloadable()
                            ->openable()
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'application/vnd.ms-powerpoint',
                                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                'text/plain',
                                'image/jpeg',
                                'image/png',
                                'image/gif',
                                'image/webp',
                            ])
                            ->nullable(),
                    ])->columnSpan(2),
                ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('topic.title')->label('Topic'),
                Tables\Columns\TextColumn::make('order')->sortable(),
                Tables\Columns\TextColumn::make('duration')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(fn(array $data): array => $this->mutateLessonFormData($data))
                    ->after(fn(Model $record) => $this->syncLessonMedia($record)),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(fn(array $data): array => $this->mutateLessonFormData($data))
                    ->after(fn(Model $record) => $this->syncLessonMedia($record)),

                Tables\Actions\DeleteAction::make(),
            ]);
    }

    protected function mutateLessonFormData(array $data): array
    {
        // You can safely adjust lesson data here if needed
        return $data;
    }

    protected function syncLessonMedia(Model $record): void
    {
        $mediaMap = [
            'video_url' => 'lesson-videos',
            'resource_files' => 'lesson-resources',
        ];

        foreach ($mediaMap as $column => $collection) {
            $mediaItems = $record->getMedia($collection);

            $record->update([
                $column => $column === 'resource_files'
                    ? $mediaItems->pluck('id')->toArray()
                    : optional($mediaItems->first())->id,
            ]);
        }
    }
}
