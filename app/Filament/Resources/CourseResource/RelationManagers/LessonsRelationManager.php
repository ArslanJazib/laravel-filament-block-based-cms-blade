<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

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
                    // RichEditor - Full Width & Tall
                    Forms\Components\RichEditor::make('content')
                        ->label('Lesson Notes')
                        ->required()
                        ->toolbarButtons([
                            'bold','italic','underline','strike',
                            'h2','h3','h4','blockquote','codeBlock',
                            'bulletList','orderedList','link','image','redo','undo','hr',
                        ])
                        ->disableAllToolbarButtons(false)
                        ->columnSpan(2) // full width
                        ->extraAttributes([
                            'style' => 'min-height: 600px;'
                        ])
                        ->nullable(),

                    // Video & Resources Card (right side)
                    Forms\Components\Card::make([
                        Forms\Components\FileUpload::make('video_url')
                            ->label('Video File')
                            ->directory('lessons/videos')
                            ->preserveFilenames()
                            ->maxSize(204800) // 200MB
                            ->acceptedFileTypes([
                                'video/mp4',
                                'video/quicktime',   // mov
                                'video/x-msvideo',   // avi
                                'video/x-matroska',  // mkv
                            ])
                            ->nullable()
                            ->multiple(false),

                        Forms\Components\FileUpload::make('resource_files')
                            ->label('Lesson Resources')
                            ->directory('lessons/resources')
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
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
