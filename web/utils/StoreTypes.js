export const StoreActions = Object.freeze({
  REGISTER: "REGISTER"
});

export const UserActions = Object.freeze({
  FETCH_ALL: "users/FETCH_ALL",
  FETCH: "users/FETCH",
  CREATE: "users/CREATE",
  UPDATE: "users/UPDATE",
  UPDATE_AVATAR: "users/UPDATE_AVATAR",
  DELETE: "users/DELETE",
  RESTORE: "users/RESTORE",
  PERMANENTLY_DELETE: "users/PERMANENTLY_DELETE"
});

export const SurveyActions = Object.freeze({
  FETCH_ALL: "surveys/FETCH_ALL",
  FETCH: "surveys/FETCH",
  FETCH_QUESTION_GROUP_BY_ID: "surveys/FETCH_QUESTION_GROUP_BY_ID",
  FETCH_BY_SLUG: "surveys/FETCH_BY_SLUG",
  CREATE: "surveys/CREATE",
  CREATE_QUESTION_GROUP: "surveys/CREATE_QUESTION_GROUP",
  CREATE_QUESTION: "surveys/CREATE_QUESTION",
  UPDATE: "surveys/UPDATE",
  DUPLICATE_QUESTION_GROUP: "surveys/DUPLICATE_QUESTION_GROUP",
  DUPLICATE_QUESTION: "surveys/DUPLICATE_QUESTION",
  DELETE: "surveys/DELETE",
  DELETE_QUESTION_GROUP_BY_ID: "surveys/DELETE_QUESTION_GROUP_BY_ID",
  DELETE_QUESTION_BY_ID: "surveys/DELETE_QUESTION_BY_ID",
  RESTORE: "surveys/RESTORE",
  PERMANENTLY_DELETE: "surveys/PERMANENTLY_DELETE",
  TAKE_SURVEY: "surveys/TAKE_SURVEY"
});

export const SurveyResponseActions = Object.freeze({
  FETCH_ALL: "responses/FETCH_ALL",
  FETCH: "responses/FETCH",
  CREATE: "responses/CREATE",
  UPDATE: "responses/UPDATE",
  DELETE: "responses/DELETE",
  RESTORE: "responses/RESTORE",
  PERMANENTLY_DELETE: "responses/PERMANENTLY_DELETE",
  FETCH_RESPONSE_GROUP_BY_ID: "responses/FETCH_RESPONSE_GROUP_BY_ID",
  UPDATE_RESPONSE_GROUP_BY_ID: "responses/UPDATE_RESPONSE_GROUP_BY_ID"
});

export const SurveyMutations = Object.freeze({
  SET_STATE: "surveys/SET_STATE",
  SET_QUESTION_GROUP_QUESTIONS: "surveys/SET_QUESTION_GROUP_QUESTIONS"
});
