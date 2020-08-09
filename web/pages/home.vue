<template>
  <v-main :class="{
    'bg-wave-inverse-3': true,
    'grey darken-4': $vuetify.theme.dark
  }" app>
    <app-navbar 
      title="Home"
      :elevate-on-scroll="true"
      :show-avatar="true"
      color="primary"
      dark
    >
    </app-navbar>
    <v-container fill-height>
      <v-row justify="center" align="center">
        <v-col>
          <div class="text-center">
            <app-data-table
              @click:create="customEvent($event, 'create')"
              @click:view="customEvent($event, 'view')"
              @click:edit="customEvent($event, 'edit')"
              @click:delete="customEvent($event, 'delete')"
              @click:restore="customEvent($event, 'restore')"
              @click:deletePermanently="customEvent($event, 'deletePermanently')"
            ></app-data-table>
          </div>
        </v-col>
      </v-row>
    </v-container>
  </v-main>
</template>

<script>
import AppNavbar from '@/components/layouts/AppNavbar'

export default {
  components: {
    AppNavbar
  },

  data: () => ({
    menus: [
      {
        title: "FACILITIES",
        route: "facilities",
        illustration: "/facilities.svg",
        elevation: 2
      },
      {
        title: "USERS",
        route: "users-active",
        illustration: "/users.svg",
        elevation: 2
      },
      {
        title: "MAP",
        route: "map",
        illustration: "/map_alt.svg",
        elevation: 2
      },
    ]
  }),
  
  head () {
    return {
      title: `App | Home`,
    }
  },

  methods: {
    customEvent(event, type) {
      console.log(event, type)
    }
  }
}
</script>