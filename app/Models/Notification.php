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
     * Get the incident that the notification belongs to.
     */
    public function incident()
    {
        return $this->belongsTo(Incident::class, 'report_id');
    }
}
