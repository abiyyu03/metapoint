<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FundraisingAgent extends Model
{
    use SoftDeletes;
    protected $table = 'fundraising_agents';

    protected $fillable = [
        'agent_id',
        'type',
        'unit',
        'amount_unit',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }
}
