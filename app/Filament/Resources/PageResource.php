<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use App\Models\Block;
use App\Models\PageBlock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Components\Component;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Site Content Management';
    protected static ?string $navigationLabel = 'Pages';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                            ->visible(fn ($get) => $get('is_published')),
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
                                Forms\Components\Select::make('block_id')
                                    ->label('Block')
                                    ->options(Block::pluck('name', 'id')->toArray())
                                    ->searchable()
                                    ->required()
                                    ->reactive(),

                                Forms\Components\Builder::make('content')
                                    ->label('Block Content')
                                    ->blocks(fn (Get $get) => self::resolveBlockSchema($get('block_id')))
                                    ->columnSpanFull()
                                    ->visible(fn (Get $get) => filled($get('block_id'))),
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
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('slug')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->boolean()
                    ->label('Published'),

                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
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
     * Convert a Block's schema (stored as JSON) into Builder blocks for page editor.
     */
    private static function resolveBlockSchema(?int $blockId): array
    {
        if (! $blockId) {
            return [];
        }

        $block = Block::find($blockId);

        if (! $block || empty($block->schema) || ! is_array($block->schema)) {
            return [];
        }

        return [
            Forms\Components\Builder\Block::make($block->slug ?? "block_{$block->id}")
                ->label($block->name)
                ->schema(
                    collect($block->schema)
                        ->map(fn ($field) => self::mapSchemaFieldToComponent($field, $block->slug))
                    ->filter()
                    ->toArray()
            ),
        ];
    }

    /**
     * Map a Block schema field to a Filament form component.
     */
    private static function mapSchemaFieldToComponent(array $field, string $blockSlug): ?Component
    {
        return match ($field['type'] ?? null) {
            'text'     => Forms\Components\TextInput::make($field['key'])->label($field['label']),
            'textarea' => Forms\Components\Textarea::make($field['key'])->label($field['label']),
            'richtext' => Forms\Components\RichEditor::make($field['key'])->label($field['label']),
            'number'   => Forms\Components\TextInput::make($field['key'])->numeric()->label($field['label']),
            'select'   => Forms\Components\Select::make($field['key'])->options($field['options'] ?? [])->label($field['label']),
            'toggle'   => Forms\Components\Toggle::make($field['key'])->label($field['label']),
            'checkbox' => Forms\Components\Checkbox::make($field['key'])->label($field['label']),
            'image' => Forms\Components\FileUpload::make($field['key'])
                ->image()
                ->directory("blocks/{$blockSlug}/images")
                ->label($field['label']),

            'file' => Forms\Components\FileUpload::make($field['key'])
                ->directory("blocks/{$blockSlug}/files")
                ->label($field['label']),
            'url'      => Forms\Components\TextInput::make($field['key'])->url()->label($field['label']),
            'color'    => Forms\Components\ColorPicker::make($field['key'])->label($field['label']),
            'date'     => Forms\Components\DatePicker::make($field['key'])->label($field['label']),
            'datetime' => Forms\Components\DateTimePicker::make($field['key'])->label($field['label']),
            'repeater' => Forms\Components\Repeater::make($field['key'])
                ->schema(
                    collect($field['fields'] ?? $field['subfields'] ?? [])
                        ->map(fn ($child) => self::mapSchemaFieldToComponent($child, $blockSlug))
                        ->filter()
                        ->toArray()
                )
                ->label($field['label'])
                ->collapsed(),
            default    => null,
        };
    }
}
