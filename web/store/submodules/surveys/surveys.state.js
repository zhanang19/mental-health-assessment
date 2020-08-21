import { Survey } from "~/models/Survey";

export const state = () => ({
  surveys: [],
  survey: {},
  form: new Survey
})
