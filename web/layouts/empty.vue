<template>
  <v-app app>
    <nuxt />

    <app-snackbar></app-snackbar>
    <app-dialog-loader></app-dialog-loader>
  </v-app>
</template>

<script>
import AppSnackbar from '@/components/alerts/Snackbar'
import AppDialogLoader from '@/components/alerts/AppDialogLoader'

export default {
  components: {
    AppSnackbar,
    AppDialogLoader
  },

  created() {
    this.$store.dispatch('loadPreferences')
  }
}
</script>

<style>
html {
  scroll-behavior: smooth;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}

.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>