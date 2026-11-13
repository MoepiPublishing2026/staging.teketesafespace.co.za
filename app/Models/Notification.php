<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'report_id',
        'notification_type',
        'message',
        'phone_number',
    ];

    /**
     * Get the report that the notification belongs to.
     *
     * The method name is kept as `incident()` for compatibility with the legacy
     * schema naming, but the active application uses the `reports` table and the
     * `Report` model.
     */
    public function incident()
    {
        return $this->belongsTo(Report::class, 'report_id');
    }
}
