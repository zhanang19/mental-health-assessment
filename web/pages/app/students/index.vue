<template>
  <v-container>
    <v-container>
      <h1 class="white--text">
        <span>Students</span>
      </h1>
    </v-container>
    <v-row justify="center" align="center">
      <v-col>
        <v-card elevation="10">
          <v-card-text>
            <v-toolbar class="mb-10" color="transparent" flat :extended="false">
              <v-text-field
                label="Search"
                v-model="datatable.search"
                append-icon="mdi-magnify"
                single-line
                hide-details
                clearable
                outlined
              ></v-text-field>
              <v-toolbar-title></v-toolbar-title>
              <v-spacer></v-spacer>

              <div>
                <v-btn :href="`${$store.getters.apiBaseUrl}/exports/students`" target="_blank" text large color="primary">
                  <v-icon left>mdi-microsoft-excel</v-icon>
                  <span>Export</span>
                </v-btn>

                <!-- <v-btn @click="createNewSurvey()" large color="primary"
                  >Create Student</v-btn
                > -->
              </div>

              <template v-if="false" v-slot:extension>
                <v-row class="mt-10">
                  <v-col>
                    <v-text-field
                      background-color="transparent"
                      type="date"
                      hint="From"
                      persistent-hint
                      clearable
                      outlined
                    ></v-text-field>
                  </v-col>
                  <v-col>
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
              </template>
            </v-toolbar>

            <v-divider></v-divider>
            <v-data-table
              :search="datatable.search"
              :items="students"
              :headers="datatable.headers"
              item-class="pa-16"
              multi-sort
              fixed-header
            >
              <template #item.actions="{ item }">
                <app-base-action-buttons
                  @click-view="
                    $router.push({
                      name: 'students-edit-slug',
                      params: { slug: item.slug }
                    })
                  "
                  :except="['edit']"
                  type="non-archive"
                  class="py-2"
                ></app-base-action-buttons>
              </template>
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import AppBaseActionButtons from "@/components/AppBaseActionButtons";
import AppConfirmationDialog from "@/components/alerts/AppConfirmationDialog";
import { UserActions } from "../../../utils/StoreTypes";
import { mapState, mapGetters } from "vuex";

export default {
  head() {
    return {
      title: `${process.env.appName} | Students`
    };
  },

  components: {
    AppBaseActionButtons,
    AppConfirmationDialog
  },

  async fetch({ store }) {
    await store.dispatch(UserActions.FETCH_ALL);
  },

  data: () => ({
    controller: {
      dialog: false
    },
    datatable: {
      search: "",
      headers: [
        { text: "ID", value: "id" },
        { text: "Name", value: "full_name" },
        { text: "Email", value: "email" },
        { text: "Date Created", value: "date_created" },
        {
          text: "Actions",
          value: "actions",
          align: "center",
          sortable: false
        }
      ]
    }
  }),

  computed: {
    ...mapGetters("users", ["students"])
  },

  methods: {
    createNewSurvey() {
      this.$store.dispatch(UserActions.CREATE, {});
    },

    customEvent(type) {
      console.log(type);
    },

    async onClick() {}
  }
};
</script>
