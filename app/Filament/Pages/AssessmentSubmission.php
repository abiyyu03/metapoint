<?php

namespace App\Filament\Pages;

use App\Models\AssessmentResult\AssessmentResult;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use UnitEnum;

class AssessmentSubmission extends Page implements HasTable
{
    use InteractsWithTable;
    protected string $view = 'filament.pages.assessment-submission';
    protected static string|UnitEnum|null $navigationGroup = 'Assessment';
    protected static ?string $title = 'Hasil Assessment';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentCheck;
    protected static ?string $navigationLabel = 'Hasil Assessment';

    public function table(Table $table): Table
    {
        return $table
            ->query(AssessmentResult::query()->with(['user', 'target', 'agent']))
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('target.fullname')
                    ->label('Nama Target')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('agent.fullname')
                    ->label('Nama Agen')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('issued_at')
                    ->label('Submit pada')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                Action::make('lihat_detail')
                    ->label('Lihat Detail')
                    ->icon('heroicon-o-eye')
                    ->url(fn($record) => route('filament.admin.pages.assessment-submission-detail', $record)),
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