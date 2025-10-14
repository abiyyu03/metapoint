<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Village extends Model
{
    use SoftDeletes;
    protected $table = 'villages';

    protected $fillable = [
        'name',
        'code',
        'district_id'
    ];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
