<template>
  <div>
    <v-app-bar
      v-bind="$attrs"
      :flat="flat"
      :elevate-on-scroll="elevateOnScroll"
      :absolute="absolute"
      :color="!!color
        ? color
        : $vuetify.theme.dark
        ? ''
        : 'white'"
      :app="app">
      <slot name="leading">
        <v-app-bar-nav-icon @click="$store.commit('TOGGLE_DRAWER')"></v-app-bar-nav-icon>
      </slot>
      <v-toolbar-title
        v-text="title"
        :class="{
          'white--text': titleTextWhite
        }"
      ></v-toolbar-title>
      <v-spacer></v-spacer>
      <slot v-if="false" name="search">
        <v-btn icon>
          <v-icon>mdi-magnify</v-icon>
        </v-btn>
      </slot>
      <div class="mx-1">
        <slot name="actions">
        </slot>
      </div>
      <slot name="trailing">
        <v-menu width="400" offset-y>
          <template v-slot:activator="{ on }">
            <v-btn style="margin-right: 0.15px" v-if="!showAvatar" v-on="on" icon>
              <v-icon>mdi-dots-vertical</v-icon>
            </v-btn>
            <v-btn style="margin-right: 0.15px" v-else v-on="on" icon>
              <v-avatar size="45">
                <v-img
                  height="45"
                  width="45"
                  :src="$auth.user.avatar || '/icon.png'"
                ></v-img>
              </v-avatar>
            </v-btn>
          </template>
          <v-card width="400">
            <user-avatar></user-avatar>
            <v-divider></v-divider>
            <v-list>
              <v-list-item
                :to="{ name: 'settings' }">
                Settings
              </v-list-item>
              <v-list-item @click="$refs.logoutDialog.value = true">
                Logout
              </v-list-item>
            </v-list>
          </v-card>
        </v-menu>
      </slot>
    </v-app-bar>

    <v-dialog
      ref="logoutDialog"
      :value="false"
      scrollable
      transition="slide-y-transition"
      max-width="450">
      <v-card>
        <v-toolbar color="transparent" flat>
          <v-toolbar-title>Logging out</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn @click="$refs.logoutDialog.value = false" icon>
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-card-text class="text-center">
          <img src="/illustrations/logout.svg" height="300" width="70%" alt="logout svg">
          <div class="subtitle-1">Are you sure you want to logout?</div>
        </v-card-text>
        <v-card-actions class="rounded-b-xl">
          <v-spacer></v-spacer>
          <v-btn
            @click="$refs.logoutDialog.value = false"
            width="125"
            large
            depressed>
            CANCEL
          </v-btn>
          <v-btn
            @click="logout()"
            depressed
            width="125"
            large
            color="primary">
            CONFIRM
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import UserAvatar from '@/components/auth/UserAvatar'

export default {
  components: {
    UserAvatar
  },

  props: {
    title: {
      type: String,
    },

    showAvatar: {
      type: Boolean,
      default: () => false
    },

    app: {
      type: Boolean,
      default: () => true
    },

    color: String,
    flat: Boolean,
    absolute: Boolean,
    titleTextWhite: Boolean,
    elevateOnScroll: Boolean
  },

  methods: {
    toggleTheme () {
      let toggle = !this.$vuetify.theme.dark
      this.$vuetify.theme.dark = toggle
      localStorage.setItem('preferences.theme', toggle ? 'dark' : 'light')
    },

    async logout () {
      try {
        await this.$helpers.loader()
        await this.$auth.logout()

        await this.$helpers.notify({
          type: 'info',
          message: 'You have logged out.'
        })
      } catch (error) {
        console.log(error)
      } finally {
        await this.$helpers.loader()
      }
    }
  },
}
</script>

<style>

</style>
