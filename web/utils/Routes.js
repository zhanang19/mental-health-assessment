export const pages = [
  {
    icon: "mdi-view-dashboard-outline",
    title: "Dashboard",
    route: "dashboard",
    color: "cyan",
    roles: ["super-admin", "admin"]
  },
  {
    icon: "mdi-account-group-outline",
    title: "Users",
    route: "users",
    color: "pink",
    roles: ["super-admin"]
  },
  {
    icon: "mdi-file-table-box-multiple-outline",
    title: "Survey Forms",
    route: "survey-forms",
    color: "yellow darken-3",
    roles: ["super-admin", "admin"]
  },
  {
    icon: "mdi-account-multiple-outline",
    title: "Students",
    route: "students",
    color: "indigo",
    roles: ["super-admin", "admin"]
  },
  {
    icon: "mdi-chart-bar",
    title: "Reports",
    route: "reports",
    color: "blue darken-2",
    roles: ["super-admin", "admin"]
  }
];
