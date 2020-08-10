<template>
  <v-main app>
    <v-container class="bg-wave-7" fill-height fluid>
      <v-row justify="center" align="stretch" no-gutters>
        <v-col xl="6" lg="6" md="8" sm="10" xs="12">
          <SignIn :class="{'px-10': regularScreen}" />
        </v-col>
      </v-row>
    </v-container>
  </v-main>
</template>

<script>
import SignIn from "@/components/auth/SignIn";

export default {
  head() {
    return {
      title: `${process.env.appName} | Login`,
    };
  },

  layout: "empty",

  auth: "guest",

  components: {
    SignIn,
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
  width: 100%;
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
</style>
