<?php

namespace App\Filament\Resources\Assessment\Assessments;

use App\Filament\Clusters\Assesment\AssesmentCluster;
use App\Filament\Resources\Assessment\Assessments\Pages\CreateAssessment;
use App\Filament\Resources\Assessment\Assessments\Pages\EditAssessment;
use App\Filament\Resources\Assessment\Assessments\Pages\ListAssessments;
use App\Filament\Resources\Assessment\Assessments\Schemas\AssessmentForm;
use App\Filament\Resources\Assessment\Assessments\Tables\AssessmentsTable;
use App\Models\Assessment\Assessment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class AssessmentResource extends Resource
{
    protected static ?string $model = Assessment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::FolderOpen;
    protected static ?string $recordTitleAttribute = 'Asesment';
    protected static ?string $navigationLabel = 'Judul Asesmen';
    protected static ?int $navigationSort = 1;
    protected static ?string $cluster = AssesmentCluster::class;

    public static function form(Schema $schema): Schema
    {
        return AssessmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssessmentsTable::configure($table);
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
            'index' => ListAssessments::route('/'),
            'create' => CreateAssessment::route('/create'),
            'edit' => EditAssessment::route('/{record}/edit'),
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