<?php

namespace App\Filament\Resources\OperationalUnits;

use App\Filament\Resources\OperationalUnits\Pages\CreateOperationalUnit;
use App\Filament\Resources\OperationalUnits\Pages\EditOperationalUnit;
use App\Filament\Resources\OperationalUnits\Pages\ListOperationalUnits;
use App\Filament\Resources\OperationalUnits\Schemas\OperationalUnitForm;
use App\Filament\Resources\OperationalUnits\Tables\OperationalUnitsTable;
use App\Models\OperationalUnit;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OperationalUnitResource extends Resource
{
    protected static ?string $model = OperationalUnit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingOffice;

    protected static ?string $recordTitleAttribute = 'Unit Operasional';
    protected static ?string $navigationLabel = 'Unit Operasional';
    protected static ?int $navigationSort = 1;



    public static function form(Schema $schema): Schema
    {
        return OperationalUnitForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OperationalUnitsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOperationalUnits::route('/'),
            'create' => CreateOperationalUnit::route('/create'),
            'edit' => EditOperationalUnit::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
