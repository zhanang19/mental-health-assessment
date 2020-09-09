<template>
  <v-container>
    <v-container>
      <h1 class="white--text">
        <span>Survey Forms</span>
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
              <v-btn @click="createNewSurvey()" large color="primary"
                >Create Form</v-btn
              >

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
              :items="surveys"
              :headers="datatable.headers"
              item-class="pa-16"
              multi-sort
              fixed-header
            >
              <template #item.actions="{ item }">
                <app-base-action-buttons
                  @click-view="
                    $router.push({
                      name: 'surveys-edit-surveyId',
                      params: { surveyId: item.id }
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
import { SurveyActions } from "../../../utils/StoreTypes";
import { mapState } from "vuex";

export default {
  head() {
    return {
      title: `${process.env.appName} | Survey Forms`
    };
  },

  components: {
    AppBaseActionButtons,
    AppConfirmationDialog
  },

  async fetch({ store }) {
    await store.dispatch(SurveyActions.FETCH_ALL);
  },

  data: () => ({
    controller: {
      dialog: false
    },
    datatable: {
      search: "",
      headers: [
        { text: "ID", value: "id" },
        { text: "Title", value: "title" },
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
    ...mapState("surveys", {
      surveys: state => state.surveys
    })
  },

  methods: {
    createNewSurvey() {
      this.$store.dispatch(SurveyActions.CREATE, {});
    },

    customEvent(type) {
      console.log(type);
    },

    async onClick() {
      // const response = await surveyService.all();

      console.log(response);
    }
  }
};
</script>
