import { updateField } from 'vuex-map-fields'

export const mutations = {
  SET_STATE: (state, payload) =>
    state[payload.field] = payload.data,

  updateField
}