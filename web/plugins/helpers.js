export default ({ app, store }, inject) => {
  inject("helpers", {
    /**
     * Displays a snackbar alert.
     *
     * message: String e.g. 'You have logged in.'
     * type: String [success, info, error]
     *
     * @param { Object }
     * @returns { Void }
     */
    notify({
      message = null,
      type = null,
      transition = "slide-y-reverse-transition",
      position = {
        top: false,
        bottom: true,
        left: false,
        right: false
      },
      centered = false
    }) {
      store.dispatch("alerts/execute", {
        message,
        type,
        transition,
        position,
        centered
      });
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
    loader() {
      store.commit("TOGGLE_LOADER", {
        field: "loading"
      });
    }
    // Add more ...
  });
};
