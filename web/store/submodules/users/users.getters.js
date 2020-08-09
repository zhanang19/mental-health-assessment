import { getField } from 'vuex-map-fields'

export const getters = {
  activeUsers: state => state.users.filter(item => item.is_active),

  test: state => state,

  getField
}