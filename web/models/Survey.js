import { validations } from "../utils/Util";
export class Survey {
  constructor({
    title = null,
    subtitle = null,
    description = null,
    color_theme = "blue darken-2",
    question_groups = [],
    responses = []
  } = {}) {
    this.title = title;
    this.subtitle = subtitle;
    this.description = description;
    this.color_theme = color_theme;
    this.question_groups = question_groups;
    this.responses = responses;
  }
}

export const surveyValidations = {
  title: validations.required
  // subtitle: [v => !!v || "This field is required."],
  // description: [v => !!v || "This field is required."],
  // color_theme: [v => !!v || "This field is required."]
};

export const colorThemes = [
  // "white",
  "indigo",
  "purple",
  "deep-purple",
  "pink",
  "cyan",
  "blue darken-2",
  "teal",
  "lime",
  "green",
  "orange"
];
