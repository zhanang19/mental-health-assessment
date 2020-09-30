<template>
  <v-stepper v-model="step" class="elevation-0" vertical>
    <v-stepper-step :complete="step > 1" step="1">
      <span>Your account information</span>
    </v-stepper-step>

    <v-stepper-content step="1">
      <v-form ref="accountInformationForm" @submit.prevent="next(1)">
        <v-card-text>
          <div class="subtitle-2">Email</div>
          <v-text-field
            v-model="email"
            :rules="rules.accountInformationFormRules.email"
            hint="Required"
            type="email"
            persistent-hint
            outlined
          ></v-text-field>
          <div class="subtitle-2">Password</div>
          <v-text-field
            v-model="password"
            :rules="rules.accountInformationFormRules.password"
            type="password"
            hint="Required"
            outlined
          ></v-text-field>
          <div class="subtitle-2">Password Confirmation</div>
          <v-text-field
            v-model="password_confirmation"
            :rules="rules.accountInformationFormRules.password_confirmation"
            type="password"
            hint="Required"
            outlined
          ></v-text-field>
          <div class="subtitle-2">ID Number</div>
          <v-text-field
            v-model="identification_number"
            :rules="rules.accountInformationFormRules.identification_number"
            hint="Required"
            outlined
          ></v-text-field>

          <v-btn color="primary" type="submit">Continue</v-btn>
          <v-btn @click="$refs.accountInformationForm.reset()" text
            >Cancel</v-btn
          >
        </v-card-text>
      </v-form>
    </v-stepper-content>

    <v-stepper-step :complete="step > 2" step="2"
      >Your personal information</v-stepper-step
    >

    <v-stepper-content step="2">
      <v-form ref="personalInformationForm" @submit.prevent="next(2)">
        <v-card-text>
          <div class="subtitle-2">First Name</div>
          <v-text-field
            v-model="first_name"
            :rules="rules.personalInformationFormRules.first_name"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <div class="subtitle-2">Middle Name</div>
          <v-text-field
            v-model="middle_name"
            :rules="rules.personalInformationFormRules.middle_name"
            hint="Optional"
            outlined
          ></v-text-field>
          <div class="subtitle-2">Last Name</div>
          <v-text-field
            v-model="last_name"
            :rules="rules.personalInformationFormRules.last_name"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <div class="subtitle-2">Age</div>
          <v-text-field
            v-model="age"
            :rules="rules.personalInformationFormRules.age"
            type="number"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <div class="subtitle-2">Gender</div>
          <v-select
            v-model="gender"
            :rules="rules.personalInformationFormRules.gender"
            :items="['Male', 'Female']"
            hint="Required"
            persistent-hint
            outlined
          ></v-select>
          <div class="subtitle-2">Date of Birth</div>
          <v-text-field
            v-model="date_of_birth"
            :rules="rules.personalInformationFormRules.date_of_birth"
            type="date"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <div class="subtitle-2">Place of Birth</div>
          <v-text-field
            v-model="place_of_birth"
            :rules="rules.personalInformationFormRules.place_of_birth"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>

          <v-btn color="primary" type="submit">Continue</v-btn>
          <v-btn text>Cancel</v-btn>
        </v-card-text>
      </v-form>
    </v-stepper-content>

    <v-stepper-step :complete="step > 3" step="3"
      >Your demographic profile</v-stepper-step
    >

    <v-stepper-content step="3">
      <v-form ref="demographicProfileForm" @submit.prevent="next(3)">
        <v-card-text>
          <div class="subtitle-2">Religious Affiliation</div>
          <v-text-field
            v-model="religious_affiliation"
            :rules="rules.demographicProfileFormRules.religious_affiliation"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <div class="subtitle-2">Citizenship</div>
          <v-text-field
            v-model="citizenship"
            :rules="rules.demographicProfileFormRules.citizenship"
            hint="Optional"
            outlined
          ></v-text-field>
          <div class="subtitle-2">Ordinal Position</div>
          <v-text-field
            v-model="ordinal_position"
            :rules="rules.demographicProfileFormRules.ordinal_position"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <div class="subtitle-2">Currently Living With</div>
          <v-text-field
            v-model="currently_living_with"
            :rules="rules.demographicProfileFormRules.currently_living_with"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <div class="subtitle-2">GPA</div>
          <v-text-field
            v-model="gpa"
            :rules="rules.demographicProfileFormRules.gpa"
            type="number"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <div class="subtitle-2">City Address</div>
          <v-text-field
            v-model="city_address"
            :rules="rules.demographicProfileFormRules.city_address"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <div class="subtitle-2">Home Address</div>
          <v-text-field
            v-model="home_address"
            :rules="rules.demographicProfileFormRules.home_address"
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
          <div class="subtitle-2">Scholarship Grant</div>
          <v-combobox
            v-model="scholarship_grant"
            :rules="rules.moreInformationFormRules.scholarship_grant"
            :items="['None']"
            hint="Required"
            persistent-hint
            outlined
          ></v-combobox>
          <div class="subtitle-2">Parents Marital Status</div>
          <v-combobox
            v-model="parents_marital_status"
            :rules="rules.moreInformationFormRules.parents_marital_status"
            :items="['None']"
            hint="Optional"
            outlined
          ></v-combobox>
          <div class="subtitle-2">Family Monthly Income</div>
          <v-combobox
            v-model="family_monthly_income"
            :rules="rules.moreInformationFormRules.family_monthly_income"
            :items="['None']"
            hint="Required"
            persistent-hint
            outlined
          >
          </v-combobox>
          <div class="subtitle-2">School Last Attended</div>
          <v-text-field
            v-model="school_last_attended"
            :rules="rules.moreInformationFormRules.school_last_attended"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <div class="subtitle-2">School Address</div>
          <v-text-field
            v-model="school_address"
            :rules="rules.moreInformationFormRules.school_address"
            type="number"
            hint="Required"
            persistent-hint
            outlined
          ></v-text-field>
          <v-checkbox
            v-model="is_affected_marawi_siege"
            :rules="rules.moreInformationFormRules.is_affected_marawi_siege"
            color="primary"
            label="Have you been affected by Marawi Siege?"
          ></v-checkbox>
          <div class="subtitle-2">
            Is your parent an Overseas Filipino Worker (OFW)?
          </div>
          <v-autocomplete
            v-model="parents_ofw"
            :rules="rules.moreInformationFormRules.parents_ofw"
            color="primary"
            :items="[
              'Yes, my mother',
              'Yes, my father',
              'Yes, both my mother and father',
              'No'
            ]"
            hint="If you answered 'No' you may disregard answering the following items below this question."
            persistent-hint
            outlined
          ></v-autocomplete>
          <div class="subtitle-2">Where did your parent(s) work?</div>
          <v-text-field v-model="parents_work_location" outlined></v-text-field>
          <div class="subtitle-2">Are you living with your:</div>
          <v-combobox
            v-model="living_with"
            :items="['Relative(s)', 'Non-relative(s)', 'Sibling(s)']"
            hint="For other answer no need to select any of the suggested choices, just specify"
            persistent-hint
            outlined
          ></v-combobox>
          <div class="subtitle-2">
            How long have your parent(s) been away from home?
          </div>
          <v-autocomplete
            v-model="parents_away"
            :items="[
              'less than 10 months',
              '10 months to 2 years',
              'more than 2 years'
            ]"
            outlined
          ></v-autocomplete>

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
import { UserActions, StoreActions } from "../../utils/StoreTypes";

export default {
  data: () => ({
    step: 1
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
            "identification_number"
          ]
        ),

        personalInformationFormRules: {
          ...only({ ...UserRules }, ["first_name", "middle_name", "last_name"]),

          ...only({ ...DemographicProfileRules }, [
            "age",
            "gender",
            "date_of_birth",
            "place_of_birth"
          ])
        },

        demographicProfileFormRules: only({ ...DemographicProfileRules }, [
          "religious_affiliation",
          "citizenship",
          "ordinal_position",
          "currently_living_with",
          "gpa",
          "city_address",
          "home_address"
        ]),

        moreInformationFormRules: only({ ...DemographicProfileRules }, [
          "scholarship_grant",
          "parents_marital_status",
          "family_monthly_income",
          "school_last_attended",
          "school_address",
          "is_scholar",
          "is_affected_marawi_siege"
        ])
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
      "form.demographic_profile.parents_marital_status",
      "form.demographic_profile.family_monthly_income",
      "form.demographic_profile.school_last_attended",
      "form.demographic_profile.school_address",
      "form.demographic_profile.parents_ofw",
      "form.demographic_profile.parents_work_location",
      "form.demographic_profile.living_with",
      "form.demographic_profile.parents_away",
    ])
  },

  methods: {
    async next(currentStep) {
      const forms = Object.freeze({
        AccountInformation: "accountInformationForm",
        PersonalInformation: "personalInformationForm",
        DemographicProfile: "demographicProfileForm",
        MoreInformation: "moreInformationForm"
      });

      switch (currentStep) {
        case 1:
          if (await this.$refs[forms.AccountInformation].validate()) {
            console.log("VALIDATED");
            this.step = 2;
            break;
          } else {
            return this.$helpers.notify({
              type: "error",
              message: "Please fill in the required fields."
            });
          }

        case 2:
          if (await this.$refs[forms.PersonalInformation].validate()) {
            console.log("VALIDATED");
            this.step = 3;
            break;
          } else {
            return this.$helpers.notify({
              type: "error",
              message: "Please fill in the required fields."
            });
          }

        case 3:
          if (await this.$refs[forms.DemographicProfile].validate()) {
            console.log("VALIDATED");
            this.step = 4;
            break;
          } else {
            return this.$helpers.notify({
              type: "error",
              message: "Please fill in the required fields."
            });
          }

        case 4:
          if (await this.$refs[forms.MoreInformation].validate()) {
            const response = await this.$store.dispatch(
              StoreActions.REGISTER,
              this.$store.state.users.form
            );

            await this.$helpers.notify({
              type: "success",
              message: response?.message || "You have created an account."
            });

            console.log(response);

            await this.$refs[forms.AccountInformation].reset();
            await this.$refs[forms.PersonalInformation].reset();
            await this.$refs[forms.DemographicProfile].reset();
            await this.$refs[forms.MoreInformation].reset();

            await this.$router.replace({ name: "index" });
          } else {
            return this.$helpers.notify({
              type: "error",
              message: "Please fill in the required fields."
            });
          }

        default:
          break;
      }
    }
  }
};
</script>
