<?php

namespace App\Filament\Resources\FundraisingAgents\Schemas;

use App\Models\Agent;
use App\Models\FundraisingAgent;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FundraisingAgentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('agent_id')
                    ->label('Fullname')
                    ->options(Agent::query()->pluck('fullname', 'id'))
                    ->searchable()
                    ->required(),
                TextInput::make('type')
                    ->label('Jenis Penggalangan Dana')
                    ->placeholder('Misal: Kendaraan, Barang, Rupiah, dll')
                    ->required(),
                TextInput::make('unit')
                    ->label('Satuan Penggalangan Dana')
                    ->placeholder('Misal: Unit, Pack, Pcs, Orang')
                    ->required(),
                TextInput::make('amount_unit')
                    ->label('Jumlah Satuan')
                    ->required(),
            ]);
    }
}
