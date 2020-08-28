/**
 * List of all validation rules based on Vuetify v-form.
 *
 * @var { Object } Rules
 */
export const Rules = {
  required: [value => !!value || "This field is required."],
  sampleRule: [
    value => {
      return true;
    }
  ]
};

/**
 * Validation rules for user form.
 *
 * @var { Object } UserRules
 */
export const UserRules = {
  first_name: Rules.required,
  last_name: Rules.required,
  email: Rules.required,
  // contact_number: Rules.required,
  role: Rules.required,
  password: Rules.required,
  password_confirmation: Rules.required
};

/**
 * Validation rules for user form.
 *
 * @var { Object } DemographicProfileRules
 */
export const DemographicProfileRules = {
  identification_number: Rules.required,
  age: Rules.required,
  gender: Rules.required,
  date_of_birth: Rules.required,
  place_of_birth: Rules.required,
  religious_affiliation: Rules.required,
  gpa: Rules.required,
  citizenship: Rules.required,
  // ordinal_position: Rules.required,
  currently_living_with: Rules.required,
  // city_address: Rules.required,
  home_address: Rules.required,
  // is_scholar: Rules.required,
  // is_affected_marawi_siege: Rules.required,
  // scholarship_grant: Rules.required,
  parents_marital_status: Rules.required,
  family_monthly_income: Rules.required,
  // school_last_attended: Rules.required,
  // school_address: Rules.required
};
