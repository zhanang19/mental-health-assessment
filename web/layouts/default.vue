<template>
  <v-app app>
    <app-primary-navigation-drawer v-bind="$attrs"></app-primary-navigation-drawer>
    <vue-page-transition class="router-container" name="fade-in-down">
      <nuxt></nuxt>
    </vue-page-transition>
    <v-tooltip v-if="!$store.state.drawer" bottom>
      <template #activator="{ on, attrs }">
        <v-btn
          v-on="on"
          v-bind="attrs"
          @click="$store.commit('TOGGLE_DRAWER')"
          color="primary"
          top
          right
          fixed
          fab
        >
          <v-icon>mdi-menu</v-icon>
        </v-btn>
      </template>
      <span>Toggle sidebar</span>
    </v-tooltip>
    <app-snackbar></app-snackbar>
    <app-dialog-loader></app-dialog-loader>
  </v-app>
</template>

<script>
import AppAuthNav from "@/components/layouts/AuthNav";
import AppSnackbar from "@/components/alerts/Snackbar";
import AppDialogLoader from "@/components/alerts/AppDialogLoader";

export default {
  // middleware: ['admin'],

  components: {
    AppAuthNav,
    AppSnackbar,
    AppDialogLoader,
  },

  async created() {
    await this.$store.dispatch("loadPreferences");

    // redirect to their facility page if user
    // is not an administrator, since route middleware
    // doesn't work the way it should...
    if (
      !this.$auth.user.is_admin &&
      !this.$route.name.includes("daycare-facilities-id")
    ) {
      await this.$router.push({
        name: "redirect",
      });
    }
  },
};
</script>

<style scoped>
html {
  scroll-behavior: smooth;
}

.router-container {
  height: 100%;
  display: flex;
}
</style>
