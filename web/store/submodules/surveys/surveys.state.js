import { Survey } from "~/models/Survey";

export const state = () => ({
  surveys: [],
  survey: {},
  question_group: {},
  form: new Survey()
});
