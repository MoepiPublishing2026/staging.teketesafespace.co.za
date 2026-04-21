// <?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\BelongsTo;

// class Subscription extends Model
// {
//     protected $fillable = [
//         'user_id',
//         'plan',
//         'status',
//         'm_payment_id',
//         'payfast_token',
//         'amount_paid',
//         'starts_at',
//         'expires_at',
//     ];

//     protected $casts = [
//         'starts_at'  => 'datetime',
//         'expires_at' => 'datetime',
//     ];

//     /**
//      * The user who owns this subscription.
//      */
//     public function user(): BelongsTo
//     {
//         return $this->belongsTo(User::class);
//     }

//     /**
//      * Check if the subscription currently active.
//      * Free plan always active. Paid plans not to be expired.
//      */
//     public function isActive(): bool
//     {
//         if ($this->status === 'free') {
//             return true;
//         }

//         if ($this->status === 'active') {
//             return $this->expires_at === null || $this->expires_at->isFuture();
//         }

//         return false;
//     }

//     /**
//      * Check if the subscription has expired.
//      */
//     public function isExpired(): bool
//     {
//         return $this->status === 'expired' ||
//               ($this->expires_at !== null && $this->expires_at->isPast() && $this->status !== 'free');
//     }

//     /**
//      * Get a human-readable plan label.
//      */
//     public function getPlanLabelAttribute(): string
//     {
//         return match ($this->plan) {
//             'starter' => 'Starter (Free)',
//             'monthly' => 'Monthly Plan',
//             'annual'  => 'Annual Plan',
//             default   => ucfirst($this->plan),
//         };
//     }
// }