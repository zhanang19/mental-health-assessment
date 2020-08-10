export class Guardian {
  constructor({
    first_name = null,
    middle_name = null,
    last_name = null,
    occupation = null,
    workplace = null,
    is_ofw = false,
    away_from_home = null
  } = {}) {
    this.first_name = first_name;
    this.middle_name = middle_name;
    this.last_name = last_name;
    this.occupation = occupation;
    this.workplace = workplace;
    this.is_ofw = is_ofw;
    this.away_from_home = away_from_home;
  }
}
