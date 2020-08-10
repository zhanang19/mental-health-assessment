export class SurveyQuestionGroup {
  constructor({ label = null, instructions = null } = {}) {
    this.label = label;
    this.instructions = instructions;
  }
}
