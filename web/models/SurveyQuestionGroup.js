import { validations } from '../utils/Util'
export class SurveyQuestionGroup {
  constructor({ label = null, instructions = null, questions = [] } = {}) {
    this.label = label;
    this.instructions = instructions;
    this.questions = questions;
  }
}

export const surveyQuestionGroupValidations = {
  label: validations.required,
  instructions: validations.required,
  // questions: validations.required
};
