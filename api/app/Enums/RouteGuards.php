<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class RouteGuards extends Enum
{
    const All = "role:".UserRoles::SuperAdministrator."|".UserRoles::Administrator."|".UserRoles::Student;
    const OnlySuperAdministrator = "role:".UserRoles::SuperAdministrator;
    const OnlyAdministrator = "role:".UserRoles::Administrator;
    const OnlyStudent = "role:".UserRoles::Student;
    const SuperAdminOrAdministrator = "role:".UserRoles::SuperAdministrator."|".UserRoles::Administrator;
    const SuperAdminOrStudent = "role:".UserRoles::SuperAdministrator."|".UserRoles::Student;
    const Authenticated = "auth:api";
}
