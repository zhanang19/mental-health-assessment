export default ({ app, store }, inject) => {
  inject('helpers', {
    /**
     * Displays a snackbar alert.
     * 
     * message: String e.g. 'You have logged in.'
     * type: String [success, info, error]
     * 
     * @param { Object } 
     * @returns { Void }
     */
    notify ({ 
      message = null, 
      type = null,
      transition = null,
      position = {
        top: false,
        bottom: true,
        left: true,
        right: false
      } }) {
      store.dispatch('alerts/execute', { 
        message, 
        type, 
        transition,
        position,
      })
    },

    /**
     * Displays a snackbar alert.
     * 
     * message: String e.g. 'You have logged in.'
     * type: String [success, info, error]
     * 
     * @param { Object } 
     * @returns { Void }
     */
    loader () {
      store.commit('TOGGLE_LOADER', {
        field: 'loading',
      })
    },
    // Add more ...
  })
}