<?php

namespace App\Filament\Resources\TargetEvaluationAttitudes;

use App\Filament\Resources\TargetEvaluationAttitudes\Pages\{
    CreateTargetEvaluationAttitude,
    EditTargetEvaluationAttitude,
    ListTargetEvaluationAttitudes
};
use App\Filament\Resources\TargetEvaluationAttitudes\Schemas\TargetEvaluationAttitudeForm;
use App\Filament\Resources\TargetEvaluationAttitudes\Tables\TargetEvaluationAttitudesTable;
use App\Models\TargetEvaluationAttitude;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use BackedEnum;
use UnitEnum;

class TargetEvaluationAttitudeResource extends Resource
{
    /** @var class-string<\App\Models\TargetEvaluationAttitude> */
    protected static ?string $model = TargetEvaluationAttitude::class;
    protected bool $shouldRedirectToRecord = false;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Flag;
    protected static ?string $navigationLabel = 'Klasifikasi Target';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $slug = 'master/klasifikasi-target';
    protected static ?int $navigationSort = 3;
    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    public static function form(Schema $schema): Schema
    {
        return TargetEvaluationAttitudeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TargetEvaluationAttitudesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListTargetEvaluationAttitudes::route('/'),
            'create' => CreateTargetEvaluationAttitude::route('/create'),
            'edit'   => EditTargetEvaluationAttitude::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }

    public static function getPluralLabel(): ?string
    {
        return 'Klasifikasi Target';
    }

    public static function getModelLabel(): string
    {
        return 'Klasifikasi Target';
    }



    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $this->redirect($this->getResource()::getUrl('index'));
    }
}
