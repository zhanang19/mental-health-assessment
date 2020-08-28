import { getField, updateField } from "vuex-map-fields";
import { getYearList } from "../utils/Util";
import { UserRoles } from "~/utils/UserRoles";
import moment from "moment";

export const state = () => ({
  type: "",
  loader: {
    loading: false,
    dismissable: false
  },
  drawer: true,
  errors: {}
});

export const getters = {
  isSuperAdmin: state => state.auth.user.role === UserRoles.SuperAdministrator,

  isAdmin: state =>
    state.auth.loggedIn &&
    (state.auth.user.role === UserRoles.Administrator ||
      state.auth.user.role === UserRoles.SuperAdministrator),

  isStudent: state => state.auth.user.role === UserRoles.Student,

  weeks: () =>
    Array.from(Array(54).keys())
      .filter(item => item > 0)
      .map(item => ({
        text: `Week ${item}`,
        value: item
      })),
  months: () =>
    Array.from(Array(13).keys())
      .filter(item => item > 0)
      .map(item => ({
        text: `Month of ${moment(item, "MM").format("MMMM")}`,
        value: item
      })),
  years: () => getYearList(2020 - 20).sort((a, b) => b - a),

  getField
};

export const mutations = {
  SET_STATE: (state, payload) => (state[payload.field] = payload.data),

  TOGGLE_DRAWER: state => (state.drawer = !state.drawer),

  TOGGLE_LOADER: (state, payload) =>
    (state.loader[payload.field] = !state.loader[payload.field]),

  SET_DRAWER: (state, bool) => (state.drawer = bool),

  updateField
};

export const actions = {
  /**
   * Updates user profile.
   *
   * @param { Object } context
   * @param { Object } payload
   */
  async updateProfile({ state, commit, dispatch }, payload) {
    try {
      await this.$helpers.loader();
      const response = await this.$axios.$post(
        `/api/auth/update`,
        state.auth.user
      );
      console.log(response);
      await this.$helpers.notify({
        type: "success",
        message: response.message
      });
    } catch (error) {
      console.log(error);
      let message;
      if (error.response.status === 422) {
        message = error.response.data.message;
        commit("SET_STATE", {
          field: "errors",
          data: error.response.data.errors
        });
      }

      return await this.$helpers.notify({
        type: "error",
        message: message || "Sorry, an error occurred. Try again later."
      });
    } finally {
      await this.$helpers.loader();
    }
  },

  /**
   * Updates user password.
   *
   * @param { Object } context
   * @param { Object } payload
   */
  async updatePassword({ commit }, payload) {
    try {
      await this.$helpers.loader();
      const response = await this.$axios.$put(
        `/api/auth/update-password`,
        payload.credentials
      );

      console.log(response);
      await this.$helpers.notify({
        type: "success",
        message: response.message || "Your password has been updated."
      });
    } catch (error) {
      console.log(error);
      let message;
      if (error.response.status === 422) {
        message = error.response.data.message;
        commit("SET_STATE", {
          field: "errors",
          data: error.response.data.errors
        });
      }

      if (error.response.status === 403) {
        message = error.response.data.message;
      }

      return await this.$helpers.notify({
        type: "error",
        message: message || "Sorry, an error occurred. Try again later."
      });
    } finally {
      await this.$helpers.loader();
    }
  },

  /**
   * Load all saved preferences in local storage.
   *
   * @param { Object } context
   * @return { Void }
   */
  loadPreferences({ commit }) {
    const preferences = {
      type: localStorage.getItem("preferences.type"),
      theme: localStorage.getItem("preferences.theme")
    };

    $nuxt.$vuetify.theme.dark = preferences.theme === "dark" ? true : false;
    commit("SET_STATE", {
      field: "type",
      data: preferences.type
    });

    if (preferences.type === "facility") {
      return commit("SET_DRAWER", false);
    }

    return commit("SET_DRAWER", true);
  }
};
