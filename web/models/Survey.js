export class Survey {
  constructor({
    title = null,
    subtitle = null,
    description = null,
    color_theme = "indigo"
  } = {}) {
    this.title = title;
    this.subtitle = subtitle;
    this.description = description;
    this.color_theme = color_theme;
  }
}

export const colorThemes = [
  "indigo",
  "purple",
  "pink",
  "cyan",
  "blue darken-2",
  "teal",
  "lime",
  "green"
];
