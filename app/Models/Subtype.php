<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subtype extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subtypes';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'abuse_type_id',
        'sub_type_name',
    ];

    /**
     * Get the abuse type that owns the subtype.
     */
    public function abuseType(): BelongsTo
    {
        return $this->belongsTo(AbuseType::class, 'abuse_type_id', 'id');
    }
}