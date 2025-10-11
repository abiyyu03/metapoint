<?php

namespace App\Filament\Resources\TargetEvaluationAttitudes;

use App\Filament\Resources\TargetEvaluationAttitudes\Pages\CreateTargetEvaluationAttitude;
use App\Filament\Resources\TargetEvaluationAttitudes\Pages\EditTargetEvaluationAttitude;
use App\Filament\Resources\TargetEvaluationAttitudes\Pages\ListTargetEvaluationAttitudes;
use App\Filament\Resources\TargetEvaluationAttitudes\Schemas\TargetEvaluationAttitudeForm;
use App\Filament\Resources\TargetEvaluationAttitudes\Tables\TargetEvaluationAttitudesTable;
use App\Models\TargetEvaluationAttitude;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class TargetEvaluationAttitudeResource extends Resource
{
    protected static ?string $model = TargetEvaluationAttitude::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Flag;
    protected static ?string $recordTitleAttribute = 'Klasifikasi Target';
    protected static string | UnitEnum | null $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Klasifikasi Target';

    public static function form(Schema $schema): Schema
    {
        return TargetEvaluationAttitudeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TargetEvaluationAttitudesTable::configure($table);
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
            'index' => ListTargetEvaluationAttitudes::route('/'),
            'create' => CreateTargetEvaluationAttitude::route('/create'),
            'edit' => EditTargetEvaluationAttitude::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getPluralLabel(): ?string
    {
        return 'Master Data'; // Untuk title & breadcrumb
    }

    public static function getModelLabel(): string
    {
        return 'Klasifikasi Target'; // Untuk create button 
    }
}
