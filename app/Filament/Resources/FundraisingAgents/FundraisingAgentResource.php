<?php

namespace App\Filament\Resources\FundraisingAgents;

use App\Filament\Resources\FundraisingAgents\Pages\CreateFundraisingAgent;
use App\Filament\Resources\FundraisingAgents\Pages\EditFundraisingAgent;
use App\Filament\Resources\FundraisingAgents\Pages\ListFundraisingAgents;
use App\Filament\Resources\FundraisingAgents\Schemas\FundraisingAgentForm;
use App\Filament\Resources\FundraisingAgents\Tables\FundraisingAgentsTable;
use App\Models\FundraisingAgent;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FundraisingAgentResource extends Resource
{
    protected static ?string $model = FundraisingAgent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CurrencyDollar;
    protected static ?string $recordTitleAttribute = 'Penggalangan Agen';

    protected static string | UnitEnum | null $navigationGroup = 'Penggalangan Dana';

    protected static ?string $navigationLabel = 'Agen';

    public static function form(Schema $schema): Schema
    {
        return FundraisingAgentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FundraisingAgentsTable::configure($table);
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
            'index' => ListFundraisingAgents::route('/'),
            'create' => CreateFundraisingAgent::route('/create'),
            'edit' => EditFundraisingAgent::route('/{record}/edit'),
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
