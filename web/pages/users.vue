<template>
  <v-main app>
    <v-container>
      <h1 class="primary--text">Users</h1>
    </v-container>
    <v-container>
      <v-row justify="center" align="center">
        <v-col>
          <v-card flat>
            <v-toolbar color="transparent" flat>
              <v-text-field
                label="Search"
                v-model="datatable.search"
                append-icon="mdi-magnify"
                single-line
                hide-details
                clearable
                solo
              ></v-text-field>
              <v-toolbar-title></v-toolbar-title>
              <v-spacer></v-spacer>
              <v-btn large color="primary">Create User</v-btn>
            </v-toolbar>

            <v-divider></v-divider>
            <v-data-table
              :search="datatable.search"
              :items="$store.getters['users/activeUsers']"
              :headers="datatable.headers"
              item-class="pa-16"
              multi-sort
              fixed-header
            >
              <template #item.actions="{ item }">
                <app-base-action-buttons
                  type="non-archive"
                  @click-view="customEvent('view')"
                  @click-edit="customEvent('edit')"
                  @click-delete="customEvent('delete')"
                  @click-restore="customEvent('restore')"
                  @click-delete-permanently="customEvent('deletePermanently')"
                ></app-base-action-buttons>
              </template>
            </v-data-table>
          </v-card>
        </v-col>
      </v-row>
    </v-container>

    <!-- navigation drawer right -->
    <v-navigation-drawer color="grey lighten-5" width="25%" permanent floating right app>
      <v-toolbar color="transparent" flat>
        <v-toolbar-title class="primary--text">Filter Control</v-toolbar-title>
      </v-toolbar>
      <v-container>
        <v-row>
          <v-col>
            <v-text-field
              background-color="transparent"
              type="date"
              hint="From"
              persistent-hint
              clearable
              outlined
            ></v-text-field>
            <v-text-field
              background-color="transparent"
              type="date"
              hint="To"
              persistent-hint
              clearable
              outlined
            ></v-text-field>
          </v-col>
        </v-row>
      </v-container>
    </v-navigation-drawer>

    <v-btn
      v-if="false"
      style="z-index: 9999"
      color="primary"
      app
      bottom
      right
      fixed
      rounded
      x-large
    >
      <v-icon left>mdi-account-plus-outline</v-icon>
      <span>New Person</span>
    </v-btn>

    <app-confirmation-dialog
      v-model="controller.dialog"
      @confirmed="controller.dialog = !controller.dialog"
    ></app-confirmation-dialog>
  </v-main>
</template>

<script>
export default {
  head() {
    return {
      title: `${process.env.appName} | Users`,
    };
  },

  async fetch({ store }) {
    await store.dispatch("users/FETCH_ALL");
  },

  data: () => ({
    controller: {
      dialog: false,
    },
    datatable: {
      search: "",
      headers: [
        {
          text: "Name",
          value: "full_name",
        },
        {
          text: "Email",
          value: "email",
        },
        {
          text: "Actions",
          value: "actions",
          sortable: false,
        },
      ],
    },
  }),

  methods: {
    customEvent(type) {
      console.log(type);
    },
  },
};
</script>
