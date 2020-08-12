export const surveyService = {
  /**
   * @returns { Promise }
   */
  all: () => $nuxt.$axios.$get("/api/surveys"),

  /**
   * @param { Object } data
   * @returns { Promise }
   */
  findById: ({ id }) => $nuxt.$axios.$get(`/api/surveys/${id}`),

  /**
   * @param { Object } data
   * @returns { Promise }
   */
  findTrashedById: ({ id }) => id,

  /**
   * @param { Object } data
   * @returns { Promise }
   */
  findBySlug: ({ slug }) => slug,

  /**
   * @param { Object } data
   * @returns { Promise }
   */
  findTrashedBySlug: ({ slug }) => slug,

  /**
   * @returns { Promise }
   */
  createSurvey: () => $nuxt.$axios.$post("/api/surveys"),

  /**
   * @param { Object } data
   * @returns { Promise }
   */
  updateSurvey: ({ id, data }) =>
    $nuxt.$axios.$put(`/api/surveys/${id}`, { data }),

  /**
   * @param { Object } data
   * @returns { Promise }
   */
  deleteById: ({ id }) => $nuxt.$axios.$delete(`/api/surveys/${id}`),

  /**
   * @param { Object } data
   * @returns { Promise }
   */
  deletePermanentlyById: ({ id }) => id,

  /**
   * @param { Object } data
   * @returns { Promise }
   */
  deleteBySlug: ({ slug }) => slug,

  /**
   * @param { Object } data
   * @returns { Promise }
   */
  deletePermanentlyBySlug: ({ slug }) => slug,

  /**
   * @param { Object } data
   * @returns { Promise }
   */
  restoreById: ({ id }) => id,

  /**
   * @param { Object } data
   * @returns { Promise }
   */
  restoreBySlug: ({ slug }) => slug
};
