<template>
  <v-main :class="survey.color_theme" app>
    <v-app-bar app extended>
      <v-btn @click="$router.replace({ name: 'home-index' })" icon>
        <v-icon>mdi-arrow-left</v-icon>
      </v-btn>
      <v-toolbar-title>{{ survey.title || 'Untitled Survey Form' }}</v-toolbar-title>
      <v-spacer></v-spacer>

      <template #extension></template>
    </v-app-bar>

    <v-container class="mb-16">
      <v-row justify="center" align="center">
        <v-col lg="8" md="10" sm="11" xs="12">
          <!-- START: Survey Details -->
          <v-card class="rounded-lg" style="margin-bottom: 5rem">
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
            v-for="(group, groupIndex) in survey.question_groups"
            :key="groupIndex"
          >
            <!-- survey question group header -->
            <v-card class="rounded-lg mb-3">
              <v-tooltip bottom>
                <template #activator="{ on, attrs }">
                  <v-btn v-bind="attrs" v-on="on" fab top right absolute>
                    <h3>{{ `G${ groupIndex + 1}` }}</h3>
                  </v-btn>
                </template>
                <span>The question group number</span>
              </v-tooltip>
              <v-card-title class="headline pt-10" v-text="group.label"></v-card-title>
              <v-card-text v-html="group.instructions"></v-card-text>
              <v-divider class="mx-5"></v-divider>
              <v-card-actions>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-container>
        </v-col>
      </v-row>
    </v-container>
  </v-main>
</template>

<script>
import { mapFields, mapMultiRowFields } from "vuex-map-fields";
import { mapState } from "vuex";
import { SurveyResponseActions } from "../../utils/StoreTypes";

export default {
  head() {
    return {
      title: `${process.env.appName} | ${this.title || "Untitled Survey Form"}`,
    };
  },

  layout: "empty",

  async fetch({ store, params }) {
    await store.dispatch(SurveyResponseActions.FETCH_BY_SLUG, {
      slug: params.slug,
    });
  },

  data: () => ({
    isLoading: false,
  }),

  computed: {
    ...mapState("survey-responses", {
      survey: (state) => state.survey,
    }),
  },
};
</script>
