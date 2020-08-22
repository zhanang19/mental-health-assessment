<template>
  <v-app app>
    <vue-page-transition class="router-container" name="fade-in-down">
      <nuxt></nuxt>
    </vue-page-transition>
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

.layout-enter-active,
.layout-leave-active {
  transition: opacity 0.25s;
}
.layout-enter,
.layout-leave-active {
  opacity: 0;
}
</style>
