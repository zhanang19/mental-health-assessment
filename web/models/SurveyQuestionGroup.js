export class SurveyQuestionGroup {
  constructor({ label = null, instructions = null, questions = [] } = {}) {
    this.label = label;
    this.instructions = instructions;
    this.questions = questions;
  }
}
