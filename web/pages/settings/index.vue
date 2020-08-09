<template>
  <v-main app>
    <v-container>
      <h1 class="primary--text">Settings</h1>
    </v-container>

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
  head () {
    return {
      title: `${process.env.appName} | Settings`,
    }
  },

  loading: false,

  components: {
    AppNavbar,
    UserProfileSetting,
    UserPasswordSetting
  },
}
</script>
