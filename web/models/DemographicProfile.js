export class DemographicProfile {
  constructor({
    identification_number = null,
    age = null,
    gender = null,
    date_of_birth = null,
    place_of_birth = null,
    religious_affiliation = null,
    gpa = null,
    citizenship = null,
    ordinal_position = null,
    currently_living_with = null,
    city_address = null,
    home_address = null,
    is_scholar = false,
    is_affected_marawi_siege = false,
    scholarship_grant = null,
    parents_martial_status = null,
    family_monthly_income = null,
    school_last_attended = null,
    school_address = null
  } = {}) {
    this.identification_number = identification_number;
    this.age = age;
    this.gender = gender;
    this.date_of_birth = date_of_birth;
    this.place_of_birth = place_of_birth;
    this.religious_affiliation = religious_affiliation;
    this.gpa = gpa;
    this.citizenship = citizenship;
    this.ordinal_position = ordinal_position;
    this.currently_living_with = currently_living_with;
    this.city_address = city_address;
    this.home_address = home_address;
    this.is_scholar = is_scholar;
    this.is_affected_marawi_siege = is_affected_marawi_siege;
    this.scholarship_grant = scholarship_grant;
    this.parents_martial_status = parents_martial_status;
    this.family_monthly_income = family_monthly_income;
    this.school_last_attended = school_last_attended;
    this.school_address = school_address;
  }
}
