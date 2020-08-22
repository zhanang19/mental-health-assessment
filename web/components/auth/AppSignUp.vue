<template>
  <v-form ref="form" @submit.prevent="login()">
    <v-stepper v-model="step" class="elevation-0" vertical>
      <v-stepper-step :complete="step > 1" step="1">
        <span>Your account information</span>
      </v-stepper-step>

      <v-stepper-content step="1">
        <v-text-field label="Email" hint="Required" persistent-hint outlined></v-text-field>
        <v-text-field type="password" label="Password" hint="Required" outlined></v-text-field>
        <v-text-field label="ID Number" hint="Required" outlined></v-text-field>

        <v-btn color="primary" @click="step = 2">Continue</v-btn>
        <v-btn text>Cancel</v-btn>
      </v-stepper-content>

      <v-stepper-step :complete="step > 2" step="2">Your personal information</v-stepper-step>

      <v-stepper-content step="2">
        <v-text-field label="First Name" hint="Required" persistent-hint outlined></v-text-field>
        <v-text-field label="Middle Name" hint="Optional" outlined></v-text-field>
        <v-text-field label="Last Name" hint="Required" persistent-hint outlined></v-text-field>
        <v-text-field type="number" label="Age" hint="Required" persistent-hint outlined></v-text-field>
        <v-select
          label="Gender"
          :items="['Male', 'Female']"
          hint="Required"
          persistent-hint
          outlined
        ></v-select>
        <v-text-field type="date" label="Date of Birth" hint="Required" persistent-hint outlined></v-text-field>
        <v-text-field label="Place of Birth" hint="Required" persistent-hint outlined></v-text-field>

        <v-btn color="primary" @click="step = 3">Continue</v-btn>
        <v-btn text>Cancel</v-btn>
      </v-stepper-content>

      <v-stepper-step :complete="step > 3" step="3">Your demographic profile</v-stepper-step>

      <v-stepper-content step="3">
        <v-text-field label="Religious Affiliation" hint="Required" persistent-hint outlined></v-text-field>
        <v-text-field label="Citizenship" hint="Optional" outlined></v-text-field>
        <v-text-field label="Ordinal Position" hint="Required" persistent-hint outlined></v-text-field>
        <v-text-field label="Currently Living With" hint="Required" persistent-hint outlined></v-text-field>
        <v-text-field label="Currently Living With" hint="Required" persistent-hint outlined></v-text-field>

        <v-btn color="primary" @click="step = 4">Continue</v-btn>
        <v-btn text>Cancel</v-btn>
      </v-stepper-content>

      <v-stepper-step step="4">View setup instructions</v-stepper-step>
      <v-stepper-content step="4">
        <v-card color="grey lighten-1" class="mb-12" height="200px"></v-card>
        <v-btn color="primary" @click="step = 1">Continue</v-btn>
        <v-btn text>Cancel</v-btn>
      </v-stepper-content>
    </v-stepper>
  </v-form>
</template>

<script>
// identification_number
// age
// gender
// date_of_birth
// place_of_birth
// religious_affiliation
// gpa
// citizenship
// ordinal_position
// currently_living_with
// city_address
// home_address
// is_scholar
// is_affected_marawi_siege
// scholarship_grant
// parents_martial_status
// family_monthly_income
// school_last_attended
// school_address

export default {
  data: () => ({
    step: 1,
    loggingIn: false,
    type: "email",
    errors: {},
    credentials: {
      // username: "carlomigueldy",
      email: "admin@admin.com",
      password: "password",
    },
    rules: {
      username: [(v) => !!v || "This field is required."],
      email: [(v) => !!v || "This field is required."],
      password: [(v) => !!v || "This field is required."],
    },
  }),

  methods: {
    async login() {
      let credentials = this.credentials;
      // if (this.type === "username") {
      //   delete credentials.email;
      // } else {
      //   delete credentials.username;
      // }

      if (this.$refs.form.validate()) {
        try {
          this.loggingIn = true;
          await this.$helpers.loader();
          await this.$auth.loginWith("local", {
            data: credentials,
          });

          this.$helpers.notify({
            type: "success",
            message: "You have logged in.",
            transition: "slide-y-transition",
            centered: true,
            position: {
              right: false,
              left: false,
              top: true,
              bottom: false,
            },
          });

          this.$router.push({
            name: "app-dashboard",
          });
        } catch (error) {
          console.log(error);
          let message;
          if (error.response.status === 422) {
            this.errors = error.response.data.errors;
            message = error.response.data.message;
          }

          if (error.response.status === 403) {
            message = error.response.data.message;
          }

          this.$helpers.notify({
            type: "error",
            position: {
              top: true,
              bottom: false,
              left: false,
              right: false,
            },
            message:
              message || "Sorry. An error has occurred, try again later.",
          });
        } finally {
          this.loggingIn = false;
          await this.$helpers.loader();
        }
      }
    },
  },
};
</script>
