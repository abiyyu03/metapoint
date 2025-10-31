<?php

namespace App\Filament\Resources\Targets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class TargetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo_path')
                    ->label('Foto')
                    ->width(50)
                    ->height(50)
                    ->disk('public')
                    ->circular(),
                TextColumn::make('fullname')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable()
                    ->description(function ($record): string {
                        $gender = $record->gender === 'L' ? 'Laki-laki' : 'Perempuan';
                        $age = $record->age ?? 'N/A';

                        return "{$gender} ({$age} Tahun)";
                    }),
                TextColumn::make('target_classification')
                    ->label('Klasifikasi')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'kontra' => 'danger',
                        'netral' => 'gray',
                        'pro' => 'success',
                        default => 'white',
                    })
                    ->sortable(),
                TextColumn::make('organization.name')
                    ->label('Kelompok')
                    ->sortable(),
                TextColumn::make('issue.name')
                    ->label('Isu Utama')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
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
