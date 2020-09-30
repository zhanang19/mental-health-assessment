import { validations } from "../utils/Util";
export class SurveyQuestionGroup {
  constructor({
    label = null,
    instructions = null,
    description = null,
    questions = []
  } = {}) {
    this.label = label;
    this.instructions = instructions;
    this.description = description;
    this.questions = questions;
  }
}

export const surveyQuestionGroupValidations = {
  label: validations.required,
  instructions: validations.required,
  description: validations.required
  // questions: validations.required
};
