<template>
  <v-container>
    <v-row justify="center" align="center">
      <v-col lg="8" md="10" sm="11" xs="12">
        <!-- START: Survey Details -->
        <v-card class="rounded-lg py-5" style="margin-bottom: 5rem">
          <v-card-title>
            <span class="display-1" v-text="survey.title"></span>
          </v-card-title>
          <v-card-subtitle v-text="survey.subtitle"></v-card-subtitle>
          <v-card-text v-text="survey.description"></v-card-text>
        </v-card>
        <!-- END: Survey Details -->

        <!-- START: Question Groups v-for loop -->
        <v-container
          class="pa-0 mb-10"
          v-for="(group, groupIndex) in responseGroups"
          :key="groupIndex"
        >
          <!-- survey question group header -->
          <v-card class="rounded-lg mb-3">
            <v-card-title class="headline pt-10">
              <v-tooltip v-if="group.is_completed" top>
                <template #activator="{ on, attrs }">
                  <v-icon v-on="on" v-bind="attrs" class="mr-3" color="success"
                    >mdi-check</v-icon
                  >
                </template>
                <span>You have already answered this sub-scale.</span>
              </v-tooltip>
              <span v-text="group.label"></span>
              <v-spacer></v-spacer>
            </v-card-title>
            <v-card-text v-html="group.description"></v-card-text>
            <v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                  :to="{
                    name: 'surveys-responses-responseId-groups-responseGroupId',
                    params: {
                      responseId: $route.params.responseId,
                      responseGroupId: group.id
                    }
                  }"
                  large
                  color="primary"
                  text
                >
                  <span>Continue</span>
                  <v-icon right>mdi-arrow-right</v-icon>
                </v-btn>
              </v-card-actions>
            </v-card-text>
          </v-card>
        </v-container>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { mapFields, mapMultiRowFields } from "vuex-map-fields";
import { mapState } from "vuex";
import { SurveyResponseActions } from "../../../../utils/StoreTypes";

export default {
  head() {
    return {
      title: `${process.env.appName} | ${this.title || "Untitled Survey Form"}`
    };
  },

  props: {
    colorTheme: String
  },

  layout: "empty",

  data: () => ({
    isLoading: false
  }),

  computed: {
    survey() {
      return this.response;
    },

    responseGroups() {
      return this.response.response_groups;
    },

    ...mapState("responses", {
      response: state => state.response
    })
  }
};
</script>
