<?php

namespace App\Filament\Resources\TargetData;

use App\Filament\Resources\TargetData\Pages\CreateTargetData;
use App\Filament\Resources\TargetData\Pages\EditTargetData;
use App\Filament\Resources\TargetData\Pages\ListTargetData;
use App\Filament\Resources\TargetData\Schemas\TargetDataForm;
use App\Filament\Resources\TargetData\Tables\TargetDataTable;
use App\Models\TargetData;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TargetDataResource extends Resource
{
    protected static ?string $model = TargetData::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChartPie;

    protected static ?string $recordTitleAttribute = 'Data Target';

    protected static ?string $navigationLabel = 'Data Target';

    public static function form(Schema $schema): Schema
    {
        return TargetDataForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TargetDataTable::configure($table);
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
            'index' => ListTargetData::route('/'),
            'create' => CreateTargetData::route('/create'),
            'edit' => EditTargetData::route('/{record}/edit'),
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
