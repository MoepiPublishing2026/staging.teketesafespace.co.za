<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces';
    protected $primaryKey = 'province_id';
    
    protected $fillable = [
        'province_name',
    ];

    /**
     * Get the districts in this province.
     */
    public function districts()
    {
        return $this->hasMany(District::class, 'province_id', 'province_id');
    }

    /**
     * Get the schools in this province.
     */
    public function schools()
    {
        return $this->hasMany(School::class, 'province_id', 'province_id');
    }

    /**
     * Get the reports from this province.
     */
    public function reports()
    {
        return $this->hasMany(Report::class, 'province_id', 'province_id');
    }
}
