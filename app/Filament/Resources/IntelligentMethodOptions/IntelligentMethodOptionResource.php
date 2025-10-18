<?php

namespace App\Filament\Resources\IntelligentMethodOptions;

use App\Filament\Resources\IntelligentMethodOptions\Pages\CreateIntelligentMethodOption;
use App\Filament\Resources\IntelligentMethodOptions\Pages\EditIntelligentMethodOption;
use App\Filament\Resources\IntelligentMethodOptions\Pages\ListIntelligentMethodOptions;
use App\Filament\Resources\IntelligentMethodOptions\Schemas\IntelligentMethodOptionForm;
use App\Filament\Resources\IntelligentMethodOptions\Tables\IntelligentMethodOptionsTable;
use App\Models\IntelligentMethodOption;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class IntelligentMethodOptionResource extends Resource
{
    protected static ?string $model = IntelligentMethodOption::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ListBullet;
    protected static ?string $recordTitleAttribute = 'Opsi Metode Intelijen';
    protected static ?string $navigationLabel = 'Opsi Metode Intelijen';
    protected static ?int $navigationSort = 2;
    protected static string|UnitEnum|null $navigationGroup = 'Master Data';
    protected static ?string $slug = '/master/opsi-metode-intelijen';

    protected bool $shouldRedirectToRecord = false;

    public static function form(Schema $schema): Schema
    {
        return IntelligentMethodOptionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IntelligentMethodOptionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIntelligentMethodOptions::route('/'),
            'create' => CreateIntelligentMethodOption::route('/create'),
            'edit' => EditIntelligentMethodOption::route('/{record}/edit'),
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
        return 'Opsi Metode Intelijen';
    }

    public static function getModelLabel(): string
    {
        return 'Opsi Metode Intelijen';
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
