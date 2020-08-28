export const pages = [
  {
    icon: "mdi-view-dashboard-outline",
    title: "Dashboard",
    route: "app-dashboard",
    color: "cyan",
    roles: ["super-admin", "admin"]
  },
  {
    icon: "mdi-account-group-outline",
    title: "Users",
    route: "app-users",
    color: "pink",
    roles: ["super-admin"]
  },
  {
    icon: "mdi-file-table-box-multiple-outline",
    title: "Surveys",
    route: "app-surveys",
    color: "blue darken-4",
    roles: ["super-admin", "admin"]
  },
  // {
  //   icon: "mdi-account-multiple-outline",
  //   title: "Students",
  //   route: "app-students",
  //   color: "indigo",
  //   roles: ["super-admin", "admin"]
  // },
  // {
  //   icon: "mdi-chart-bar",
  //   title: "Reports",
  //   route: "app-reports",
  //   color: "teal darken-2",
  //   roles: ["super-admin", "admin"]
  // }
];
