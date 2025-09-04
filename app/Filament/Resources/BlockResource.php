<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlockResource\Pages;
use App\Models\Block;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\File;

class BlockResource extends Resource
{
    protected static ?string $model = Block::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Site Content Management';
    protected static ?string $navigationLabel = 'Blocks';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Block')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(Block::class, 'slug', ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\Select::make('view')
                            ->label('Blade View')
                            ->options(self::getAvailableBlockViews())
                            ->searchable()
                            ->helperText('Path like <code>blocks.gallery.gallery</code>')
                            ->columnSpanFull()
                            ->required(),
                    ]),

                Forms\Components\Section::make('Field Schema')
                    ->description('Define any fields your block needs. These definitions drive the page editor UI.')
                    ->schema([
                        // Store the whole schema as JSON in blocks.schema
                        Forms\Components\Repeater::make('schema')
                            ->label('Fields')
                            ->default([])
                            ->collapsed()
                            ->reorderable(true)
                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? $state['key'] ?? 'Field')
                            ->schema(self::fieldDefinitionSchema())
                            ->cloneable(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('slug')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('view')
                    ->label('View'),

                Tables\Columns\TextColumn::make('schema')
                    ->label('Fields')
                    ->formatStateUsing(fn ($state) => is_array($state) ? count($state) . ' field(s)' : '—'),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index'  => Pages\ListBlocks::route('/'),
            'create' => Pages\CreateBlock::route('/create'),
            'edit'   => Pages\EditBlock::route('/{record}/edit'),
        ];
    }

    /**
     * Schema used by the Repeater to define a single field in the block.
     * Supports nested "repeater" fields via a sub-repeater.
     */
    private static function fieldDefinitionSchema(): array
    {
        return [
            Forms\Components\TextInput::make('key')
                ->label('Key')
                ->required()
                ->maxLength(64)
                ->helperText('Machine name. Used as the array key inside the block content (e.g. "title", "images").'),

            Forms\Components\TextInput::make('label')
                ->label('Label')
                ->required()
                ->maxLength(120),

            Forms\Components\Select::make('type')
                ->label('Type')
                ->options(self::fieldTypeOptions())
                ->required()
                ->reactive(),

            Forms\Components\Toggle::make('required')
                ->label('Required')
                ->default(false),

            Forms\Components\Textarea::make('help')
                ->label('Help Text')
                ->rows(2)
                ->columnSpanFull(),

            // Type-specific options
            Forms\Components\TextInput::make('placeholder')
                ->visible(fn (Get $get) => in_array($get('type'), ['text','textarea','richtext','url','number','color']))
                ->maxLength(255),

            Forms\Components\TextInput::make('min')
                ->numeric()
                ->visible(fn (Get $get) => in_array($get('type'), ['number']))
                ->helperText('Minimum value'),

            Forms\Components\TextInput::make('max')
                ->numeric()
                ->visible(fn (Get $get) => in_array($get('type'), ['number']))
                ->helperText('Maximum value'),

            Forms\Components\KeyValue::make('options')
                ->label('Options (value => label)')
                ->visible(fn (Get $get) => in_array($get('type'), ['select']))
                ->addButtonLabel('Add option')
                ->columnSpanFull(),

            Forms\Components\Toggle::make('multiple')
                ->label('Allow multiple')
                ->visible(fn (Get $get) => in_array($get('type'), ['select','image','file','repeater'])),

            Forms\Components\Repeater::make('fields')
                ->label('Repeater Subfields')
                ->visible(fn (Get $get) => $get('type') === 'repeater')
                ->collapsed()
                ->reorderable(true)
                ->schema([
                    Forms\Components\TextInput::make('key')->required()->maxLength(64),
                    Forms\Components\TextInput::make('label')->required()->maxLength(120),

                    Forms\Components\Select::make('type')
                        ->options(self::fieldTypeOptions(excludeRepeater: false))
                        ->required()
                        ->reactive(),

                    // renamed to avoid recursive clash
                    Forms\Components\Repeater::make('subfields')
                        ->label('Nested Subfields')
                        ->visible(fn (Get $get) => $get('type') === 'repeater')
                        ->collapsed()
                        ->reorderable(true)
                        ->schema([
                            Forms\Components\TextInput::make('key')->required()->maxLength(64),
                            Forms\Components\TextInput::make('label')->required()->maxLength(120),
                            Forms\Components\Select::make('type')
                                ->options(self::fieldTypeOptions(excludeRepeater: false))
                                ->required()
                                ->reactive(),
                        ])
                        ->columnSpanFull(),
                ])
                ->columnSpanFull()

        ];
    }

    private static function fieldTypeOptions(bool $excludeRepeater = false): array
    {
        $types = [
            'text'     => 'Text',
            'textarea' => 'Textarea',
            'richtext' => 'Rich Text',
            'number'   => 'Number',
            'select'   => 'Select',
            'toggle'   => 'Toggle',
            'checkbox' => 'Checkbox',
            'image'    => 'Image Upload',
            'file'     => 'File Upload',
            'url'      => 'URL',
            'color'    => 'Color',
            'date'     => 'Date',
            'datetime' => 'DateTime',
            'repeater' => 'Repeater',
        ];

        if ($excludeRepeater) {
            unset($types['repeater']);
        }

        return $types;
    }

    /**
     * Recursively scan resources/views/blocks for *.blade.php and map to view keys.
     * e.g. resources/views/blocks/gallery/gallery.blade.php -> blocks.gallery.gallery
     */
    private static function getAvailableBlockViews(): array
    {
        $root = resource_path('views/blocks');
        if (! File::exists($root)) {
            return [];
        }

        $views = [];
        foreach (File::allFiles($root) as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }

            $relative = str_replace([resource_path('views') . DIRECTORY_SEPARATOR, '.blade.php'], '', $file->getRealPath());
            $viewKey  = str_replace(DIRECTORY_SEPARATOR, '.', $relative);

            // Human label from the last segment
            $label = ucfirst(str_replace(['-', '_'], ' ', basename($relative)));
            $views[$viewKey] = $viewKey . " ({$label})";
        }

        ksort($views);

        return $views;
    }
}