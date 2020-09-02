import { handleError } from "~/utils/ErrorHandler";
/**
 * @method FETCH_ALL
 * @method FETCH -- @param (surveyId)
 * @method FETCH_BY_SLUG -- @param (slug)
 * @method CREATE
 * @method UPDATE -- @param (slug)
 * @method DELETE -- @param (surveyId)
 * @method RESTORE -- @param (surveyId)
 * @method PERMANENTLY_DELETE -- @param (surveyId)
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
    console.log("[SurveyResponseStore] Fetch All Surveys", payload);

    try {
      const response = await $nuxt.$axios.$get("/api/surveys");

      await await commit("SET_STATE", {
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
    console.log("[SurveyResponseStore] Fetch Survey", payload);

    try {
      const response = await $nuxt.$axios.$get(
        `/api/surveys/${payload.surveyId}`
      );

      await commit("SET_STATE", {
        field: "survey",
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
        `/api/surveys/${payload.slug}/slug`
      );

      await commit("SET_STATE", {
        field: "survey",
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
  FETCH_SURVEY_RESPONSE_GROUP_BY_ID: async (
    { dispatch, state, commit },
    payload
  ) => {
    console.log(
      "[SurveyResponseStore] Fetch Survey Respone Group By ID",
      payload
    );

    try {
      const response = await $nuxt.$axios.$get(
        `/api/surveys/${payload.slug}/responses/${payload.responseId}/groups/${payload.responseGroupId}`
      );

      await commit("SET_STATE", {
        field: "survey",
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
   * Request to create a new record in API.
   *
   * @param { Object } context
   * @param { Object } payload
   */
  CREATE: async ({ dispatch, state, commit }, payload) => {
    console.log("[SurveyResponseStore] Create Survey", payload);

    try {
      $nuxt.$helpers.loader();
      const response = await $nuxt.$axios.$post("/api/surveys", {});

      // await commit("RESET_FORM");

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
    console.log("[SurveyResponseStore] Update Survey", payload);

    try {
      const response = await $nuxt.$axios.$put(
        `/api/surveys/${payload.surveyId}`,
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
   * Delete a resource from an API.
   *
   * @param { Object } context
   * @param { Object } payload
   */
  DELETE: async ({ dispatch, state, commit }, payload) => {
    console.log("[SurveyResponseStore] Delete Survey", payload);

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
   * Delete a resource from an API.
   *
   * @param { Object } context
   * @param { Object } payload
   */
  DELETE_QUESTION_GROUP_BY_ID: async ({ dispatch, state, commit }, payload) => {
    console.log("[SurveyResponseStore] Delete Question Group By ID", payload);

    try {
      const response = await $nuxt.$axios.$delete(
        `/api/surveys/${payload.surveyId}/question-groups/${payload.questionGroupId}`
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
    console.log("[SurveyResponseStore] Permanently Delete Survey", payload);

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
