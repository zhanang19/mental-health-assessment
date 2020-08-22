<template>
  <v-form ref="form" @submit.prevent="login()">
    <v-card-text>
      <!-- <div class="text-center mb-3">
        <v-avatar class="rounded-lg mb-3" tile size="125">
          <v-img height="125" width="125" src="/icon.png"></v-img>
        </v-avatar>
        <h1 class="display-1 mx-1">Mental Health Assessment</h1>
      </div>
      <div class="title text-center mb-10">
        <div class="headline font-weight-regular">SIGN IN</div>
        <div class="subtitle-1">TO ACCESS THE PORTAL</div>
      </div>-->
      <div class="text-left mb-10">
        <!-- <div class="mb-3 text-center">
          <v-avatar tile size="100">
            <v-img height="100" width="100" src="/icon.png"></v-img>
          </v-avatar>
        </div>-->
        <h1 class="display-1 mb-5">Login to your account</h1>
        <div
          class="subtitle-1"
        >Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla excepturi sunt corrupti necessitatibus repellat cum in a eius commodi modi!</div>
      </div>

      <v-slide-x-transition hide-on-leave>
        <section>
          <!-- <v-text-field
            v-show="type === 'username'"
            append-icon="mdi-account-outline"
            :disabled="loggingIn"
            v-model="credentials.username"
            :rules="rules.username"
            :error="!!errors['username']"
            :error-messages="errors['username']"
            hint="Required"
            persistent-hint
            label="Username"
            solo
          ></v-text-field>-->
          <v-text-field
            v-show="type === 'email'"
            append-icon="mdi-email-outline"
            :disabled="loggingIn"
            v-model="credentials.email"
            :rules="rules.email"
            :error="!!errors['email']"
            :error-messages="errors['email']"
            label="Email"
            outlined
          ></v-text-field>
          <v-text-field
            label="Password"
            append-icon="mdi-lock-outline"
            :disabled="loggingIn"
            :error="!!errors['password']"
            :error-messages="errors['password']"
            v-model="credentials.password"
            :rules="rules.password"
            type="password"
            outlined
          ></v-text-field>
        </section>
      </v-slide-x-transition>
    </v-card-text>
    <v-card-actions>
      <v-btn :to="{ name: 'register' }" class="mb-1" color="light" text large>Register</v-btn>
      <v-spacer></v-spacer>
      <v-btn
        class="mb-1"
        type="submit"
        color="primary"
        :loading="loggingIn"
        width="150"
        depressed
        large
      >Sign In</v-btn>
    </v-card-actions>
  </v-form>
</template>

<script>
export default {
  data: () => ({
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
            name: this.$store.getters.isAdmin ? "app-dashboard" : "home",
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
