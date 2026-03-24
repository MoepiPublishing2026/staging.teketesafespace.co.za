<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'abuse_type_id',
        'subtype_id',
        'school_id',
        'province_id',
        'district_id',
        'description',
        'image_path',
        'is_anonymous',
        'case_number',
        'reporter_email',
        'phone_number',
        'full_name',
        'age',
        'location',
        'school_name',
        'grade',
        'status',
        'latest_status_reason',
         'reporter_clarification',
        'suspended_until',
    ];



protected $casts = [
    'suspended_until' => 'datetime',
    'updated_at' => 'datetime',
];
    /**
     * Get the abuse type associated with the report.
     */
    public function abuseType(): BelongsTo
    {
        return $this->belongsTo(AbuseType::class);
    }

    /**
     * Get the subtype associated with the report.
     */
    public function subtype(): BelongsTo
    {
        return $this->belongsTo(Subtype::class);
    }

    /**
     * Get the user who submitted the report.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the school associated with the report.
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, 'school_id', 'school_id');
    }

    /**
     * Get the province associated with the report.
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id', 'province_id');
    }

    /**
     * Get the district associated with the report.
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id', 'district_id');
    }
}