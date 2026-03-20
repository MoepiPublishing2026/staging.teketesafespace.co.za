<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $table = 'schools';
    protected $primaryKey = 'school_id';
    
    protected $fillable = [
        'emis_no',
        'province',
        'school_name',
        'phase_ped',
        'district',
        'district_id',
        'province_id',
        'towncity',
        'address',
        'telephone',
    ];

    /**
     * Get the province associated with the school.
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'province_id');
    }

    /**
     * Get the district associated with the school.
     */
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'district_id');
    }

    /**
     * Get the reports associated with the school.
     */
    public function reports()
    {
        return $this->hasMany(Report::class, 'school_id', 'school_id');
    }
}

