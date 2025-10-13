<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntelligentMethodOption extends Model
{
    use SoftDeletes;

    protected $table = 'intelligent_method_options';

    protected $fillable = [
        'name',
        'intelligent_method_id',
    ];

    public function method()
    {
        return $this->belongsTo(IntelligentMethod::class, 'intelligent_method_id');
    }

    public function fundraisingTargets()
    {
        return $this->hasMany(FundraisingTarget::class, 'method_option_id');
    }
}
