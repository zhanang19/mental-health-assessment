<template>
  <v-form ref="form" @submit.prevent="login()">
    <v-card-text>
      <v-row class="mb-10">
        <div class="d-flex justify-center align-center">
          <v-avatar class="rounded-lg mx-1" tile size="125">
            <v-img height="125" width="125" src="/icon.png"></v-img>
          </v-avatar>
          <h1 class="display-2 mx-1">iDEYA Tracker</h1>
        </div>
      </v-row>
      <div class="title text-center mb-10">
        <div class="headline font-weight-regular">SIGN IN</div>
        <div class="subtitle-1">TO ACCESS THE PORTAL</div>
      </div>

      <v-slide-x-transition hide-on-leave>
        <section>
          <v-text-field
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
          ></v-text-field>
          <!-- <v-text-field
            v-show="type === 'email'"
            append-icon="mdi-email-outline"
            :disabled="loggingIn"
            v-model="credentials.email"
            :rules="rules.email"
            :error="!!errors['email']"
            :error-messages="errors['email']"
            label="Email"
            solo
          ></v-text-field>-->
          <v-text-field
            label="Password"
            append-icon="mdi-lock-outline"
            :disabled="loggingIn"
            :error="!!errors['password']"
            :error-messages="errors['password']"
            v-model="credentials.password"
            :rules="rules.password"
            hint="Required"
            persistent-hint
            type="password"
            solo
          ></v-text-field>
          <div class="text-center mt-10">
            <div
              v-if="false"
              @click="$router.push({ name: 'register' })"
              class="mb-5 primary--text"
              style="cursor: pointer"
            >Forgot your password?</div>
            <div class="mb-2">
              <v-btn type="submit" color="primary" block :loading="loggingIn" x-large rounded>
                Sign In
                <v-icon right>mdi-chevron-right</v-icon>
              </v-btn>
            </div>
          </div>
        </section>
      </v-slide-x-transition>
    </v-card-text>
    <v-card-text>
      <div class="d-flex justify-space-around">
        <v-tooltip bottom>
          <template #activator="{ on, attrs }">
            <v-btn
              v-bind="attrs"
              v-on="on"
              href="https://www.facebook.com/ideya.cit/"
              target="_blank"
              fab
            >
              <v-icon color="blue darken-4" x-large>mdi-facebook</v-icon>
            </v-btn>
          </template>
          <span>Facebook Page</span>
        </v-tooltip>

        <v-tooltip bottom>
          <template #activator="{ on, attrs }">
            <v-btn
              v-bind="attrs"
              v-on="on"
              href="https://twitter.com/ideya_cit"
              target="_blank"
              fab
            >
              <v-icon color="blue darken-1" x-large>mdi-twitter</v-icon>
            </v-btn>
          </template>
          <span>Twitter Handle</span>
        </v-tooltip>
        <v-tooltip bottom>
          <template #activator="{ on, attrs }">
            <v-btn
              v-bind="attrs"
              v-on="on"
              href="https://www.youtube.com/channel/UCuPGbD61oRhPDtO_v6BOh4g/featured?view_as=subscriber"
              target="_blank"
              fab
            >
              <v-icon color="red darken-2" x-large>mdi-youtube</v-icon>
            </v-btn>
          </template>
          <span>YouTube Channel</span>
        </v-tooltip>

        <v-tooltip bottom>
          <template #activator="{ on, attrs }">
            <v-btn v-bind="attrs" v-on="on" href="mailto:ideya@g.msuiit.edu.ph" target="_blank" fab>
              <v-icon x-large>mdi-email</v-icon>
            </v-btn>
          </template>
          <span>Email Us</span>
        </v-tooltip>

        <v-tooltip bottom>
          <template #activator="{ on, attrs }">
            <v-btn v-bind="attrs" v-on="on" href="https://ideya.msuiit.edu.ph/" target="_blank" fab>
              <v-icon x-large>mdi-web</v-icon>
            </v-btn>
          </template>
          <span>Website</span>
        </v-tooltip>
      </div>
    </v-card-text>
  </v-form>
</template>

<script>
export default {
  data: () => ({
    loggingIn: false,
    type: "username",
    errors: {},
    credentials: {
      username: "carlomigueldy",
      // email: "",
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
