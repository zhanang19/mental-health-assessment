<template>
  <div>
    <v-navigation-drawer 
      v-model="drawer"
      :color="$vuetify.theme.dark 
        ? '' : 'light'"
      :light="!$vuetify.theme.dark"
      :dark="$vuetify.theme.dark"
      :floating="false"
      :clipped="false"
      app>
      <template v-slot:prepend>
        <v-card 
          color="transparent" 
          min-height="15rem" 
          max-height="15rem" 
          class="rounded-b-xl mb-3" 
          flat>
          <v-toolbar width="100%" absolute color="transparent" flat>
            <v-btn @click="$store.commit('TOGGLE_DRAWER')" icon>
              <v-icon>mdi-chevron-left</v-icon>
            </v-btn>
            <v-toolbar-title></v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn @click="$router.push({ name: 'settings' })" icon>
              <v-icon>mdi-cog-outline</v-icon>
            </v-btn>
          </v-toolbar>
          <user-avatar></user-avatar>
        </v-card>
      </template>
      <v-container>
        <v-btn 
          class="primary--text"
          x-large 
          rounded 
          block>
          <v-icon left>mdi-plus</v-icon>
          NEW SOMETHING
        </v-btn>
      </v-container>
      <v-list shaped>
        <v-list-item
          color="primary"
          v-for="(item, i) in pages"
          :key="i"
          :to="{ name: item.route }"
          link>
          <v-list-item-icon>
            <v-icon right v-text="item.icon"></v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title v-text="item.title" />
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-bottom-navigation
      v-if="$vuetify.breakpoint.sm && $vuetify.breakpoint.xs"
      v-model="bottomNav"
      app>
      <v-btn @click="drawer = !drawer" value="recent">
        <span>Recent</span>
        <v-icon>mdi-history</v-icon>
      </v-btn>

      <v-btn value="favorites">
        <span>Favorites</span>
        <v-icon>mdi-heart</v-icon>
      </v-btn>

      <v-btn value="nearby">
        <span>Nearby</span>
        <v-icon>mdi-map-marker</v-icon>
      </v-btn>
    </v-bottom-navigation>

    <v-dialog 
      ref="logoutDialog" 
      :value="false" 
      scrollable 
      max-width="450">
      <v-card>
        <v-toolbar color="transparent" flat>
          <v-toolbar-title>Logging out</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn @click="$refs.logoutDialog.value = false" icon>
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-card-text>
          Are you sure you want to logout?
        </v-card-text>
        <v-card-actions class="rounded-b-xl">
          <v-spacer></v-spacer>
          <v-btn 
            @click="$refs.logoutDialog.value = false" 
            text color="primary">
            CANCEL
          </v-btn>
          <v-btn @click="logout()" 
            text color="primary">
            CONFIRM
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { pages } from '../../utils/Routes'
import UserAvatar from '@/components/auth/UserAvatar'
import { mapGetters } from 'vuex'
import { mapFields } from 'vuex-map-fields'

export default {
  components: {
    UserAvatar
  },
  
  props: {
    color: {
      type: String,
      default: () => 'blue-grey darken-4',
    },

    dark: {
      type: Boolean,
      default: () => true,
    },

    toolbarColor: {
      type: String,
      default: () => 'primary',
    },

    toolbarDark: {
      type: Boolean,
      default: () => true,
    }
  },

  computed: {
    ...mapFields([
      'drawer'
    ])
  },
  
	data: () => ({
    bottomNav: 'recent',
    clipped: false,
    pages
  }),

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
  }
}
</script>