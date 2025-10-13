<?php

namespace App\Filament\Resources\IntelligentMethods;

use App\Filament\Resources\IntelligentMethods\Pages\CreateIntelligentMethod;
use App\Filament\Resources\IntelligentMethods\Pages\EditIntelligentMethod;
use App\Filament\Resources\IntelligentMethods\Pages\ListIntelligentMethods;
use App\Filament\Resources\IntelligentMethods\Schemas\IntelligentMethodForm;
use App\Filament\Resources\IntelligentMethods\Tables\IntelligentMethodsTable;
use App\Models\IntelligentMethod;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IntelligentMethodResource extends Resource
{
    protected static ?string $model = IntelligentMethod::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BookOpen;

    protected static ?string $recordTitleAttribute = 'Metode Intelijen';
    protected static ?string $navigationLabel = 'Metode Intelijen';

    public static function form(Schema $schema): Schema
    {
        return IntelligentMethodForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IntelligentMethodsTable::configure($table);
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
            'index' => ListIntelligentMethods::route('/'),
            'create' => CreateIntelligentMethod::route('/create'),
            'edit' => EditIntelligentMethod::route('/{record}/edit'),
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
