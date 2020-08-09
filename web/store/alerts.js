import { getField, updateField } from 'vuex-map-fields'

export const state = () => ({
  type: null,
  show: false,
  message: null,
  vertical: false,
  transition: null,
  elevation: '5',
  timeout: 6000,
  color: 'light',
  absolute: false,
  centered: false,
  position: {
    top: false,
    bottom: true,
    left: true,
    right: false,
  },
})

export const getters = {
  getField,
}

export const mutations = {
  executeAlert: (state, payload) => {
    state.show = true
    state.type = payload.type || 'info'
    state.message = payload.message || 'No message.'
    state.transition = payload.transition || 'slide-x-transition'
    state.color = payload.color || 'white'
    state.centered = payload.centered
    state.position = {
      top: payload.position.top,
      bottom: payload.position.bottom,
      left: payload.position.left,
      right: payload.position.right,
    }
  },
  
  updateField,
}

export const actions = {
  /**
   * Triggers the snackbar.
   * 
   * @param { Boolean } show 
   * @param { String } message 
   * @param { String } type # success or error 
   */
  execute({ commit }, payload) {
    commit('executeAlert', payload)
  },
}