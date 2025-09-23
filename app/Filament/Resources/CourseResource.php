<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Course;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers\TopicsRelationManager;
use App\Filament\Resources\CourseResource\RelationManagers\LessonsRelationManager;
use App\Filament\Resources\CourseResource\RelationManagers\EnrollmentsRelationManager;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'LMS Management';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = Auth::user();

        if ($user && $user->hasRole('instructor')) {
            // Instructors only see their own courses
            $query = $query->where('instructor_id', $user->id);
        } elseif ($user && $user->hasRole('admin')) {
            // Admins see all courses (no filter applied)
            return $query;
        }

        return $query;

    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->required(),
            Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
            Forms\Components\Select::make('category_id')
                ->relationship('category', 'name')
                ->required(),
            Forms\Components\Select::make('instructor_id')
                ->label('Instructor')
                ->relationship(
                    name: 'instructor',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn ($query) => $query->role('instructor')
                )
                ->searchable()
                ->preload()
                ->required(),
            Forms\Components\FileUpload::make('thumbnail')
                ->image()
                ->directory('courses')
                ->nullable(),
            Forms\Components\FileUpload::make('intro_video')
                ->label('Introductory Video')
                ->preserveFilenames()
                ->directory('courses')
                ->maxSize(204800) // 200MB
                ->acceptedFileTypes([
                    'video/mp4',
                    'video/quicktime',   // mov
                    'video/x-msvideo',   // avi
                    'video/x-matroska',  // mkv
                ])
                ->nullable()
                ->multiple(false),
            Forms\Components\TextInput::make('price')
                ->numeric()
                ->minValue(0)
                ->prefix('$')
                ->required(),
            Forms\Components\Textarea::make('description'),
            Forms\Components\Select::make('status')
                ->options(['draft' => 'Draft', 'published' => 'Published'])
                ->default('draft'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('thumbnail'),
            Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('category.name')->label('Category'),
            Tables\Columns\TextColumn::make('instructor.name')->label('Instructor'),
            Tables\Columns\TextColumn::make('status'),
            Tables\Columns\TextColumn::make('price')->label('Price'),
            Tables\Columns\TextColumn::make('created_at')->dateTime(),
        ])
        ->actions([Tables\Actions\EditAction::make()])
        ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            TopicsRelationManager::class,
            LessonsRelationManager::class,
            EnrollmentsRelationManager::class,
        ];
    }

}
