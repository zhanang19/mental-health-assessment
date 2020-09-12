<template>
  <v-main :class="survey.color_theme" app>
    <app-base-app-bar :color="survey.color_theme">
      <template #leading>
        <v-toolbar-title>
          <v-icon left>mdi-eye-outline</v-icon>
          <span>Preview Mode</span>
        </v-toolbar-title>
      </template>
    </app-base-app-bar>

    <nuxt-child class="my-16"></nuxt-child>

    <app-floating-back-button></app-floating-back-button>
  </v-main>
</template>

<script>
import AppBaseAppBar from "@/components/AppBaseAppBar";
import AppFloatingBackButton from "@/components/AppFloatingBackButton";
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
    AppBaseAppBar,
    AppFloatingBackButton
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
