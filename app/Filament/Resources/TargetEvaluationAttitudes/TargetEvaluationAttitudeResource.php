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

    // 🔹 Navigasi di sidebar
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Flag;
    protected static ?string $navigationLabel = 'Klasifikasi Target';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $slug = 'master/klasifikasi-target';
    protected static ?int $navigationSort = 3;
    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    // 🔹 Form
    public static function form(Schema $schema): Schema
    {
        return TargetEvaluationAttitudeForm::configure($schema);
    }

    // 🔹 Table
    public static function table(Table $table): Table
    {
        return TargetEvaluationAttitudesTable::configure($table);
    }

    // 🔹 Relasi
    public static function getRelations(): array
    {
        return [];
    }

    // 🔹 Halaman
    public static function getPages(): array
    {
        return [
            'index'  => ListTargetEvaluationAttitudes::route('/'),
            'create' => CreateTargetEvaluationAttitude::route('/create'),
            'edit'   => EditTargetEvaluationAttitude::route('/{record}/edit'),
        ];
    }

    // 🔹 Hapus global scope soft delete
    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }

    // 🔹 Label di UI Filament
    public static function getPluralLabel(): ?string
    {
        return 'Klasifikasi Target';
    }

    public static function getModelLabel(): string
    {
        return 'Klasifikasi Target';
    }

    // 🔹 Badge di sidebar
    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'info';
    }
}
