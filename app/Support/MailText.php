<?php

namespace App\Support;

/**
 * Makes reporter-supplied text safe to drop into a *markdown* mail template.
*/
class MailText
{
    /** Characters that carry markdown or autolink meaning. < > & " ' are left to Blade's e(). */
    private const MARKDOWN_CHARS = '/([\\\\`*_{}\[\]()#+\-.!|~:@\/=])/';

    /** One line of untrusted text (newlines collapsed, length capped). */
    public static function line(?string $value, int $max = 300): string
    {
        $value = self::clean((string) $value, $max);
        $value = preg_replace('/\s+/u', ' ', $value) ?? '';

        return self::escape(trim($value));
    }

    /** Several lines of untrusted text; line breaks are kept as markdown hard breaks. */
    public static function block(?string $value, int $max = 2000): string
    {
        $value = self::clean((string) $value, $max);
        $lines = preg_split('/\R/u', $value) ?: [];

        return implode("  \n", array_map(fn ($l) => self::escape(trim($l)), $lines));
    }

    private static function clean(string $value, int $max): string
    {
        // strip control characters (keep \n \r \t), then cap the length
        $value = preg_replace('/[^\P{C}\n\r\t]/u', '', $value) ?? '';

        return mb_substr($value, 0, $max);
    }

    private static function escape(string $value): string
    {
        return preg_replace(self::MARKDOWN_CHARS, '\\\\$1', $value) ?? '';
    }
}
