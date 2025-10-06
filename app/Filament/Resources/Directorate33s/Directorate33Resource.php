<?php

namespace App\Filament\Resources\Directorate33s;

use App\Filament\Resources\Directorate33s\Pages\CreateDirectorate33;
use App\Filament\Resources\Directorate33s\Pages\EditDirectorate33;
use App\Filament\Resources\Directorate33s\Pages\ListDirectorate33s;
use App\Filament\Resources\Directorate33s\Schemas\Directorate33Form;
use App\Filament\Resources\Directorate33s\Tables\Directorate33sTable;
use App\Models\Directorate33;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class Directorate33Resource extends Resource
{
    protected static ?string $model = Directorate33::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingOffice;

    protected static ?string $recordTitleAttribute = 'Direktorat 33';
    protected static string | UnitEnum | null $navigationGroup = 'Unit Operasional';

    protected static ?string $navigationLabel = 'Direktorat 33';

    public static function form(Schema $schema): Schema
    {
        return Directorate33Form::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return Directorate33sTable::configure($table);
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
            'index' => ListDirectorate33s::route('/'),
            'create' => CreateDirectorate33::route('/create'),
            'edit' => EditDirectorate33::route('/{record}/edit'),
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
