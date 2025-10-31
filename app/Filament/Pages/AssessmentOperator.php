<?php

namespace App\Filament\Pages;

use App\Models\Agent;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use UnitEnum;
use Filament\Schemas\Components\Wizard as ComponentsWizard;
use Filament\Schemas\Components\Wizard\Step as WizardStep;
use App\Models\Assessment\Assessment;
use App\Models\Target;
use Filament\Forms\Components\Select;

class AssessmentOperator extends Page
{
    use InteractsWithForms;
    protected string $view = 'filament.pages.assessment-operator';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocument;
    protected static string|UnitEnum|null $navigationGroup = 'Assessment';

    protected function getFormSchema(): array
    {
        $assessments = Assessment::with('assessmentSections.questions.answers')
            ->orderBy('id')
            ->get();

        $steps = [];

        foreach ($assessments as $assesment) {
            $sections = [];

            foreach ($assesment->assessmentSections->sortBy('order') as $section) {
                $fields = [];

                foreach ($section->questions as $question) {
                    if ($question->type === 'choice') {
                        $options = $question->answers
                            ->sortBy('order')
                            ->pluck('label', 'id')
                            ->toArray();

                        $fields[] = Radio::make("question_{$question->id}")
                            ->label($question->value)
                            ->options($options)
                            ->required()
                            ->columns(2);
                    } else {
                        $fields[] = Textarea::make("question_{$question->id}")
                            ->label($question->value)
                            ->rows(3)
                            ->required(false);
                    }
                }

                $sections[] = Section::make($section->name)
                    ->collapsible()
                    ->collapsed()
                    ->schema($fields);
            }

            $steps[] = WizardStep::make($assesment->name)
                ->description($assesment->description)
                ->schema($sections);
        }

        return [
            ComponentsWizard::make(array_merge(
                [
                    WizardStep::make('Pilih Target dan Agen')
                        ->description('Target yang dinilai dan agennya.')
                        ->schema([
                            Select::make('target_id')
                                ->label('Pilih Target')
                                ->options(Target::pluck('fullname', 'id'))
                                ->searchable()
                                ->required(),
                            Select::make('agent_id')
                                ->label('Pilih Agen')
                                ->options(Agent::pluck('fullname', 'id'))
                                ->searchable()
                                ->required(),
                        ])
                ],
                $steps
            ))
                ->submitAction(
                    Action::make('submit')
                        ->label('Kirim Assessment')
                        ->submit('form')
                ),
        ];
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        // // Simpan ke DB (contoh)
        // foreach ($data as $key => $value) {
        //     if (str_starts_with($key, 'question_')) {
        //         $questionId = str_replace('question_', '', $key);

        //         Answer::create([
        //             'question_id' => $questionId,
        //             'value' => $value,
        //         ]);
        //     }
        // }

        // Notification::make()
        //     ->title('Asesmen berhasil dikirim!')
        //     ->success()
        //     ->send();
    }
}
