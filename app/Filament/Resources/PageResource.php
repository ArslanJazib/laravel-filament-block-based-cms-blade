<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use App\Models\Block;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Components\Component;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Site Content Management';
    protected static ?string $navigationLabel = 'Pages';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Page Details')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(Page::class, 'slug', ignoreRecord: true)
                        ->maxLength(255),

                    Forms\Components\Toggle::make('is_published')
                        ->label('Published'),

                    Forms\Components\DateTimePicker::make('published_at')
                        ->label('Publish Date')
                        ->visible(fn(Get $get): bool => (bool) $get('is_published')),
                ]),

            Forms\Components\Section::make('Page Blocks')
                ->description('Select and order blocks to build your page.')
                ->schema([
                    Forms\Components\HasManyRepeater::make('blocks')
                        ->relationship('blocks')
                        ->orderable('sort_order')
                        ->label('Blocks')
                        ->collapsed()
                        ->schema([
                            Forms\Components\Hidden::make('uuid')
                                ->default(fn(): string => (string) Str::uuid())
                                ->dehydrated(true),

                            Forms\Components\Select::make('block_id')
                                ->label('Block')
                                ->options(Block::pluck('name', 'id')->toArray())
                                ->searchable()
                                ->required()
                                ->reactive(),

                            Forms\Components\Builder::make('content')
                                ->label('Block Content')
                                ->blocks(fn(Get $get): array =>
                                    self::resolveBlockSchema($get('block_id'), $get('uuid'))
                                )
                                ->columnSpanFull()
                                ->visible(fn(Get $get): bool => filled($get('block_id'))),
                        ])
                        ->cloneable()
                        ->columnSpanFull(),
                ])
                ->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('slug')->sortable(),
                Tables\Columns\IconColumn::make('is_published')->boolean()->label('Published'),
                Tables\Columns\TextColumn::make('published_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit'   => Pages\EditPage::route('/{record}/edit'),
        ];
    }

    /**
     * Convert a Block's schema into Builder blocks for the page editor.
     */
    private static function resolveBlockSchema(?int $blockId, ?string $blockUuid = null): array
    {
        if (!$blockId) return [];

        $block = Block::find($blockId);
        if (!$block || empty($block->schema) || !is_array($block->schema)) return [];

        return [
            Forms\Components\Builder\Block::make($block->slug ?? "block_{$block->id}")
                ->label($block->name)
                ->schema(
                    collect($block->schema)
                        ->map(fn($field) => self::mapSchemaFieldToComponent($field, $block->slug, $blockUuid))
                        ->filter()
                        ->toArray()
                ),
        ];
    }

    /**
     * Map a Block schema field to a Filament form component.
     */
    private static function mapSchemaFieldToComponent(array $field, string $blockSlug, ?string $blockUuid = null): ?Component
    {
        $key = $field['key'] ?? null;
        $type = $field['type'] ?? null;

        if (!$key) return null;

        $collectionClosure = fn(Get $get, string $suffix): string =>
            "blocks_{$blockSlug}_" . ($get('uuid') ?? $blockUuid ?? Str::uuid()) . "_{$suffix}";

        return match ($type) {
            'text' => Forms\Components\TextInput::make($key)->label($field['label']),
            'textarea' => Forms\Components\Textarea::make($key)->label($field['label']),
            'richtext' => Forms\Components\RichEditor::make($key)->label($field['label']),
            'number' => Forms\Components\TextInput::make($key)->numeric()->label($field['label']),
            'select' => Forms\Components\Select::make($key)->options($field['options'] ?? [])->label($field['label']),
            'toggle' => Forms\Components\Toggle::make($key)->label($field['label']),
            'checkbox' => Forms\Components\Checkbox::make($key)->label($field['label']),
            'url' => Forms\Components\TextInput::make($key)->url()->label($field['label']),
            'color' => Forms\Components\ColorPicker::make($key)->label($field['label']),
            'date' => Forms\Components\DatePicker::make($key)->label($field['label']),
            'datetime' => Forms\Components\DateTimePicker::make($key)->label($field['label']),

            'image' => Forms\Components\SpatieMediaLibraryFileUpload::make($key)
                ->collection(fn(Get $get): string => $collectionClosure($get, 'images'))
                ->image()
                ->downloadable()
                ->label($field['label']),

            'file' => Forms\Components\SpatieMediaLibraryFileUpload::make($key)
                ->collection(fn(Get $get): string => $collectionClosure($get, 'files'))
                ->downloadable()
                ->openable()
                ->label($field['label']),

            'repeater' => Forms\Components\Repeater::make($key)
                ->schema(array_merge(
                    [
                        Forms\Components\Hidden::make('uuid')
                            ->default(fn(): string => (string) Str::uuid())
                            ->dehydrated(true),
                    ],
                    collect($field['fields'] ?? $field['subfields'] ?? [])
                        ->map(fn($child) => self::mapSchemaFieldToComponent($child, $blockSlug, $blockUuid))
                        ->filter()
                        ->toArray()
                ))
                ->collapsed()
                ->label($field['label']),
            default => null,
        };
    }
}
