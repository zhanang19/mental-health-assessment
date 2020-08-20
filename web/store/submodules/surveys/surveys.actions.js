import { handleError } from "~/utils/ErrorHandler";

export const actions = {
  /**
   * Fetch all resources from an API.
   *
   * @param { Object } context
   * @param { Object } payload
   *
   */
  FETCH_ALL: async ({ dispatch, state, commit }, payload) => {
    console.log("[SurveyStore] fetch surveys", payload);

    try {
      const response = await $nuxt.$axios.$get("/api/surveys");

      await commit("SET_STATE", {
        field: "surveys",
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
    console.log("[SurveyStore] fetch survey", payload);

    try {
      const response = await $nuxt.$axios.$get(
        `/api/surveys/${payload.surveyId}`
      );

      commit("SET_STATE", {
        field: "survey",
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
   * Fetch a single resource from an API.
   *
   * @param { Object } context
   * @param { Object } payload
   */
  FETCH_BY_SLUG: async ({ dispatch, state, commit }, payload) => {
    console.log("[SurveyStore] fetch survey", payload);

    try {
      const response = await $nuxt.$axios.$get(
        `/api/surveys/${payload.surveyId}`
      );

      commit("SET_STATE", {
        field: "survey",
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
    console.log("[SurveyStore] add survey", payload);

    try {
      $nuxt.$helpers.loader();
      const response = await $nuxt.$axios.$post("/api/surveys", {});

      // commit("RESET_FORM");

      $nuxt.$router.push({
        name: "surveys-edit-slug",
        params: { slug: response.data.slug }
      });

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
    console.log("[SurveyStore] update survey", payload);

    try {
      $nuxt.$helpers.loader();
      const response = await $nuxt.$axios.$put(
        `/api/surveys/${payload.surveyId}`,
        state.survey
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
   * Request to update survey avatar from an API.
   *
   * @param { Object } context
   * @param { Object } payload
   */
  UPDATE_AVATAR: async ({ dispatch, state, commit }, payload) => {
    console.log("[SurveyStore] update survey avatar", payload);

    try {
      $nuxt.$helpers.loader();
      const response = await $nuxt.$axios.$put(
        `/api/surveys/${payload.surveyId}/avatar`,
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
    console.log("[SurveyStore] delete survey", payload);

    try {
      const response = await $nuxt.$axios.$delete(
        `/api/surveys/${payload.surveyId}`
      );

      await $nuxt.$helpers.notify({
        type: "success",
        message: response?.message || "No message."
      });

      dispatch("FETCH_ALL");
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
    console.log("[SurveyStore] restore survey", payload);

    try {
      const response = await $nuxt.$axios.$get(
        `/api/surveys/${payload.surveyId}/restore`
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
    console.log("[SurveyStore] permanently survey", payload);

    try {
      const response = await $nuxt.$axios.$delete(
        `/api/surveys/${payload.surveyId}/force-delete`
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
