<?php

namespace Database\Seeders\Demo;

class DemoContext
{
    public const PASSWORD = '123456';

    public const BOYS_BRANCH_NAME = 'Boys Branch';

    public const GIRLS_BRANCH_NAME = 'Girls Branch';

    public static int $boysBranchId = 1;

    public static int $girlsBranchId = 2;

    /** @var array<int, string> branch id => slug (boys|girls) */
    public static array $branchSlugs = [];

    public static function branches(): array
    {
        return [
            self::$boysBranchId  => self::BOYS_BRANCH_NAME,
            self::$girlsBranchId => self::GIRLS_BRANCH_NAME,
        ];
    }

    public static function slugForBranch(int $branchId): string
    {
        return self::$branchSlugs[$branchId] ?? 'branch' . $branchId;
    }
}
