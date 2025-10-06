<?php

namespace App\Filament\Resources\SpecialTeams;

use App\Filament\Resources\SpecialTeams\Pages\CreateSpecialTeam;
use App\Filament\Resources\SpecialTeams\Pages\EditSpecialTeam;
use App\Filament\Resources\SpecialTeams\Pages\ListSpecialTeams;
use App\Filament\Resources\SpecialTeams\Schemas\SpecialTeamForm;
use App\Filament\Resources\SpecialTeams\Tables\SpecialTeamsTable;
use App\Models\SpecialTeam;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SpecialTeamResource extends Resource
{
    protected static ?string $model = SpecialTeam::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;

    protected static ?string $recordTitleAttribute = 'Tim Khusus';

    protected static string | UnitEnum | null $navigationGroup = 'Unit Operasional';

    protected static ?string $navigationLabel = 'Tim Khusus/SATGAS';

    public static function form(Schema $schema): Schema
    {
        return SpecialTeamForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SpecialTeamsTable::configure($table);
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
            'index' => ListSpecialTeams::route('/'),
            'create' => CreateSpecialTeam::route('/create'),
            'edit' => EditSpecialTeam::route('/{record}/edit'),
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
