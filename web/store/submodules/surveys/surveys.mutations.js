import { updateField } from "vuex-map-fields";

export const mutations = {
  SET_STATE: (state, payload) => (state[payload.field] = payload.data),

  SET_QUESTION_GROUP_QUESTIONS: (state, payload) =>
    (state.survey.question_groups[payload.index].questions = payload.questions),

  APPEND_QUESTION_GROUP: (state, payload) =>
    state.survey.question_groups.push(payload),

  REMOVE_QUESTION_GROUP: (state, payload) => {
    const index = state.survey.question_groups.findIndex(
      item => payload.id === item.id
    );

    const splice = state.survey.question_groups.splice(index, 1);

    console.log("[SurveyStore] REMOVE_QUESTION_GROUP", {
      payload,
      index,
      splice
    });
  },

  updateField
};
