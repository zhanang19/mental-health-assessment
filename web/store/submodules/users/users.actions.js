import { handleError } from "~/utils/ErrorHandler";

/**
 * @method FETCH_ALL
 * @method FETCH
 * @method CREATE
 * @method UPDATE
 * @method UPDATE_AVATAR
 * @method DELETE
 * @method RESTORE
 * @method PERMANENTLY_DELETE
 */
export const actions = {
  /**
   * Fetch all resources from an API.
   *
   * @param { Object } context
   * @param { Object } payload
   *
   */
  FETCH_ALL: async ({ dispatch, state, commit }, payload) => {
    console.log("[Users] fetch users", payload);

    try {
      const response = await $nuxt.$axios.$get("/api/users");

      await commit("SET_STATE", {
        field: "users",
        data: response.data
      });
    } catch (error) {
      console.log(error);
      await $nuxt.$helpers.notify({
        type: "error",
        message: handleError(error)
      });
    }
  },

  /**
   * Fetch a single resource from an API.
   *
   * @param { Object } context
   * @param { Object } payload
   */
  FETCH: async ({ dispatch, state, commit }, payload) => {
    console.log("[Users] fetch user", payload);

    try {
      const response = await $nuxt.$axios.$get(`/api/users/${payload.userId}`);

      commit("SET_STATE", {
        field: "user",
        data: response.data
      });
    } catch (error) {
      await $nuxt.$helpers.notify({
        type: "error",
        message: handleError(error)
      });
    }
  },

  /**
   * Request to create a new record in API.
   *
   * @param { Object } context
   * @param { Object } payload
   */
  CREATE: async ({ dispatch, state, commit }, payload) => {
    console.log("[Users] add user", payload);

    try {
      $nuxt.$helpers.loader();
      const response = await $nuxt.$axios.$post("/api/users", state.form);

      commit("RESET_FORM");

      await $nuxt.$helpers.notify({
        type: "success",
        message: response?.message || "No message."
      });
    } catch (error) {
      await $nuxt.$helpers.notify({
        type: "error",
        message: handleError(error)
      });
    } finally {
      $nuxt.$helpers.loader();
    }
  },

  /**
   * Request to update an existing record from an API.
   *
   * @param { Object } context
   * @param { Object } payload
   */
  UPDATE: async ({ dispatch, state, commit }, payload) => {
    console.log("[Users] update user", payload);

    try {
      $nuxt.$helpers.loader();
      const response = await $nuxt.$axios.$put(
        `/api/users/${payload.userId}`,
        state.user
      );

      await $nuxt.$helpers.notify({
        type: "success",
        message: response?.message || "No message."
      });
    } catch (error) {
      await $nuxt.$helpers.notify({
        type: "error",
        message: handleError(error)
      });
    } finally {
      $nuxt.$helpers.loader();
    }
  },

  /**
   * Request to update user avatar from an API.
   *
   * @param { Object } context
   * @param { Object } payload
   */
  UPDATE_AVATAR: async ({ dispatch, state, commit }, payload) => {
    console.log("[Users] update user avatar", payload);

    try {
      $nuxt.$helpers.loader();
      const response = await $nuxt.$axios.$put(
        `/api/users/${payload.userId}/avatar`,
        payload
      );

      await $nuxt.$helpers.notify({
        type: "success",
        message: response?.message || "No message."
      });
    } catch (error) {
      await $nuxt.$helpers.notify({
        type: "error",
        message: handleError(error)
      });
    } finally {
      $nuxt.$helpers.loader();
    }
  },

  /**
   * Delete a resource from an API.
   *
   * @param { Object } context
   * @param { Object } payload
   */
  DELETE: async ({ dispatch, state, commit }, payload) => {
    console.log("[Users] delete user", payload);

    try {
      const response = await $nuxt.$axios.$delete(
        `/api/users/${payload.userId}`
      );

      await $nuxt.$helpers.notify({
        type: "success",
        message: response?.message || "No message."
      });

      dispatch("FETCH_ALL")
    } catch (error) {
      await $nuxt.$helpers.notify({
        type: "error",
        message: handleError(error)
      });
    }
  },

  /**
   * Restore a deleted resource from an API.
   *
   * @param { Object } context
   * @param { Object } payload
   */
  RESTORE: async ({ dispatch, state, commit }, payload) => {
    console.log("[Users] restore user", payload);

    try {
      const response = await $nuxt.$axios.$get(
        `/api/users/${payload.userId}/restore`
      );

      await $nuxt.$helpers.notify({
        type: "success",
        message: response?.message || "No message."
      });
    } catch (error) {
      await $nuxt.$helpers.notify({
        type: "error",
        message: handleError(error)
      });
    }
  },

  /**
   * Permanently delete a resource from an API.
   *
   * @param { Object } context
   * @param { Object } payload
   */
  PERMANENTLY_DELETE: async ({ dispatch, state, commit }, payload) => {
    console.log("[Users] permanently user", payload);

    try {
      const response = await $nuxt.$axios.$delete(
        `/api/users/${payload.userId}/force-delete`
      );

      await $nuxt.$helpers.notify({
        type: "success",
        message: response?.message || "No message."
      });
    } catch (error) {
      await $nuxt.$helpers.notify({
        type: "error",
        message: handleError(error)
      });
    }
  }
};
