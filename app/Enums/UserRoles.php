<?php

namespace App\Enums;

enum UserRoles: int
{
    case ADMIN_ROLE = 1;
    case RECRUITER_ROLE = 2;
    case APPLICANT_ROLE = 3;

    public function label(): string
    {
        return match ($this) {
            UserRoles::ADMIN_ROLE => 'Admin',
            UserRoles::RECRUITER_ROLE => 'Recruiter',
            UserRoles::APPLICANT_ROLE => 'Applicant',
            default => 'Not found'
        };
    }
}
