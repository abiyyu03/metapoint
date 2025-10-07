<?php

namespace App\Filament\Resources\Directorate35s;

use App\Filament\Resources\Directorate35s\Pages\CreateDirectorate35;
use App\Filament\Resources\Directorate35s\Pages\EditDirectorate35;
use App\Filament\Resources\Directorate35s\Pages\ListDirectorate35s;
use App\Filament\Resources\Directorate35s\Schemas\Directorate35Form;
use App\Filament\Resources\Directorate35s\Tables\Directorate35sTable;
use App\Models\Directorate35;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class Directorate35Resource extends Resource
{
    protected static ?string $model = Directorate35::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingOffice;

    protected static ?string $recordTitleAttribute = 'direktorat 35';

    protected static string | UnitEnum | null $navigationGroup = 'Unit Operasional';

    protected static ?string $navigationLabel = 'Direktorat 35';

    public static function form(Schema $schema): Schema
    {
        return Directorate35Form::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return Directorate35sTable::configure($table);
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
            'index' => ListDirectorate35s::route('/'),
            'create' => CreateDirectorate35::route('/create'),
            'edit' => EditDirectorate35::route('/{record}/edit'),
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
