<template>
  <v-main :class="survey.color_theme" app>
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

  computed: {
    ...mapState("survey-responses", {
      survey: (state) => state.survey,
    }),
  },
};
</script>
