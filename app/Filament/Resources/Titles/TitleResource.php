<?php

namespace App\Filament\Resources\Titles;

use App\Filament\Resources\Titles\Pages\CreateTitle;
use App\Filament\Resources\Titles\Pages\EditTitle;
use App\Filament\Resources\Titles\Pages\ListTitles;
use App\Filament\Resources\Titles\Schemas\TitleForm;
use App\Filament\Resources\Titles\Tables\TitlesTable;
use App\Models\Title;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class TitleResource extends Resource
{
    protected static ?string $model = Title::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Briefcase;
    protected static ?string $recordTitleAttribute = 'Posisi/Jabatan';
    protected static string|UnitEnum|null $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Jabatan / Title';
    protected static ?string $modelLabel = 'Jabatan';
    protected static ?string $pluralModelLabel = 'Data Jabatan';


    public static function form(Schema $schema): Schema
    {
        return TitleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TitlesTable::configure($table);
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
            'index' => ListTitles::route('/'),
            'create' => CreateTitle::route('/create'),
            'edit' => EditTitle::route('/{record}/edit'),
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
