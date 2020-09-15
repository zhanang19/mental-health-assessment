import { validations } from "~/utils/Util";
import { ScaleTypes } from "~/enums/ScaleTypes";

export class SurveyQuestion {
  constructor({
    identifier = null,
    input_type = null,
    question = null,
    hint = null,
    required = false,
    option_group_a = new OptionGroup(),
    option_group_b = new OptionGroup()
  } = {}) {
    this.identifier = identifier;
    this.input_type = input_type;
    this.question = question;
    this.hint = hint;
    this.required = required;
    this.option_group_a = option_group_a;
    this.option_group_b = option_group_b;
  }
}

export class Option {
  constructor({ text = null, value = null } = {}) {
    this.text = text;
    this.value = value;
  }
}

export class OptionGroup {
  constructor({
    label = "Untitled Scale",
    type = ScaleTypes.NONE,
    options = [new Option()]
  } = {}) {
    this.label = label;
    this.type = type;
    this.options = options;
  }
}

export const surveyQuestionValidations = {
  identifier: validations.required,
  input_type: validations.required,
  question: validations.required
  // hint: validations.required,
  // validations: validations.required,
  // option_group_a: validations.required,
  // option_group_b: validations.required
};

export const surveyQuestionOptionValidations = {
  text: validations.required
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
