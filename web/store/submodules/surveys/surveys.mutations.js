import { updateField } from "vuex-map-fields";

export const mutations = {
  SET_STATE: (state, payload) => (state[payload.field] = payload.data),

  SET_QUESTION_GROUP_QUESTIONS: (state, payload) =>
    (state.survey.question_groups[payload.index].questions = payload.questions),

  updateField
};
