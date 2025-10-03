<?php

namespace App;

enum StatType: string
{
    case BENEFICIARIES = 'beneficiaries';
    case TOTAL_BENEFICIARIES = 'total_beneficiaries';
    case MALE_BENEFICIARIES = 'male_beneficiaries';
    case FEMALE_BENEFICIARIES = 'female_beneficiaries';
    case PROGRAMS_COMPLETED = 'programs_completed';
    case PROVINCES_REACHED = 'provinces_reached';
    case COOPERATIVES_FORMED = 'cooperatives_formed';
    case PROJECTS = 'projects';
    case STAFF = 'staff';
    case PARTNERS = 'partners';

    public function label(): string
    {
        return match($this) {
            self::BENEFICIARIES => 'Beneficiaries',
            self::TOTAL_BENEFICIARIES => 'Total Beneficiaries',
            self::MALE_BENEFICIARIES => 'Male Beneficiaries',
            self::FEMALE_BENEFICIARIES => 'Female Beneficiaries',
            self::PROGRAMS_COMPLETED => 'Programs Completed',
            self::PROVINCES_REACHED => 'Provinces Reached',
            self::COOPERATIVES_FORMED => 'Cooperatives Formed',
            self::PROJECTS => 'Projects',
            self::STAFF => 'Staff',
            self::PARTNERS => 'Partners',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->label()
        ])->toArray();
    }
}
