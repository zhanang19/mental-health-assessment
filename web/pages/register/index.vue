<template>
  <v-main class="bg-wave-inverse-5" app>
    <app-base-app-bar color="primary">
      <template #leading>
        <span></span>
      </template>
      <template #trailing>
        <span></span>
      </template>
    </app-base-app-bar>

    <v-container style="margin-top: 5rem;">
      <v-row justify="center" no-gutters>
        <v-col xl="6" lg="6" md="8" sm="10" xs="12">
          <v-container>
            <h1 class="white--text">
              <span>Create an account</span>
            </h1>
          </v-container>
          <v-card class="py-5 rounded-lg" elevation="10">
            <app-sign-up></app-sign-up>
          </v-card>
        </v-col>
      </v-row>
    </v-container>

    <v-tooltip top>
      <template #activator="{ on, attrs }">
        <v-btn
          style="z-index: 999"
          v-on="on"
          v-bind="attrs"
          @click="$router.back()"
          class="primary--text"
          elevation="10"
          bottom
          left
          fixed
          rounded
          x-large
        >
          <v-icon left>mdi-arrow-left</v-icon>
          <span>Back</span>
        </v-btn>
      </template>
      <span>Go back to Login screen</span>
    </v-tooltip>
  </v-main>
</template>

<script>
import AppSignUp from "@/components/auth/AppSignUp";
import AppBaseAppBar from "@/components/AppBaseAppBar";

export default {
  head() {
    return {
      title: `${process.env.appName} | Create Account`,
    };
  },

  layout: "empty",

  auth: "guest",

  components: {
    AppSignUp,
    AppBaseAppBar,
  },

  computed: {
    width() {
      const breakpoint = this.$vuetify.breakpoint;

      if (breakpoint.xl) return "40%";
      if (breakpoint.lg) return "50%";
      if (breakpoint.md) return "100%";
      if (breakpoint.sm) return "100%";
      if (breakpoint.xs) return "100%";
    },

    regularScreen() {
      const breakpoint = this.$vuetify.breakpoint;

      return !breakpoint.sm && !breakpoint.xs;
    },
  },
};
</script>

<style scoped>
.login-form-bg {
  width: 100%;
  position: absolute;
  height: 100;
  background: url("/waves/wave.svg");
  background-position: top center;
  background-repeat: no-repeat;
}

.bg {
  width: 50%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-repeat: no-repeat;
  background: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 0)),
    url("/images/ideya.jpeg");
  background-position: center center;
  background-size: cover;
}

#main {
  position: absolute;
  /* top: 0; */
  left: 0;
  /* right: 0; */
  z-index: 0;
  width: 50%;
  height: 100%;
  background-color: #0d47a1;
}
</style>
