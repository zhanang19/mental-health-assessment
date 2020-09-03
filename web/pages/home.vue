<template>
  <v-main app>
    <app-base-app-bar color="blue darken-4">
      <template #leading>
        <span></span>
      </template>
    </app-base-app-bar>

    <span id="main">
      <span v-if="!$store.getters['isMobileScreen']" class="app-illustration-header">
        <img v-show="false" src="/illustrations/forms.svg" height="300" width="500" alt />
      </span>
      <v-container style="margin-top: 5rem;">
        <v-row justify="center" align="center">
          <v-col xl="8" lg="8" md="10" sm="12" xs="12">
            <v-card elevation="10" class="rounded-lg">
              <v-card-text>
                <v-container>
                  <v-toolbar flat color="transparent">
                    <v-toolbar-title>
                      <span>Hi there, {{ $auth.user.full_name || 'Anonymous User' }}</span>
                    </v-toolbar-title>

                    <v-spacer></v-spacer>

                    <v-tooltip bottom>
                      <template #activator="{ on, attrs }">
                        <v-icon v-on="on" v-bind="attrs">mdi-information-outline</v-icon>
                      </template>
                      <span>Click the card to start or continue answering the survey form.</span>
                    </v-tooltip>
                  </v-toolbar>

                  <v-tabs centered>
                    <v-tab :to="{ name: 'home' }" class="text-capitalize">All</v-tab>
                    <v-tab
                      :to="{ name: 'home-your-responses' }"
                      class="text-capitalize"
                    >Your Responses</v-tab>
                  </v-tabs>
                </v-container>


                <nuxt-child></nuxt-child>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
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
