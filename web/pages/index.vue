<template>
  <v-main class="grey lighten-4 bg-wave-7" app>
    <v-container fill-height>
      <v-row justify="center" align="center">
        <v-col>
          <v-card-text>
            <div class="text-center">
              <img
                src="/illustrations/reading-book.svg"
                class="mb-5"
                style="height: 80vh; z-index: 999;"
                width="95%"
              />
            </div>
          </v-card-text>
        </v-col>
      </v-row>
    </v-container>
    <v-navigation-drawer
      :color="regularScreen ? 'transparent' : ''"
      :value="true"
      :right="false"
      :touchless="true"
      :width="width"
      floating
      permanent
      :class="{
        'rounded-l-xl': regularScreen && false,
        'bg-wave-inverse-3': !regularScreen && false,
        'elevation-10': false,
        'grey lighten-5': false,
      }"
      :style="{
        'border-radius': regularScreen && false ? '30px 0px 0px 30px' : '0px'}"
      app
    >
      <v-container fill-height>
        <v-row justify="center" align="center">
          <v-col>
            <SignIn :class="{'px-10 mx-10': regularScreen}" />
          </v-col>
        </v-row>
      </v-container>
    </v-navigation-drawer>
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
