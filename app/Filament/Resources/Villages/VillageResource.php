<?php

namespace App\Filament\Resources\Villages;

use App\Filament\Clusters\Wilayah\WilayahCluster;
use App\Filament\Resources\Villages\Pages\CreateVillage;
use App\Filament\Resources\Villages\Pages\EditVillage;
use App\Filament\Resources\Villages\Pages\ListVillages;
use App\Filament\Resources\Villages\Schemas\VillageForm;
use App\Filament\Resources\Villages\Tables\VillagesTable;
use App\Models\Village;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class VillageResource extends Resource
{
    protected static ?string $model = Village::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::HomeModern;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $cluster = WilayahCluster::class;
    protected static ?string $navigationLabel = 'Kelurahan / Desa';
    protected static ?string $modelLabel = 'Kelurahan / Desa';
    protected static ?string $pluralModelLabel = 'Kelurahan / Desa';
    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return VillageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VillagesTable::configure($table);
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
            'index' => ListVillages::route('/'),
            'create' => CreateVillage::route('/create'),
            'edit' => EditVillage::route('/{record}/edit'),
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
