<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentTarget extends Model
{
    protected $table = 'agent_target';

    protected $fillable = [
        'agent_id',
        'target_id',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    public function target()
    {
        return $this->belongsTo(Target::class, 'target_id');
    }
}
