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
  username: Rules.required,
  first_name: Rules.required,
  last_name: Rules.required,
  // middle_name: Rules.required,
  email: Rules.required,
  contact_number: Rules.required,
  role: Rules.required,
  type: Rules.required,
  date_joined: Rules.required,
  password: Rules.required,
  password_confirmation: Rules.required
  // time_zone: Rules.required,
};
