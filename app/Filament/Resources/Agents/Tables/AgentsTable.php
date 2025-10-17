<?php

namespace App\Filament\Resources\Agents\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class AgentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fullname')
                    ->label('Nama Lengkap')
                    ->searchable(),
                TextColumn::make('age')
                    ->label('Umur')
                    ->numeric(),
                TextColumn::make('gender')
                    ->label('Jenis Kelamin'),
                // TextColumn::make('organization_id')
                //     ->numeric()
                //     ->sortable(),
                // TextColumn::make('title_id')
                //     ->numeric()
                //     ->sortable(),
                TextColumn::make('operationalUnit.name')
                    ->label('Unit Operasional')
                    ->sortable(),
                TextColumn::make('targets.fullname')
                    ->label('Target')
                    ->badge()
                    ->color('danger')
                    ->separator(', ')
                    ->toggleable(),
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
}
