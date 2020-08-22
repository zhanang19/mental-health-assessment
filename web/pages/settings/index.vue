<template>
  <div>
    <v-container>
      <v-container>
        <h1 class="white--text">
          <v-btn @click="$router.back()" dark icon>
            <v-icon>mdi-arrow-left</v-icon>
          </v-btn>
          <span>Settings</span>
        </h1>
      </v-container>
      <v-card elevation="10">
        <v-row justify="center" align="center">
          <v-col lg="6" md="8" sm="12" cols="12">
            <app-user-profile-setting></app-user-profile-setting>
            <app-user-password-setting></app-user-password-setting>
          </v-col>
        </v-row>
      </v-card>
    </v-container>
  </div>
</template>

<script>
import AppNavbar from "@/components/layouts/AppNavbar";
import AppUserProfileSetting from "@/components/auth/AppUserProfileSetting";
import AppUserPasswordSetting from "@/components/auth/AppUserPasswordSetting";
import { mapFields } from "vuex-map-fields";
import { mapState } from "vuex";

export default {
  head() {
    return {
      title: `${process.env.appName} | Settings`,
    };
  },

  loading: false,

  components: {
    AppNavbar,
    AppUserProfileSetting,
    AppUserPasswordSetting,
  },
};
</script>
