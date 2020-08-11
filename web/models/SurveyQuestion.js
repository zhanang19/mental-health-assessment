import { validations } from "../utils/Util";

export class SurveyQuestion {
  constructor({
    identifier = null,
    input_type = null,
    question = null,
    hint = null,
    required = false,
    choices_a = [new Option()],
    choices_b = [new Option()]
  } = {}) {
    this.identifier = identifier;
    this.input_type = input_type;
    this.question = question;
    this.hint = hint;
    this.required = required;
    this.choices_a = choices_a;
    this.choices_b = choices_b;
  }
}

export class Option {
  constructor({ text = null } = {}) {
    this.text = text;
  }
}

export const surveyQuestionValidations = {
  identifier: validations.required,
  input_type: validations.required,
  question: validations.required
  // hint: validations.required,
  // validations: validations.required,
  // choices_a: validations.required,
  // choices_b: validations.required
};

export const inputTypesEnum = {
  shortAnswer: "short answer",
  paragraph: "paragraph",
  multipleChoice: "multiple choice",
  checkboxes: "checkboxes",
  dropdown: "dropdown"
};

export const inputTypes = [
  inputTypesEnum.shortAnswer,
  inputTypesEnum.paragraph,
  inputTypesEnum.multipleChoice,
  inputTypesEnum.checkboxes,
  inputTypesEnum.dropdown
];
