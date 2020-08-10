<template>
  <v-main app>
    <!-- <v-navigation-drawer
      :color="regularScreen ? '' : ''"
      :value="true"
      :right="false"
      :touchless="true"
      :width="width"
      floating
      permanent
      :class="{
        'rounded-l-xl': regularScreen && false,
        'bg-wave-inverse-3': !regularScreen && false,
        'elevation-10': true,
        'grey lighten-5': false,
      }"
      :style="{
        'border-radius': regularScreen && false ? '30px 0px 0px 30px' : '0px'}"
      app
    >
      <v-container fill-height>
        <v-row justify="center" align="center">
          <v-col>
            <SignIn :class="{'px-10': regularScreen}" />
          </v-col>
        </v-row>
      </v-container>
    </v-navigation-drawer>-->
    <v-container class="bg-wave-7" fill-height fluid>
      <v-row justify="center" align="stretch" no-gutters>
        <v-col xl="6" lg="6" md="6" sm="10" xs="12">
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

  auth: "guest",

  layout: "empty",

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
