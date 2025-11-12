<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AiIntegration;
use Filament\Resources\Resource;
use Filament\Notifications\Notification;
use App\Filament\Resources\AiIntegrationResource\Pages\ListAiIntegrations;
use App\Filament\Resources\AiIntegrationResource\Pages\CreateAiIntegration;
use App\Filament\Resources\AiIntegrationResource\Pages\EditAiIntegration;

class AiIntegrationResource extends Resource
{
    protected static ?string $model = AiIntegration::class;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';
    protected static ?string $navigationGroup = 'AI Integrations';
    protected static ?string $navigationLabel = 'AI Models';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('provider')
                ->label('Provider')
                ->required()
                ->maxLength(100),

            Forms\Components\TextInput::make('model')
                ->label('Model')
                ->required()
                ->maxLength(150),

            Forms\Components\TextInput::make('display_name')
                ->label('Display Name')
                ->maxLength(150),

            Forms\Components\Select::make('model_type')
                ->label('Model Type')
                ->options([
                    'text' => 'Text',
                    'image' => 'Image',
                    'video' => 'Video',
                    'audio' => 'Audio',
                    'multimodal' => 'Multimodal',
                ])
                ->required(),

            Forms\Components\Toggle::make('is_active')
                ->label('Active')
                ->default(false),

            Forms\Components\TextInput::make('priority_order')
                ->label('Priority Order')
                ->numeric()
                ->default(1),

            Forms\Components\TextInput::make('max_requests_per_day')
                ->label('Daily Limit')
                ->numeric(),

            Forms\Components\TextInput::make('max_requests_per_month')
                ->label('Monthly Limit')
                ->numeric(),

            Forms\Components\TextInput::make('estimated_cost_per_request')
                ->label('Estimated Cost (USD)')
                ->numeric()
                ->step('0.00001'),

            Forms\Components\TextInput::make('alerts_at')
                ->label('Alert Threshold (%)')
                ->numeric()
                ->step('0.01'),

            Forms\Components\DateTimePicker::make('last_reset_at')
                ->label('Last Reset'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('provider')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('model')->sortable()->searchable(),
                Tables\Columns\BadgeColumn::make('model_type')
                    ->colors([
                        'info' => 'text',
                        'success' => 'image',
                        'warning' => 'video',
                        'danger' => 'audio',
                        'gray' => 'multimodal',
                    ])
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('priority_order')->sortable(),
                Tables\Columns\TextColumn::make('max_requests_per_day')->label('Daily Limit'),
                Tables\Columns\TextColumn::make('estimated_cost_per_request')->money('usd')->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('enable')
                        ->label('Enable Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each->update(['is_active' => true]))
                        ->after(fn () => Notification::make()
                            ->title('Selected integrations enabled successfully.')
                            ->success()
                            ->send()),

                    Tables\Actions\BulkAction::make('disable')
                        ->label('Disable Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each->update(['is_active' => false]))
                        ->after(fn () => Notification::make()
                            ->title('Selected integrations disabled successfully.')
                            ->success()
                            ->send()),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAiIntegrations::route('/'),
            'create' => CreateAiIntegration::route('/create'),
            'edit' => EditAiIntegration::route('/{record}/edit'),
        ];
    }
}
