/**
 * Enums for UserRoles.
 *
 * @var { Object } UserRoles
 */
export const UserRoles = Object.freeze({
  SuperAdministrator: "super-admin",
  Administrator: "admin",
  Student: "student"
});

/**
 * Listing of user roles with corresponding raw value based on Enum.
 *
 * @var { Array } roles
 */
export const roles = [
  {
    name: "Super Administrator",
    value: UserRoles.SuperAdministrator
  },
  {
    name: "Administrator",
    value: UserRoles.Administrator
  },
  {
    name: "Student",
    value: UserRoles.Student
  }
];
