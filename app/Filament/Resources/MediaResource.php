<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Builder;

class MediaResource extends Resource
{
    protected static ?string $model = Media::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Site Content Management';
    protected static ?string $navigationLabel = 'Media Library';
    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('File Info')
                ->schema([
                    Forms\Components\TextInput::make('file_name')
                        ->disabled(),

                    Forms\Components\TextInput::make('collection_name')
                        ->disabled(),

                    Forms\Components\TextInput::make('mime_type')
                        ->disabled(),

                    Forms\Components\TextInput::make('size')
                        ->disabled()
                        ->suffix(' KB'),

                    Forms\Components\TextInput::make('disk')
                        ->disabled(),
                ])
                ->columns(2),

            Forms\Components\Section::make('SEO & Metadata')
                ->description('Enhance SEO by adding alt text, title and captions.')
                ->schema([
                    Forms\Components\TextInput::make('custom_properties.alt')
                        ->label('Alt Text'),

                    Forms\Components\TextInput::make('custom_properties.title')
                        ->label('Title'),

                    Forms\Components\Textarea::make('custom_properties.caption')
                        ->label('Caption')
                        ->rows(3),
                ])
                ->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('file_name')
                    ->disk('public') // adjust to your disk
                    ->square()
                    ->label('Preview'),

                Tables\Columns\TextColumn::make('file_name')
                    ->label('File Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('collection_name')
                    ->label('Collection')
                    ->sortable()
                    ->badge(),

                Tables\Columns\TextColumn::make('model_type')
                    ->label('Attached To')
                    ->formatStateUsing(fn ($state) => class_basename($state))
                    ->sortable(),

                Tables\Columns\TextColumn::make('model_id')
                    ->label('Model ID'),

                Tables\Columns\TextColumn::make('custom_properties.alt')
                    ->label('Alt Text')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('size')
                    ->numeric()
                    ->suffix(' KB')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('collection_name')
                    ->label('Collection')
                    ->options(
                        Media::query()
                            ->select('collection_name')
                            ->distinct()
                            ->pluck('collection_name', 'collection_name')
                            ->toArray()
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => MediaResource\Pages\ListMedia::route('/'),
            'create' => MediaResource\Pages\CreateMedia::route('/create'),
            'edit'   => MediaResource\Pages\EditMedia::route('/{record}/edit'),
        ];
    }
}
