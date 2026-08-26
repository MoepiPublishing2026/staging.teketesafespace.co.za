<?php

namespace App\Support;

class GradeAge
{
    /**
     * Overlapping age ranges used when filing a report.
     *
     * @return array<string, array{0: int, 1: int}>
     */
    public static function ranges(): array
    {
        return [
            'Creche' => [0, 5],
            'Grade R' => [4, 7],
            'Grade 1' => [5, 9],
            'Grade 2' => [6, 10],
            'Grade 3' => [7, 11],
            'Grade 4' => [8, 12],
            'Grade 5' => [9, 13],
            'Grade 6' => [10, 14],
            'Grade 7' => [11, 15],
            'Grade 8' => [12, 16],
            'Grade 9' => [13, 17],
            'Grade 10' => [14, 18],
            'Grade 11' => [15, 19],
            'Grade 12' => [16, 22],
        ];
    }

    /**
     * Grades offered by each school phase.
     *
     * @return array<string, list<string>>
     */
    public static function phaseGrades(): array
    {
        return [
            'PRIMARY SCHOOL' => ['Grade R', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7'],
            'SECONDARY SCHOOL' => ['Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'],
            'COMBINED SCHOOL' => ['Creche', 'Grade R', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'],
            'INTERMEDIATE SCHOOL' => ['Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9'],
            'ECD' => ['Creche', 'Grade R'],
        ];
    }

    /**
     * Grades valid for an age, limited by school phase when known.
     * Pass a blank age to get every grade for that phase.
     *
     * @return list<string>
     */
    public static function applicableGrades(null|int|string $age, ?string $phase = null): array
    {
        $phaseKey = $phase !== null && $phase !== '' ? strtoupper(trim($phase)) : null;
        $phaseList = ($phaseKey && isset(self::phaseGrades()[$phaseKey]))
            ? self::phaseGrades()[$phaseKey]
            : null;
        $hasAge = $age !== null && $age !== '';
        $ageInt = $hasAge ? (int) $age : null;

        $grades = [];
        foreach (self::ranges() as $grade => [$min, $max]) {
            if ($hasAge && ($ageInt < $min || $ageInt > $max)) {
                continue;
            }

            if ($phaseList !== null && ! in_array($grade, $phaseList, true)) {
                continue;
            }

            $grades[] = $grade;
        }

        return $grades;
    }

    /**
     * Ages that can occur for a school phase (union of that phase's grade ranges).
     *
     * @return list<int>
     */
    public static function applicableAges(?string $phase = null): array
    {
        $grades = self::applicableGrades(null, $phase);
        if ($grades === []) {
            return range(0, 22);
        }

        $min = null;
        $max = null;
        $ranges = self::ranges();
        foreach ($grades as $grade) {
            if (! isset($ranges[$grade])) {
                continue;
            }
            [$gMin, $gMax] = $ranges[$grade];
            $min = $min === null ? $gMin : min($min, $gMin);
            $max = $max === null ? $gMax : max($max, $gMax);
        }

        return range((int) $min, (int) $max);
    }
}
