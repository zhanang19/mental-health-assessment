<template>
  <v-stepper v-model="step" class="elevation-0" vertical>
    <v-stepper-step :complete="step > 1" step="1">
      <span>Your account information</span>
    </v-stepper-step>

    <v-stepper-content step="1">
      <v-form ref="accountInformationForm" @submit.prevent="next(1)">
        <v-card-text>
          <v-text-field
            v-model="email"
            :rules="rules.accountInformationFormRules.email"
            label="Email"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <v-text-field
            v-model="password"
            :rules="rules.accountInformationFormRules.password"
            type="password"
            label="Password"
            hint="Required"
            outlined
          ></v-text-field>
          <v-text-field
            v-model="password_confirmation"
            :rules="rules.accountInformationFormRules.password_confirmation"
            type="password"
            label="Password Confirmation"
            hint="Required"
            outlined
          ></v-text-field>
          <v-text-field
            v-model="identification_number"
            :rules="rules.accountInformationFormRules.identification_number"
            label="ID Number"
            hint="Required"
            outlined
          ></v-text-field>

          <v-btn color="primary" type="submit">Continue</v-btn>
          <v-btn @click="$refs.accountInformationForm.reset()" text>Cancel</v-btn>
        </v-card-text>
      </v-form>
    </v-stepper-content>

    <v-stepper-step :complete="step > 2" step="2">Your personal information</v-stepper-step>

    <v-stepper-content step="2">
      <v-form ref="personalInformationForm" @submit.prevent="next(2)">
        <v-card-text>
          <v-text-field
            v-model="first_name"
            :rules="rules.personalInformationFormRules.first_name"
            label="First Name"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <v-text-field
            v-model="middle_name"
            :rules="rules.personalInformationFormRules.middle_name"
            label="Middle Name"
            hint="Optional"
            outlined
          ></v-text-field>
          <v-text-field
            v-model="last_name"
            :rules="rules.personalInformationFormRules.last_name"
            label="Last Name"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <v-text-field
            v-model="age"
            :rules="rules.personalInformationFormRules.age"
            type="number"
            label="Age"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <v-select
            v-model="gender"
            :rules="rules.personalInformationFormRules.gender"
            label="Gender"
            :items="['Male', 'Female']"
            hint="Required"
            persistent-hint
            outlined
          ></v-select>
          <v-text-field
            v-model="date_of_birth"
            :rules="rules.personalInformationFormRules.date_of_birth"
            type="date"
            label="Date of Birth"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <v-text-field
            v-model="place_of_birth"
            :rules="rules.personalInformationFormRules.place_of_birth"
            label="Place of Birth"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>

          <v-btn color="primary" type="submit">Continue</v-btn>
          <v-btn text>Cancel</v-btn>
        </v-card-text>
      </v-form>
    </v-stepper-content>

    <v-stepper-step :complete="step > 3" step="3">Your demographic profile</v-stepper-step>

    <v-stepper-content step="3">
      <v-form ref="demographicProfileForm" @submit.prevent="next(3)">
        <v-card-text>
          <v-text-field
            v-model="religious_affiliation"
            :rules="rules.demographicProfileFormRules.religious_affiliation"
            label="Religious Affiliation"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <v-text-field
            v-model="citizenship"
            :rules="rules.demographicProfileFormRules.citizenship"
            label="Citizenship"
            hint="Optional"
            outlined
          ></v-text-field>
          <v-text-field
            v-model="ordinal_position"
            :rules="rules.demographicProfileFormRules.ordinal_position"
            label="Ordinal Position"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <v-text-field
            v-model="currently_living_with"
            :rules="rules.demographicProfileFormRules.currently_living_with"
            label="Currently Living With"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <v-text-field
            v-model="gpa"
            :rules="rules.demographicProfileFormRules.gpa"
            label="GPA"
            type="number"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <v-text-field
            v-model="city_address"
            :rules="rules.demographicProfileFormRules.city_address"
            label="City Address"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <v-text-field
            v-model="home_address"
            :rules="rules.demographicProfileFormRules.home_address"
            label="Home Address"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>

          <v-btn color="primary" type="submit">Continue</v-btn>
          <v-btn text>Cancel</v-btn>
        </v-card-text>
      </v-form>
    </v-stepper-content>

    <v-stepper-step step="4">More information</v-stepper-step>
    <v-stepper-content step="4">
      <v-form ref="moreInformationForm" @submit.prevent="next(4)">
        <v-card-text>
          <v-text-field
            v-model="scholarship_grant"
            :rules="rules.moreInformationFormRules.scholarship_grant"
            label="Scholarship Grant"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <v-text-field
            v-model="parents_martial_status"
            :rules="rules.moreInformationFormRules.parents_martial_status"
            label="Parents Marital Status"
            hint="Optional"
            outlined
          ></v-text-field>
          <v-text-field
            v-model="family_monthly_income"
            :rules="rules.moreInformationFormRules.family_monthly_income"
            label="Family Monthly Income"
            type="number"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <v-text-field
            v-model="school_last_attended"
            :rules="rules.moreInformationFormRules.school_last_attended"
            label="School Last Attended"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <v-text-field
            v-model="school_address"
            :rules="rules.moreInformationFormRules.school_address"
            label="School Address"
            type="number"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <v-checkbox
            v-model="is_scholar"
            :rules="rules.moreInformationFormRules.is_scholar"
            color="primary"
            label="Scholar"
          ></v-checkbox>
          <v-checkbox
            v-model="is_affected_marawi_siege"
            :rules="rules.moreInformationFormRules.is_affected_marawi_siege"
            color="primary"
            label="Affected by Marawi Siege"
          ></v-checkbox>

          <v-btn color="primary" type="submit">Continue</v-btn>
          <v-btn text>Cancel</v-btn>
        </v-card-text>
      </v-form>
    </v-stepper-content>
  </v-stepper>
</template>

<script>
import { mapFields } from "vuex-map-fields";
import { UserRules, DemographicProfileRules } from "../../utils/Validations";
import { removeKeys, only } from "../../utils/Util";

export default {
  data: () => ({
    step: 1,
  }),

  created() {
    console.log(this.rules);
  },

  computed: {
    rules() {
      return {
        accountInformationFormRules: only(
          { ...UserRules, ...DemographicProfileRules },
          [
            "email",
            "password",
            "password_confirmation",
            "identification_number",
          ]
        ),

        personalInformationFormRules: {
          ...only({ ...UserRules }, ["first_name", "middle_name", "last_name"]),

          ...only({ ...DemographicProfileRules }, [
            "age",
            "gender",
            "date_of_birth",
            "place_of_birth",
          ]),
        },

        demographicProfileFormRules: only({ ...DemographicProfileRules }, [
          "religious_affiliation",
          "citizenship",
          "ordinal_position",
          "currently_living_with",
          "gpa",
          "city_address",
          "home_address",
        ]),

        moreInformationFormRules: only({ ...DemographicProfileRules }, [
          "scholarship_grant",
          "parents_martial_status",
          "family_monthly_income",
          "school_last_attended",
          "school_address",
          "is_scholar",
          "is_affected_marawi_siege",
        ]),
      };
    },

    ...mapFields("users", [
      "form.avatar",
      "form.role",
      "form.password",
      "form.password_confirmation",
      "form.username",
      "form.first_name",
      "form.last_name",
      "form.middle_name",
      "form.email",
      "form.is_active",
      "form.demographic_profile.identification_number",
      "form.demographic_profile.age",
      "form.demographic_profile.gender",
      "form.demographic_profile.date_of_birth",
      "form.demographic_profile.place_of_birth",
      "form.demographic_profile.religious_affiliation",
      "form.demographic_profile.gpa",
      "form.demographic_profile.citizenship",
      "form.demographic_profile.ordinal_position",
      "form.demographic_profile.currently_living_with",
      "form.demographic_profile.city_address",
      "form.demographic_profile.home_address",
      "form.demographic_profile.is_scholar",
      "form.demographic_profile.is_affected_marawi_siege",
      "form.demographic_profile.scholarship_grant",
      "form.demographic_profile.parents_martial_status",
      "form.demographic_profile.family_monthly_income",
      "form.demographic_profile.school_last_attended",
      "form.demographic_profile.school_address",
    ]),
  },

  methods: {
    next(currentStep) {
      const forms = Object.freeze({
        AccountInformation: "accountInformationForm",
        PersonalInformation: "personalInformationForm",
        DemographicProfile: "demographicProfileForm",
        MoreInformation: "moreInformationForm",
      });

      switch (currentStep) {
        case 1:
          if (this.$refs[forms.AccountInformation].validate()) {
            console.log("VALIDATED");
            this.step = 2;
            break;
          } else {
            return this.$helpers.notify({
              type: "error",
              message: "Please fill in the required fields.",
            });
          }

        case 2:
          if (this.$refs[forms.PersonalInformation].validate()) {
            console.log("VALIDATED");
            this.step = 3;
            break;
          } else {
            return this.$helpers.notify({
              type: "error",
              message: "Please fill in the required fields.",
            });
          }

        case 3:
          if (this.$refs[forms.DemographicProfile].validate()) {
            console.log("VALIDATED");
            this.step = 4;
            break;
          } else {
            return this.$helpers.notify({
              type: "error",
              message: "Please fill in the required fields.",
            });
          }

        case 4:
          if (this.$refs[forms.MoreInformation].validate()) {
            console.log("FORM SENT");
          } else {
            return this.$helpers.notify({
              type: "error",
              message: "Please fill in the required fields.",
            });
          }

        default:
          return this.$helpers.notify({
            type: "error",
            message: "Please fill in the required fields.",
          });
      }
    },
  },
};
</script>
