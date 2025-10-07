<?php

namespace App\Filament\Resources;

use Str;
use App\Models\Tag;
use Filament\Forms;
use App\Models\Blog;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\BlogCategory;
use Filament\Resources\Resource;
use App\Filament\Resources\BlogResource\Pages;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationGroup = 'Site Content Management';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn($state, $set) => $set('slug', \Str::slug($state))),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(Blog::class, 'slug', ignoreRecord: true),

                Forms\Components\Textarea::make('excerpt')->rows(3),

                Forms\Components\RichEditor::make('content')->required(),

                // Category select with create-on-the-fly
                Forms\Components\Select::make('category_id')
                    ->label('Category')
                    ->options(BlogCategory::pluck('name','id'))
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')->required(),
                        Forms\Components\Textarea::make('description')->rows(2),
                    ])
                    ->createOptionUsing(fn(array $data) => BlogCategory::create([
                        'name' => $data['name'],
                        'description' => $data['description'] ?? null,
                        'slug' => Str::slug($data['name']),
                    ])->id),

                // Tags multi-select with create-on-the-fly
                Forms\Components\MultiSelect::make('tags')
                    ->relationship('tags', 'name')
                    ->preload()
                    ->searchable()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')->required(),
                    ])
                    ->createOptionUsing(fn(array $data) => Tag::create([
                        'name' => $data['name'],
                        'slug' => \Str::slug($data['name']),
                    ])->id),

                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ])
                    ->default('draft')
                    ->required(),

                Forms\Components\DateTimePicker::make('published_at'),

                SpatieMediaLibraryFileUpload::make('featured_image')
                    ->collection('blog-featured')
                    ->image()
                    ->maxFiles(1),

                Forms\Components\Hidden::make('author_id')->default(fn () => auth()->id())
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('author.name')->label('Author'),
                Tables\Columns\TextColumn::make('status')->sortable(),
                Tables\Columns\TextColumn::make('published_at')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([
                    'draft'=>'Draft',
                    'published'=>'Published',
                    'archived'=>'Archived',
                ])
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('publish')
                    ->label('Publish')
                    ->action(fn(Blog $record) => $record->update([
                        'status'=>'published',
                        'published_at'=>now()
                    ]))
                    ->visible(fn(Blog $record) => $record->status !== 'published'),
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
            // Add RelationManagers here if needed, e.g. Tags, Comments
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}