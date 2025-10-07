<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Model
{
    use SoftDeletes;
    protected $table = 'agents';

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
        'operational_unit_id'
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

    public function operationalUnit()
    {
        return $this->belongsTo(OperationalUnit::class, 'operational_unit_id');
    }

    public function targets()
    {
        return $this->belongsToMany(Target::class, 'agent_target', 'agent_id', 'target_id')
            ->withTimestamps();
    }

    public function fundraisingAgents()
    {
        return $this->hasMany(FundraisingAgent::class, 'agent_id');
    }
}
