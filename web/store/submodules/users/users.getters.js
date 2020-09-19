import { getField } from "vuex-map-fields";
import { UserRoles } from "~/utils/UserRoles";

export const getters = {
  activeUsers: state => state.users.filter(item => item.is_active),

  students: state =>
    state.users.filter(item => item.role === UserRoles.Student),

  getField
};
