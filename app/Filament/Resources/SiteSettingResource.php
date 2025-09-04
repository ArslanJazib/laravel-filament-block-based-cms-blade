<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Filament\Resources\SiteSettingResource\RelationManagers;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Site Settings';

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

                        Forms\Components\FileUpload::make('favicon')
                            ->label('Favicon')
                            ->directory('assets/images')
                            ->disk('public')
                            ->preserveFilenames()
                            ->image(),

                        Forms\Components\FileUpload::make('favicon_16x16')
                            ->label('Favicon 16x16')
                            ->directory('assets/images')
                            ->disk('public')
                            ->preserveFilenames()
                            ->image(),

                        Forms\Components\FileUpload::make('favicon_32x32')
                            ->label('Favicon 32x32')
                            ->directory('assets/images')
                            ->disk('public')
                            ->preserveFilenames()
                            ->image(),

                        Forms\Components\FileUpload::make('logo')
                            ->label('Logo')
                            ->directory('assets/images')
                            ->disk('public')
                            ->preserveFilenames()
                            ->image(),

                        Forms\Components\FileUpload::make('apple_touch_icon')
                            ->label('Apple Touch Icon')
                            ->directory('assets/images')
                            ->disk('public')
                            ->preserveFilenames()
                            ->image(),

                        Forms\Components\FileUpload::make('android_chrome_512x512')
                            ->label('Android Chrome 512x512')
                            ->directory('assets/images')
                            ->disk('public')
                            ->preserveFilenames()
                            ->image(),

                        Forms\Components\FileUpload::make('android_chrome_192x192')
                            ->label('Android Chrome 192x192')
                            ->directory('assets/images')
                            ->disk('public')
                            ->preserveFilenames()
                            ->image(),


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
