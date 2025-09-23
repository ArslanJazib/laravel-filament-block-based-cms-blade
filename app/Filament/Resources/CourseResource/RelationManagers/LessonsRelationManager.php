<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LessonsRelationManager extends RelationManager
{
    protected static string $relationship = 'lessons';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
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

            Forms\Components\RichEditor::make('content')->nullable(),

            Forms\Components\TextInput::make('video_url')->nullable(),

            Forms\Components\FileUpload::make('resource_files')
                ->label('Resource Files')
                ->directory('lessons/resources')
                ->multiple()
                ->downloadable()
                ->openable()
                ->acceptedFileTypes([
                    // Documents
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',

                    // Excel
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',

                    // PowerPoint
                    'application/vnd.ms-powerpoint',
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation',

                    // Text
                    'text/plain',

                    // Images
                    'image/jpeg',
                    'image/png',
                    'image/gif',
                    'image/webp',
                ])
                ->nullable(),

            Forms\Components\TextInput::make('order')
                ->numeric()
                ->default(0),

            Forms\Components\TextInput::make('duration')
                ->label('Approx Duration (minutes)')
                ->numeric()
                ->minValue(1)
                ->nullable(),
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
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
