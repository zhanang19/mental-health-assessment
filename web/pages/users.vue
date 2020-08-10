<template>
  <v-main app>
    <v-container>
      <h1 class="primary--text">Users</h1>
    </v-container>
    <v-container>
      <v-row
        justify="center"
        align="center">
        <v-col>
          <v-card flat>
            <v-toolbar class="mb-10" color="transparent" flat extended>
              <v-text-field
                label="Start typing"
                v-model="datatable.search"
                append-icon="mdi-magnify"
                single-line
                hide-details
                clearable
                solo
              ></v-text-field>
              <v-toolbar-title></v-toolbar-title>
              <v-spacer></v-spacer>
              <section>
                <v-btn text large class="primary--text">
                  <v-icon left>mdi-filter-variant</v-icon>
                  MORE ACTIONS
                </v-btn>
              </section>

              <template v-slot:extension>
                <v-row class="mt-5">
                  <v-col>
                    <v-text-field
                      background-color="transparent"
                      type="date"
                      hint="From"
                      persistent-hint
                      clearable
                      solo
                      flat
                    ></v-text-field>
                  </v-col>
                  <v-col>
                    <v-text-field
                      background-color="transparent"
                      type="date"
                      hint="To"
                      persistent-hint
                      clearable
                      solo
                      flat
                    ></v-text-field>
                  </v-col>
                </v-row>
              </template>
            </v-toolbar>

            <v-divider></v-divider>
            <v-data-table
              :search="datatable.search"
              :items="$store.getters['users/activeUsers']"
              :headers="datatable.headers"
              item-class="pa-16"
              multi-sort
              fixed-header
            ></v-data-table>
          </v-card>
        </v-col>
      </v-row>
    </v-container>

    <v-btn color="primary" app bottom right fixed rounded x-large>
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
  head () {
    return {
      title: `${process.env.appName} | Students`,
    }
  },

  async fetch({ store }) {
    await store.dispatch('users/FETCH_ALL')
  },

  data: () => ({
    controller: {
      dialog: false
    },
    datatable: {
      search: '',
      headers: [
        {
          text: 'Name',
          value: 'full_name'
        },
        {
          text: 'Email',
          value: 'email'
        },
        {
          text: 'Phone',
          value: 'phone_number'
        },
        {
          text: 'Actions',
          value: 'actions'
        },
      ]
    }
  })
}
</script>
