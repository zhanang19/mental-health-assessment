<template>
  <v-main class="bg-wave-inverse-5" app>
    <v-container fill-height fluid style="z-index: 9999">
      <v-row justify="center" align="stretch" no-gutters>
        <v-col xl="5" lg="5" md="10" sm="10" xs="12">
          <v-card class="py-5 rounded-lg" elevation="10">
            <app-sign-in :class="{'px-10': regularScreen}"></app-sign-in>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-main>
</template>

<script>
import AppSignIn from "@/components/auth/AppSignIn";

export default {
  head() {
    return {
      title: `${process.env.appName} | Login`,
    };
  },

  layout: "empty",

  auth: "guest",

  components: {
    AppSignIn,
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
