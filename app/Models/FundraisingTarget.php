<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FundraisingTarget extends Model
{
    use SoftDeletes;
    protected $table = 'fundraising_targets';

    protected $fillable = [
        'type',
        'unit',
        'amount_unit',
        'method_id',
        'method_option_id',
    ];

    public function method()
    {
        return $this->belongsTo(IntelligentMethod::class, 'method_id');
    }

    public function methodOption()
    {
        return $this->belongsTo(IntelligentMethodOption::class, 'method_option_id');
    }
}
