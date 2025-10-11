<?php

namespace App\Filament\Resources\FundraisingTargets;

use App\Filament\Resources\FundraisingTargets\Pages\CreateFundraisingTarget;
use App\Filament\Resources\FundraisingTargets\Pages\EditFundraisingTarget;
use App\Filament\Resources\FundraisingTargets\Pages\ListFundraisingTargets;
use App\Filament\Resources\FundraisingTargets\Schemas\FundraisingTargetForm;
use App\Filament\Resources\FundraisingTargets\Tables\FundraisingTargetsTable;
use App\Models\FundraisingTarget;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FundraisingTargetResource extends Resource
{
    protected static ?string $model = FundraisingTarget::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CurrencyDollar;

    protected static ?string $recordTitleAttribute = 'Penggalangan Target';
    protected static string | UnitEnum | null $navigationGroup = 'Penggalangan Dana';

    protected static ?string $navigationLabel = 'Target';


    public static function form(Schema $schema): Schema
    {
        return FundraisingTargetForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FundraisingTargetsTable::configure($table);
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
            'index' => ListFundraisingTargets::route('/'),
            'create' => CreateFundraisingTarget::route('/create'),
            'edit' => EditFundraisingTarget::route('/{record}/edit'),
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
