<?php

namespace App\Filament\Resources\Targets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class TargetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->searchable(),
                TextColumn::make('age')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('gender'),
                TextColumn::make('organization.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('title.name')
                    ->sortable(),
                TextColumn::make('village.name')
                    ->sortable(),
                TextColumn::make('district.name')
                    ->sortable(),
                TextColumn::make('city.name')
                    ->sortable(),
                TextColumn::make('province.name')
                    ->sortable(),
                TextColumn::make('country.name')
                    ->sortable(),
                TextColumn::make('lat')
                    ->label('Latitude')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lng')
                    ->label('Longitude')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('issue.name')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getModelLabel(): string
    {
        return 'Target';
    }
}
