<template>
  <div>
    <v-navigation-drawer
      v-model="drawer"
      :color="$vuetify.theme.dark
        ? '' : 'grey lighten-5'"
      :light="!$vuetify.theme.dark"
      :dark="$vuetify.theme.dark"
      :floating="true"
      :clipped="false"
      :class="{'drawer-bg': false}"
      app
    >
      <template v-slot:prepend>
        <v-card
          color="transparent"
          min-height="15rem"
          max-height="15rem"
          class="rounded-b-xl mb-3"
          flat
        >
          <v-toolbar width="100%" absolute color="transparent" flat>
            <v-tooltip bottom>
              <template #activator="{ on, attrs }">
                <v-btn v-on="on" v-bind="attrs" @click="$store.commit('TOGGLE_DRAWER')" icon>
                  <v-icon>mdi-chevron-left</v-icon>
                </v-btn>
              </template>
              <span>Toggle sidebar</span>
            </v-tooltip>
            <v-toolbar-title></v-toolbar-title>
            <v-spacer></v-spacer>
            <v-menu v-model="controller.menu" transition="slide-y-transition" offset-y>
              <template v-slot:activator="{ on }">
                <v-btn icon v-on="on">
                  <v-icon>mdi-dots-horizontal</v-icon>
                </v-btn>
              </template>
              <v-card width="400">
                <v-list>
                  <v-list-item :to="{ name: 'settings' }">Settings</v-list-item>
                  <v-list-item @click="controller.logout = true">Logout</v-list-item>
                </v-list>
              </v-card>
            </v-menu>
          </v-toolbar>
          <user-avatar></user-avatar>
        </v-card>
      </template>
      <v-list shaped>
        <v-list-item
          color="primary"
          v-for="(item, i) in pages"
          :key="i"
          :to="{ name: item.route }"
          link
        >
          <v-list-item-icon>
            <v-sheet :color="item.color" class="text-center pa-2 rounded-lg">
              <v-icon color="white" v-text="item.icon"></v-icon>
            </v-sheet>
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
      app
    >
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
      v-model="controller.logout"
      transition="slide-y-transition"
      ref="logoutDialog"
      :value="false"
      scrollable
      max-width="450"
    >
      <v-card>
        <v-toolbar color="transparent" flat>
          <v-toolbar-title>Logging out</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn @click="controller.logout = false" icon>
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-card-text class="text-center">
          <img src="/illustrations/logout.svg" height="300" width="70%" alt="logout svg" />
          <div class="subtitle-1">Are you sure you want to logout?</div>
        </v-card-text>
        <v-card-actions class="rounded-b-xl">
          <v-spacer></v-spacer>
          <v-btn @click="controller.logout = false" width="125" large depressed>CANCEL</v-btn>
          <v-btn @click="logout()" depressed width="125" large color="primary">CONFIRM</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { pages } from "../../utils/Routes";
import UserAvatar from "@/components/auth/UserAvatar";
import { mapGetters } from "vuex";
import { mapFields } from "vuex-map-fields";

export default {
  components: {
    UserAvatar,
  },

  props: {
    color: {
      type: String,
      default: () => "blue-grey darken-4",
    },

    dark: {
      type: Boolean,
      default: () => true,
    },

    toolbarColor: {
      type: String,
      default: () => "primary",
    },

    toolbarDark: {
      type: Boolean,
      default: () => true,
    },
  },

  computed: {
    ...mapFields(["drawer"]),
  },

  data: () => ({
    bottomNav: "recent",
    clipped: false,
    controller: {
      menu: false,
      logout: false,
    },
    pages,
  }),

  methods: {
    toggleTheme() {
      let toggle = !this.$vuetify.theme.dark;
      this.$vuetify.theme.dark = toggle;
      localStorage.setItem("preferences.theme", toggle ? "dark" : "light");
    },

    async logout() {
      try {
        await this.$helpers.loader();
        await this.$auth.logout();

        await this.$helpers.notify({
          type: "info",
          message: "You have logged out.",
          transition: "slide-y-transition",
          centered: true,
          position: {
            top: true,
            bottom: false,
            right: false,
            left: false,
          },
        });
      } catch (error) {
        console.log(error);
      } finally {
        await this.$helpers.loader();
      }
    },
  },
};
</script>

<style scoped>
.drawer-bg {
  width: 100%;
  background: url("/waves/default/wave-1.svg");
  background-position: bottom center;
  background-repeat: no-repeat;
}
</style>