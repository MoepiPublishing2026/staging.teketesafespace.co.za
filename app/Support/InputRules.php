<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * One place for the length limits and allow-lists applied to user input
 * Used by the report form, the edit form, the status lookup and the admin list filters.
 */
class InputRules
{
    /** Every grade the platform recognises. Anything else is rejected. */
    public const GRADES = [
        'Creche', 'Grade R',
        'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6',
        'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12',
    ];

    public const STATUSES = ['awaiting-resolution', 'under-review', 'forwarded', 'closed', 'unresolved', 'false-report'];

    /** Case numbers look like WP001211, BU-20260101-AB12: letters, digits and hyphens only. */
    public const CASE_NUMBER_REGEX = '/^[A-Za-z0-9-]{3,40}$/D';   // D: no trailing-newline match

    /** Conservative email shape: no quotes, spaces, brackets or other characters with meaning in HTML/JS. */
    public const SAFE_EMAIL_REGEX = '/^[A-Za-z0-9._%+\-]{1,64}@[A-Za-z0-9](?:[A-Za-z0-9\-]*[A-Za-z0-9])?(?:\.[A-Za-z0-9](?:[A-Za-z0-9\-]*[A-Za-z0-9])?)+$/D';

    public static function grade(): array
    {
        return ['required', 'string', 'max:20', Rule::in(self::GRADES)];
    }

    public static function age(bool $required = true): array
    {
        return [$required ? 'required' : 'nullable', 'integer', 'min:0', 'max:115'];
    }

    public static function caseNumber(): array
    {
        return ['required', 'string', 'max:40', 'regex:' . self::CASE_NUMBER_REGEX];
    }

    /** For the optional contact email on the edit form (the report form has its own, stricter, rule). */
    public static function safeEmail(bool $required = false): array
    {
        return [$required ? 'required' : 'nullable', 'string', 'email:rfc,dns', 'max:50', 'regex:' . self::SAFE_EMAIL_REGEX];
    }

    public static function fullName(bool $anonymous): array|string
    {
        return $anonymous ? ['nullable', 'string', 'max:50'] : ['required', 'string', 'max:50', "regex:/^[a-zA-Z\\s\\-']{2,50}$/"];
    }

    /**
     * Admin list filters arrive as query-string values and are bound as parameters (so not SQL
     * injection), but they were unbounded and unchecked. Drop anything that does not fit the
     * expected shape, so a crafted value never reaches a query, a redirect or the page.
     * Invalid values are removed rather than rejected so a stale bookmark still loads the list.
     */
    public static function sanitizeReportFilters(Request $request): void
    {
        $text = fn (int $max) => ['nullable', 'string', 'max:' . $max];

        $validator = validator($request->query(), [
            'search'        => $text(100),
            'case_number'   => ['nullable', 'string', 'max:40', 'regex:/^[A-Za-z0-9-]*$/'],
            'full_name'     => $text(100),
            'status'        => ['nullable', 'string', Rule::in(array_merge(self::STATUSES, ['pending', 'in-process', 'resolved', 'escalated', 'completed']))],
            'filter_status' => ['nullable', 'string', Rule::in(array_merge(self::STATUSES, ['pending', 'in-process', 'resolved', 'escalated', 'completed']))],
            'grade'         => ['nullable', 'string', 'max:100'],   // dropdown is built from existing data, so length-limit only
            'abuse_type'    => ['nullable', 'string', 'max:60'],
            'abuse_type_id' => ['nullable', 'integer', 'min:1'],
            'type_id'       => ['nullable', 'integer', 'min:1'],
            'report_type'   => ['nullable', 'string', 'max:60'],
            'subtype_id'    => ['nullable', 'integer', 'min:1'],
            'is_anonymous'  => ['nullable', Rule::in(['0', '1', 0, 1])],
            'age_range'     => ['nullable', 'string', 'max:10', 'regex:/^[0-9+\-]*$/'],
            'date_from'     => ['nullable', 'date_format:Y-m-d'],
            'date_to'       => ['nullable', 'date_format:Y-m-d'],
            'from_date'     => ['nullable', 'date_format:Y-m-d'],
            'to_date'       => ['nullable', 'date_format:Y-m-d'],
            'province_id'   => ['nullable', 'integer', 'min:1'],
            'district_id'   => ['nullable', 'integer', 'min:1'],
            'school_id'     => ['nullable', 'integer', 'min:1'],
            'page'          => ['nullable', 'integer', 'min:1', 'max:100000'],
        ]);

        foreach (array_keys($validator->errors()->messages()) as $key) {
            $request->query->remove($key);
            $request->request->remove($key);
        }
    }
}
