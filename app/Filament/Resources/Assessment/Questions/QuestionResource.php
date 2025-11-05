<?php

namespace App\Filament\Resources\Assessment\Questions;

use App\Filament\Clusters\Assesment\AssesmentCluster;
use App\Filament\Resources\Assessment\Questions\Pages\CreateQuestion;
use App\Filament\Resources\Assessment\Questions\Pages\EditQuestion;
use App\Filament\Resources\Assessment\Questions\Pages\ListQuestions;
use App\Filament\Resources\Assessment\Questions\Schemas\QuestionForm;
use App\Filament\Resources\Assessment\Questions\Tables\QuestionsTable;
use App\Models\Assessment\Question;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::QuestionMarkCircle;
    protected static ?string $recordTitleAttribute = 'Pertanyaan';
    protected static ?string $navigationLabel = 'Pertanyaan Asesmen';
    protected static ?int $navigationSort = 3;
    protected static ?string $cluster = AssesmentCluster::class;

    public static function form(Schema $schema): Schema
    {
        return QuestionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QuestionsTable::configure($table);
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
            'index' => ListQuestions::route('/'),
            'create' => CreateQuestion::route('/create'),
            'edit' => EditQuestion::route('/{record}/edit'),
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
