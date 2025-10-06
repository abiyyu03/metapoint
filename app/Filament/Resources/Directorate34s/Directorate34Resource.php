<?php

namespace App\Filament\Resources\Directorate34s;

use App\Filament\Resources\Directorate34s\Pages\CreateDirectorate34;
use App\Filament\Resources\Directorate34s\Pages\EditDirectorate34;
use App\Filament\Resources\Directorate34s\Pages\ListDirectorate34s;
use App\Filament\Resources\Directorate34s\Schemas\Directorate34Form;
use App\Filament\Resources\Directorate34s\Tables\Directorate34sTable;
use App\Models\Directorate34;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class Directorate34Resource extends Resource
{
    protected static ?string $model = Directorate34::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingOffice;

    protected static ?string $recordTitleAttribute = 'direktorat 34';

    protected static string | UnitEnum | null $navigationGroup = 'Unit Operasional';

    protected static ?string $navigationLabel = 'Direktorat 34';

    public static function form(Schema $schema): Schema
    {
        return Directorate34Form::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return Directorate34sTable::configure($table);
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
            'index' => ListDirectorate34s::route('/'),
            'create' => CreateDirectorate34::route('/create'),
            'edit' => EditDirectorate34::route('/{record}/edit'),
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
