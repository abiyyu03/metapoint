<?php

namespace App\Filament\Resources\Assessment\AssessmentSections;

use App\Filament\Resources\Assessment\AssessmentSections\Pages\CreateAssessmentSection;
use App\Filament\Resources\Assessment\AssessmentSections\Pages\EditAssessmentSection;
use App\Filament\Resources\Assessment\AssessmentSections\Pages\ListAssessmentSections;
use App\Filament\Resources\Assessment\AssessmentSections\Schemas\AssessmentSectionForm;
use App\Filament\Resources\Assessment\AssessmentSections\Tables\AssessmentSectionsTable;
use App\Models\Assessment\AssessmentSection;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class AssessmentSectionResource extends Resource
{
    protected static ?string $model = AssessmentSection::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Sub Asesment';
    protected static string|UnitEnum|null $navigationGroup = 'Asesment Master Data';

    public static function form(Schema $schema): Schema
    {
        return AssessmentSectionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssessmentSectionsTable::configure($table);
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
            'index' => ListAssessmentSections::route('/'),
            'create' => CreateAssessmentSection::route('/create'),
            'edit' => EditAssessmentSection::route('/{record}/edit'),
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
