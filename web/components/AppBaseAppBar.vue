<template>
  <div>
    <v-app-bar :elevate-on-scroll="true" dense :color="color" :dark="dark" app>
      <slot name="leading">
        <v-tooltip bottom>
          <template #activator="{ on, attrs }">
            <v-btn v-on="on" v-bind="attrs" @click="$store.commit('TOGGLE_DRAWER')" icon>
              <v-icon>mdi-menu</v-icon>
            </v-btn>
          </template>
          <span>Toggle sidebar</span>
        </v-tooltip>
      </slot>
      <v-toolbar-title>{{ toolbarTitle }}</v-toolbar-title>
      <v-spacer></v-spacer>
      <div class="mx-1">
        <slot name="actions"></slot>
      </div>
      <slot name="trailing">
        <v-menu width="400" offset-y>
          <template v-slot:activator="{ on }">
            <v-btn v-on="on" icon>
              <v-avatar size="40">
                <v-img height="40" width="40" :src="$auth.user.avatar || '/default/avatar.png'"></v-img>
              </v-avatar>
            </v-btn>
          </template>
          <v-card width="400">
            <app-user-avatar></app-user-avatar>
            <v-divider></v-divider>
            <v-list>
              <v-list-item
                :to="{ name: $store.getters.isAdmin ? 'app-settings' : 'settings' }"
              >Settings</v-list-item>
              <v-list-item @click="$refs.logoutDialog.value = true">Logout</v-list-item>
            </v-list>
          </v-card>
        </v-menu>
      </slot>
    </v-app-bar>

    <!-- logout dialog -->
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
          <img
            v-if="false"
            src="/illustrations/logout.svg"
            height="300"
            width="70%"
            alt="logout svg"
          />
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
export default {
  props: {
    color: {
      type: String,
      default: () => "light",
    },

    dark: {
      type: Boolean,
      default: () => true,
    },

    toolbarTitle: String,
  },

  data: () => ({
    controller: {
      menu: false,
      logout: false,
    },
  }),

  methods: {
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
