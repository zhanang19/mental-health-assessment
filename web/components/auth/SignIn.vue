<template>
  <v-form ref="form" @submit.prevent="login()">
    <v-card-text>
      <div class="text-center mb-3">
        <v-avatar class="rounded-lg mb-3" tile size="125">
          <v-img height="125" width="125" src="/icon.png"></v-img>
        </v-avatar>
        <h1 class="display-1 mx-1">Mental Health Assessment</h1>
      </div>
      <div class="title text-center mb-10">
        <div class="headline font-weight-regular">SIGN IN</div>
        <div class="subtitle-1">TO ACCESS THE PORTAL</div>
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
            solo
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
            solo
          ></v-text-field>
          <div class="text-center mt-1">
            <div
              v-if="false"
              @click="$router.push({ name: 'register' })"
              class="mb-5 primary--text"
              style="cursor: pointer"
            >Forgot your password?</div>
            <div class="mb-1">
              <v-btn class="mb-1" type="submit" color="primary" block :loading="loggingIn" x-large rounded>
                Sign In
                <v-icon right>mdi-chevron-right</v-icon>
              </v-btn>
              <v-btn class="mb-1" color="light" block x-large rounded>
                Register
              </v-btn>
            </div>
          </div>
        </section>
      </v-slide-x-transition>
    </v-card-text>
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
            name: "dashboard",
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
