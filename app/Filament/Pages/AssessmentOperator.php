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

    public ?int $target_id = null;
    public ?int $agent_id = null;
    public array $answers = [];


    public function mount(): void
    {
        $this->form->fill();
    }

    public function rules(): array
    {
        $rules = [];

        foreach ($this->questions as $q) {
            $rules["answers.{$q->id}"] = 'required|exists:answers,id';
        }

        return $rules;
    }


    protected function getFormSchema(): array
    {
        // Ambil semua assessment dengan relasi lengkap dan urutan sesuai kebutuhan
        $assessments = Assessment::with([
            'assessmentSections.questions.answers' => fn($q) => $q->orderBy('order')
        ])->orderBy('id')->get();

        // Buat langkah-langkah wizard berdasarkan data assessment
        $steps = $assessments->map(function ($assessment) {
            $sections = $assessment->assessmentSections
                ->sortBy('order')
                ->map(function ($section) {
                    $fields = $section->questions->map(function ($question) {
                        if ($question->type === 'choice') {
                            $options = $question->answers
                                ->sortBy('order')
                                ->pluck('label', 'id')
                                ->mapWithKeys(fn($label, $id) => [(string) $id => $label])
                                ->toArray();

                            return Radio::make("answers.{$question->id}")
                                ->label($question->value)
                                ->options($options)
                                ->required()
                                ->columns(2);
                        }

                        return Textarea::make("answers.{$question->id}")
                            ->label($question->value)
                            ->rows(3)
                            ->nullable();
                    })->toArray();


                    return Section::make($section->name)
                        ->collapsible()
                        ->collapsed()
                        ->schema($fields);
                })->toArray();

            return WizardStep::make($assessment->name)
                ->description($assessment->description)
                ->schema($sections);
        })->toArray();

        $targetOptions = Target::pluck('fullname', 'id')
            ->mapWithKeys(fn($name, $id) => [(string) $id => $name])
            ->toArray();

        $agentOptions = Agent::pluck('fullname', 'id')
            ->mapWithKeys(fn($name, $id) => [(string) $id => $name])
            ->toArray();

        return [
            ComponentsWizard::make(array_merge(
                [
                    WizardStep::make('Pilih Target dan Agen')
                        ->description('Target yang dinilai dan agennya.')
                        ->schema([
                            Select::make('target_id')
                                ->label('Pilih Target')
                                ->options($targetOptions)
                                ->searchable()
                                ->placeholder('Pilih salah satu target')
                                ->helperText('Pastikan memilih data yang benar')
                                ->rules(['required', 'exists:targets,id'])
                                ->reactive(),

                            Select::make('agent_id')
                                ->label('Pilih Agen')
                                ->options($agentOptions)
                                ->searchable()
                                ->placeholder('Pilih salah satu agen')
                                ->helperText('Pastikan memilih data yang benar')
                                ->rules(['required', 'exists:agents,id'])
                                ->reactive(),
                        ])
                ],
                $steps
            ))
                ->submitAction(
                    Action::make('submit')
                        ->label('Kirim Assessment')
                        // ->action(function (array $data) {
                        //     dd($data); // Lihat apakah data muncul di sini
                        // })
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
