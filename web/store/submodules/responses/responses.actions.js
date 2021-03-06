import { handleError } from "~/utils/ErrorHandler";
/**
 * @method FETCH_ALL
 * @method FETCH -- @param (responseId)
 * @method FETCH_BY_SLUG -- @param (slug)
 * @method CREATE
 * @method UPDATE -- @param (slug)
 * @method DELETE -- @param (responseId)
 * @method RESTORE -- @param (responseId)
 * @method PERMANENTLY_DELETE -- @param (responseId)
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
    console.log("[SurveyResponseStore] Fetch All Responses", payload);

    try {
      const response = await $nuxt.$axios.$get("/api/responses");

      await await commit("SET_STATE", {
        field: "responses",
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
    console.log("[SurveyResponseStore] Fetch Survey", payload);

    try {
      const response = await $nuxt.$axios.$get(
        `/api/responses/${payload.responseId}`
      );

      await commit("SET_STATE", {
        field: "response",
        data: response.data
      });

      return response;
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
  FETCH_RESPONSE_GROUP_BY_ID: async ({ dispatch, state, commit }, payload) => {
    console.log("[SurveyResponseStore] Fetch SurveyResponseGroup", payload);

    try {
      const response = await $nuxt.$axios.$get(
        `/api/responses/${payload.responseId}/groups/${payload.responseGroupId}`
      );

      await commit("SET_STATE", {
        field: "response_group",
        data: response.data
      });

      return response;
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
    console.log("[SurveyResponseStore] Fetch By Slug", payload);

    try {
      const response = await $nuxt.$axios.$get(
        `/api/responses/${payload.slug}/slug`
      );

      await commit("SET_STATE", {
        field: "response",
        data: response.data
      });

      return response;
    } catch (error) {
      await $nuxt.$helpers.notify({
        type: "error",
        message: handleError(error)
      });
    }
  },

  // /**
  //  * Fetch a single resource from an API.
  //  *
  //  * @param { Object } context
  //  * @param { Object } payload
  //  */
  // FETCH_SURVEY_RESPONSE_GROUP_BY_ID: async (
  //   { dispatch, state, commit },
  //   payload
  // ) => {
  //   console.log(
  //     "[SurveyResponseStore] Fetch Survey Respone Group By ID",
  //     payload
  //   );

  //   try {
  //     const response = await $nuxt.$axios.$get(
  //       `/api/responses/${payload.slug}/responses/${payload.responseId}/groups/${payload.responseGroupId}`
  //     );

  //     await commit("SET_STATE", {
  //       field: "response",
  //       data: response.data
  //     });

  //     return response;
  //   } catch (error) {
  //     await $nuxt.$helpers.notify({
  //       type: "error",
  //       message: handleError(error)
  //     });
  //   }
  // },

  /**
   * Request to create a new record in API.
   *
   * @param { Object } context
   * @param { Object } payload
   */
  CREATE: async ({ dispatch, state, commit }, payload) => {
    console.log("[SurveyResponseStore] Create Survey", payload);

    try {
      $nuxt.$helpers.loader();
      const response = await $nuxt.$axios.$post("/api/responses", {});

      // await commit("RESET_FORM");

      $nuxt.$router.push({
        name: "responses-edit-slug",
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
    console.log("[SurveyResponseStore] Update Survey", payload);

    try {
      const response = await $nuxt.$axios.$put(
        `/api/responses/${payload.responseId}`,
        state.survey
      );

      return response;
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
  UPDATE_RESPONSE_GROUP_BY_ID: async ({ dispatch, state, commit }, payload) => {
    console.log("[SurveyResponseStore] Update SurveyResponseGroup", payload);

    try {
      const response = await $nuxt.$axios.$put(
        `/api/responses/${payload.responseId}/groups/${payload.responseGroupId}`, state.response_group
      );

      return response;
    } catch (error) {
      await $nuxt.$helpers.notify({
        type: "error",
        message: handleError(error)
      });
    }
  },

  /**
   * Delete a resource from an API.
   *
   * @param { Object } context
   * @param { Object } payload
   */
  DELETE: async ({ dispatch, state, commit }, payload) => {
    console.log("[SurveyResponseStore] Delete Survey", payload);

    try {
      const response = await $nuxt.$axios.$delete(
        `/api/responses/${payload.responseId}`
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
   * Delete a resource from an API.
   *
   * @param { Object } context
   * @param { Object } payload
   */
  DELETE_QUESTION_GROUP_BY_ID: async ({ dispatch, state, commit }, payload) => {
    console.log("[SurveyResponseStore] Delete Question Group By ID", payload);

    try {
      const response = await $nuxt.$axios.$delete(
        `/api/responses/${payload.responseId}/question-groups/${payload.questionGroupId}`
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
    console.log("[SurveyResponseStore] Restore Survey", payload);

    try {
      const response = await $nuxt.$axios.$get(
        `/api/responses/${payload.responseId}/restore`
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
    console.log("[SurveyResponseStore] Permanently Delete Survey", payload);

    try {
      const response = await $nuxt.$axios.$delete(
        `/api/responses/${payload.responseId}/force-delete`
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
