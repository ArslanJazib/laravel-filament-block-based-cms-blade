<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\SiteSetting;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SiteSettingResource\Pages;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\SiteSettingResource\RelationManagers;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Site Settings';
    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('General')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('site_title')
                            ->required()
                            ->maxLength(191)
                            ->default('My Site'),

                SpatieMediaLibraryFileUpload::make('favicon')
                    ->collection('favicons')
                    ->preserveFilenames()
                    ->label('Favicon')
                    ->image()
                    ->maxFiles(1),


                SpatieMediaLibraryFileUpload::make('favicon_16x16')
                    ->collection('favicons_16x16')
                    ->preserveFilenames()
                    ->label('Favicon 16x16')
                    ->image()
                    ->maxFiles(1),

                SpatieMediaLibraryFileUpload::make('favicon_32x32')
                    ->collection('favicons_32x32')
                    ->preserveFilenames()
                    ->label('Favicon 32x32')
                    ->image()
                    ->maxFiles(1),

                SpatieMediaLibraryFileUpload::make('logo')
                    ->collection('site_logos')
                    ->preserveFilenames()
                    ->label('Logo')
                    ->image()
                    ->maxFiles(1),

                SpatieMediaLibraryFileUpload::make('apple_touch_icon')
                    ->collection('apple_touch_icons')
                    ->preserveFilenames()
                    ->label('Apple Touch Icon')
                    ->image()
                    ->maxFiles(1),

                SpatieMediaLibraryFileUpload::make('android_chrome_512x512')
                    ->collection('android_chrome_icons_512x512')
                    ->preserveFilenames()
                    ->label('Android Chrome 512x512')
                    ->image()
                    ->maxFiles(1),

                SpatieMediaLibraryFileUpload::make('android_chrome_192x192')
                    ->collection('android_chrome_icons_192x192')
                    ->preserveFilenames()
                    ->label('Android Chrome 192x192')
                    ->image()
                    ->maxFiles(1),

                Forms\Components\Textarea::make('google_tag_manager')
                    ->label('Google Tag Manager Code')
                    ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Header Menu')
                    ->schema([
                        Forms\Components\Repeater::make('header_menu')
                            ->label('Menu Items')
                            ->schema([
                                Forms\Components\TextInput::make('label')->required()->label('Label'),
                                Forms\Components\TextInput::make('url')->required()->label('URL'),
                                Forms\Components\Repeater::make('submenu')
                                    ->label('Sub-menu')
                                    ->schema([
                                        Forms\Components\TextInput::make('label')->required()->label('Label'),
                                        Forms\Components\TextInput::make('url')->required()->label('URL'),
                                    ])
                                    ->collapsed()
                                    ->orderable(),
                            ])
                            ->default([])
                            ->orderable()
                            ->collapsed()
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Footer Menu')
                    ->schema([
                        Forms\Components\Repeater::make('footer_menu')
                            ->label('Menu Items')
                            ->schema([
                                Forms\Components\TextInput::make('label')->required()->label('Label'),
                                Forms\Components\TextInput::make('url')->required()->label('URL'),
                                Forms\Components\Repeater::make('submenu')
                                    ->label('Sub-menu')
                                    ->schema([
                                        Forms\Components\TextInput::make('label')->required()->label('Label'),
                                        Forms\Components\TextInput::make('url')->required()->label('URL'),
                                    ])
                                    ->collapsed()
                                    ->orderable(),
                            ])
                            ->default([])
                            ->orderable()
                            ->collapsed()
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('SEO & Metadata')
                    ->columns(1)
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')->label('Meta Title')->maxLength(191),
                        Forms\Components\Textarea::make('meta_description')->label('Meta Description'),
                        Forms\Components\TextInput::make('meta_keywords')->label('Meta Keywords'),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('site_title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('meta_title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('meta_keywords')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}
