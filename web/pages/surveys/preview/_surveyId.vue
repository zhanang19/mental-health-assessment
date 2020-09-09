<template>
  <v-main :class="survey.color_theme" app>
    <app-base-app-bar :color="survey.color_theme" toolbar-title="Preview Mode"></app-base-app-bar>

    <nuxt-child class="my-16"></nuxt-child>

    <v-tooltip top>
      <template #activator="{ on, attrs }">
        <v-btn
          style="z-index: 999"
          v-on="on"
          v-bind="attrs"
          @click="$router.back()"
          class="primary--text"
          elevation="10"
          bottom
          left
          fixed
          rounded
          x-large
        >
          <v-icon left>mdi-arrow-left</v-icon>
          <span>Back</span>
        </v-btn>
      </template>
      <span>Go back</span>
    </v-tooltip>
  </v-main>
</template>

<script>
import AppBaseAppBar from "@/components/AppBaseAppBar";
import { mapFields, mapMultiRowFields } from "vuex-map-fields";
import { SurveyActions } from "../../../utils/StoreTypes";
import { mapState } from "vuex";

export default {
  head() {
    return {
      title: `${process.env.appName} | ${this.title || "Untitled Survey Form"}`
    };
  },

  layout: "empty",

  components: {
    AppBaseAppBar
  },

  async fetch({ store, params }) {
    await store.dispatch(SurveyActions.FETCH, {
      surveyId: params.surveyId
    });
  },

  computed: {
    survey() {
      return this.survey;
    },

    ...mapState("surveys", {
      survey: state => state.survey
    })
  }
};
</script>
