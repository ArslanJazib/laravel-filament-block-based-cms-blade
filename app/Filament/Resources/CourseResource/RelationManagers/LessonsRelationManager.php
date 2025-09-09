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

            Forms\Components\FileUpload::make('resource_file')
                ->directory('lessons/resources')
                ->nullable(),

            Forms\Components\TextInput::make('order')
                ->numeric()
                ->default(0),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('topic.title')->label('Topic'),
                Tables\Columns\TextColumn::make('order')->sortable(),
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
