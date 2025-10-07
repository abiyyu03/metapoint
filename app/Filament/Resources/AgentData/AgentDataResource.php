<?php

namespace App\Filament\Resources\AgentData;

use App\Filament\Resources\AgentData\Pages\CreateAgentData;
use App\Filament\Resources\AgentData\Pages\EditAgentData;
use App\Filament\Resources\AgentData\Pages\ListAgentData;
use App\Filament\Resources\AgentData\Schemas\AgentDataForm;
use App\Filament\Resources\AgentData\Tables\AgentDataTable;
use App\Models\AgentData;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AgentDataResource extends Resource
{
    protected static ?string $model = AgentData::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Identification;

    protected static ?string $recordTitleAttribute = 'data agen';
    protected static ?string $navigationLabel = 'Data Agen';

    public static function form(Schema $schema): Schema
    {
        return AgentDataForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AgentDataTable::configure($table);
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
            'index' => ListAgentData::route('/'),
            'create' => CreateAgentData::route('/create'),
            'edit' => EditAgentData::route('/{record}/edit'),
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
