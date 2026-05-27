<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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


    const PERMANENT_BLOCK_YEAR = 2037;

    public function isPermanentlyBlocked(): bool
    {
        return $this->suspended_until?->year >= self::PERMANENT_BLOCK_YEAR;
    }

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

    /** Status slugs used on national/provincial dashboards and report filters. */
    public static function canonicalDashboardStatuses(): array
    {
        return [
            'awaiting-resolution',
            'forwarded',
            'under-review',
            'closed',
            'unresolved',
            'false-report',
        ];
    }

    /**
     * Map raw DB values (defaults, legacy labels) to a canonical dashboard status
     * so headline counts sum to total reports.
     */
    public static function normalizeStatusForDashboard(?string $raw): string
    {
        $s = strtolower(trim((string) ($raw ?? '')));
        if ($s === '' || $s === 'pending') {
            return 'awaiting-resolution';
        }
        if (in_array($s, ['completed', 'resolved'], true)) {
            return 'closed';
        }
        if (in_array($s, ['in-process', 'in_process'], true)) {
            return 'under-review';
        }
        if ($s === 'escalated') {
            return 'forwarded';
        }
        if ($s === 'false') {
            return 'false-report';
        }
        if (in_array($s, self::canonicalDashboardStatuses(), true)) {
            return $s;
        }

        return 'awaiting-resolution';
    }

    /**
     * SQL expression (MySQL) that mirrors {@see normalizeStatusForDashboard} for filtering.
     */
    public static function normalizedDashboardStatusSqlExpression(): string
    {
        return <<<'SQL'
CASE
  WHEN `status` IS NULL OR TRIM(COALESCE(`status`, '')) = '' OR LOWER(TRIM(`status`)) = 'pending' THEN 'awaiting-resolution'
  WHEN LOWER(TRIM(`status`)) IN ('completed', 'resolved') THEN 'closed'
  WHEN LOWER(TRIM(`status`)) IN ('in-process', 'in_process') THEN 'under-review'
  WHEN LOWER(TRIM(`status`)) = 'escalated' THEN 'forwarded'
  WHEN LOWER(TRIM(`status`)) = 'false' THEN 'false-report'
  WHEN LOWER(TRIM(`status`)) IN ('awaiting-resolution', 'forwarded', 'under-review', 'closed', 'unresolved', 'false-report') THEN LOWER(TRIM(`status`))
  ELSE 'awaiting-resolution'
END
SQL;
    }

    /**
     * Restrict query to rows that belong to a canonical status bucket (aliases included).
     */
    public static function scopeWhereCanonicalDashboardStatus(Builder $query, string $canonical): Builder
    {
        if (! in_array($canonical, self::canonicalDashboardStatuses(), true)) {
            return $query->where('status', $canonical);
        }

        $expr = self::normalizedDashboardStatusSqlExpression();

        return $query->whereRaw('('.$expr.') = ?', [$canonical]);
    }
}