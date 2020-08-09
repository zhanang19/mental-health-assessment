<template>
  <v-main app>
    <app-navbar title="Settings" :elevate-on-scroll="true">
      <template v-slot:leading>
        <v-btn @click="$router.go(-1)" icon>
          <v-icon>mdi-arrow-left</v-icon>
        </v-btn>
      </template>
      <template v-slot:search>
        <span></span>
      </template>
    </app-navbar>

    <v-container>
        <v-card flat>
          <v-row 
            justify="center"
            align="center">
            <v-col
              lg="6"
              md="8"
              sm="12"
              cols="12">
              <user-profile-setting></user-profile-setting>
              <user-password-setting></user-password-setting>
            </v-col>
          </v-row>
        </v-card>
    </v-container>

  </v-main>
</template>

<script>
import AppNavbar from '@/components/layouts/AppNavbar'
import UserProfileSetting from '@/components/auth/UserProfileSetting'
import UserPasswordSetting from '@/components/auth/UserPasswordSetting'
import { mapFields } from 'vuex-map-fields'
import { mapState } from 'vuex'

export default {
  loading: false,
  
  head () {
    return {
      title: `App | Settings`,
    }
  },

  components: {
    AppNavbar,
    UserProfileSetting,
    UserPasswordSetting
  },
}
</script>