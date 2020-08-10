export class Survey {
  constructor({ title = null, subtitle = null, description = null } = {}) {
    this.title = title;
    this.subtitle = subtitle;
    this.description = description;
  }
}
