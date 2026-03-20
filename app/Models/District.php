<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';
    protected $primaryKey = 'district_id';
    
    protected $fillable = [
        'district_name',
        'province_id',
    ];

    /**
     * Get the province this district belongs to.
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'province_id');
    }

    /**
     * Get the schools in this district.
     */
    public function schools()
    {
        return $this->hasMany(School::class, 'district_id', 'district_id');
    }

    /**
     * Get the reports from this district.
     */
    public function reports()
    {
        return $this->hasMany(Report::class, 'district_id', 'district_id');
    }
}
