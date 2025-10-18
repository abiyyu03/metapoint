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
use UnitEnum;

class IntelligentMethodResource extends Resource
{
    protected static ?string $model = IntelligentMethod::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BookOpen;

    protected bool $shouldRedirectToRecord = false;

    protected static ?string $recordTitleAttribute = 'Metode Intelijen';
    protected static ?string $navigationLabel = 'Metode Intelijen';
    protected static ?string $title = 'Metode Intelijen';
    protected static ?string $slug = 'metode-intelijen';
    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

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
        return [];
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
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }

    public static function getModelLabel(): string
    {
        return 'Metode Intelijen';
    }
    public static function getPluralLabel(): ?string
    {
        return 'Metode Intelijen';
    }



    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $this->redirect($this->getResource()::getUrl('index'));
    }
}
