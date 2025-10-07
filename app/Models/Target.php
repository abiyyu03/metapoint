<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Target extends Model
{
    use SoftDeletes;

    protected $table = 'targets';

    protected $fillable = [
        'first_name',
        'last_name',
        'age',
        'gender',
        'organization_id',
        'title_id',
        'address',
        'village_id',
        'district_id',
        'city_id',
        'province_id',
        'country_id',
        'lat',
        'lng',
        'issue_id',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function title()
    {
        return $this->belongsTo(Title::class, 'title_id');
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class, 'issue_id');
    }

    public function agents()
    {
        return $this->belongsToMany(Agent::class, 'agent_target', 'target_id', 'agent_id')
            ->withTimestamps();
    }
}
