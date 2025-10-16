<?php

namespace App\Filament\Resources\FundraisingTargets\Schemas;

use App\Models\IntelligentMethod;
use App\Models\IntelligentMethodOption;
use App\Models\Target;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FundraisingTargetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('target_id')
                    ->options(Target::query()->pluck('fullname', 'id'))
                    ->searchable()
                    ->label('Nama Target')
                    ->required(),
                TextInput::make('type')
                    ->label('Tipe')
                    ->required(),
                TextInput::make('unit')
                    ->label('Tipe Satuan')
                    ->required(),
                TextInput::make('amount_unit')
                    ->label('Jumlah Unit')
                    ->numeric()
                    ->required(),
                Select::make('method_id')
                    ->label('Metode Intelijen')
                    ->options(IntelligentMethod::query()->pluck('name', 'id'))
                    ->searchable()
                    ->live()
                    ->required(),
                Select::make('method_option_id')
                    ->label('Opsi Metode Intelijen')
                    ->searchable()
                    ->options(function (callable $get) {
                        $methodId = $get('method_id');

                        $methods = new IntelligentMethodOption;

                        if ($methodId && $methods != null) {
                            $methods->where('intelligent_method_id', $methodId);
                        }

                        if ($methodId == 3) {
                            $option = IntelligentMethodOption::firstOrCreate([
                                'name' => 'Opsi Lainnya',
                                'intelligent_method_id' => $methodId,
                            ]);

                            return [$option->id => $option->name];
                        }

                        return $methods->pluck('name', 'id');
                    })
                    ->required(),
            ]);
    }
}
