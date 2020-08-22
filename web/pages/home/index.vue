<template>
  <v-main app>
    <app-base-app-bar color="blue darken-4">
      <template #leading>
        <span></span>
      </template>
    </app-base-app-bar>

    <span id="main">
      <span  v-if="!$store.getters['isMobileScreen']" class="app-illustration-header">
        <img v-show="false" src="/illustrations/forms.svg" height="300" width="500" alt />
      </span>
      <nuxt-child style="margin-top: 12rem"></nuxt-child>
    </span>
  </v-main>
</template>

<script>
import AppBaseAppBar from "@/components/AppBaseAppBar";

export default {
  head() {
    return {
      title: `${process.env.appName} | Users`,
    };
  },

  layout: "student",

  components: {
    AppBaseAppBar,
  },
};
</script>

<style scoped>
#main {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  width: 100%;
  height: 50%;
  background-color: #0d47a1;
}
</style>
