<?php

namespace App\Filament\Resources\Directorate32s;

use App\Filament\Resources\Directorate32s\Pages\CreateDirectorate32;
use App\Filament\Resources\Directorate32s\Pages\EditDirectorate32;
use App\Filament\Resources\Directorate32s\Pages\ListDirectorate32s;
use App\Filament\Resources\Directorate32s\Schemas\Directorate32Form;
use App\Filament\Resources\Directorate32s\Tables\Directorate32sTable;
use App\Models\Directorate32;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class Directorate32Resource extends Resource
{
    protected static ?string $model = Directorate32::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingOffice;

    protected static ?string $recordTitleAttribute = 'Direktorat 32';

    protected static string | UnitEnum | null $navigationGroup = 'Unit Operasional';
    protected static ?string $navigationLabel = 'Direktorat 32';


    public static function form(Schema $schema): Schema
    {
        return Directorate32Form::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return Directorate32sTable::configure($table);
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
            'index' => ListDirectorate32s::route('/'),
            'create' => CreateDirectorate32::route('/create'),
            'edit' => EditDirectorate32::route('/{record}/edit'),
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
