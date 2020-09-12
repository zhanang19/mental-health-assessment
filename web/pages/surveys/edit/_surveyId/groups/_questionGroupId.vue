<template>
  <v-container>
    <app-survey-question
      v-if="!refreshing"
      @added="refresh()"
      @duplicated="refresh()"
      :question-group="group"
      :question-group-index="groupIndex"
    ></app-survey-question>
    <div v-else>
      <app-circular-progress-indicator
        :color-theme="survey.color_theme"
      ></app-circular-progress-indicator>
    </div>
  </v-container>
</template>

<script>
import { SurveyActions } from "../../../../../utils/StoreTypes";
import { mapFields, mapMultiRowFields } from "vuex-map-fields";
import { mapState } from "vuex";

export default {
  async fetch({ store, params }) {
    await store.dispatch(SurveyActions.FETCH_QUESTION_GROUP_BY_ID, {
      surveyId: params.surveyId,
      questionGroupId: params.questionGroupId
    });
  },

  computed: {
    survey() {
      return this.survey;
    },

    groupIndex() {
      return this.survey.question_groups.findIndex(
        group => group.id === this.group.id
      );
    },

    group() {
      return this.questionGroup;
    },

    ...mapState("surveys", {
      survey: state => state.survey,

      questionGroup: state => state.question_group
    })
  },

  data: () => ({
    refreshing: false
  }),

  methods: {
    async refresh() {
      this.refreshing = true;

      await this.$store.dispatch(SurveyActions.FETCH_QUESTION_GROUP_BY_ID, {
        surveyId: this.$route.params.surveyId,
        questionGroupId: this.$route.params.questionGroupId
      });

      await setTimeout(() => {
        this.refreshing = false;
      }, 500);
    }
  }
};
</script>
