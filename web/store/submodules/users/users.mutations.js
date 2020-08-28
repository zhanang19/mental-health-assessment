import { updateField } from "vuex-map-fields";
import { User } from "~/models/User";

export const mutations = {
  SET_STATE: (state, payload) => (state[payload.field] = payload.data),

  RESET_FORM: state => (state.form = new User()),

  updateField
};
