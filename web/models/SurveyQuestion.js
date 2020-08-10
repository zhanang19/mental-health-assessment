export class SurveyQuestion {
  constructor({
    identifier = null,
    input_type = null,
    question = null,
    hint = null,
    validations = null,
    choices_a = [],
    choices_b = []
  } = {}) {
    this.identifier = identifier;
    this.input_type = input_type;
    this.question = question;
    this.hint = hint;
    this.validations = validations;
    this.choices_a = choices_a;
    this.choices_b = choices_b;
  }
}
