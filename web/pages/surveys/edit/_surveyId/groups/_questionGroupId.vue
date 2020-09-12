<template>
  <v-container>
    <div v-if="!isLoading">
      <v-card class="rounded-lg mb-10">
        <v-card-title v-text="group.label"></v-card-title>
        <v-card-subtitle>Question Group</v-card-subtitle>
        <v-card-text v-html="group.instructions"></v-card-text>
      </v-card>

      <app-survey-question
        @added="getQuestionGroupById()"
        @duplicated="getQuestionGroupById()"
        :question-group="group"
        :question-group-index="groupIndex"
      ></app-survey-question>
    </div>

    <div v-else>
      <app-circular-progress-indicator
        :color-theme="survey.color_theme"
      ></app-circular-progress-indicator>
    </div>

    <v-tooltip bottom>
      <template #activator="{on, attrs}">
        <v-btn
          v-on="on"
          v-bind="attrs"
          @click="
            $router.replace({
              name: 'surveys-edit-surveyId',
              params: { surveyId: $route.params.surveyId }
            })
          "
          large
          rounded
          absolute
          top
          left
        >
          <v-icon left>mdi-arrow-left</v-icon>
          <span>Back</span>
        </v-btn>
      </template>
      <span>Go back</span>
    </v-tooltip>
  </v-container>
</template>

<script>
import { SurveyActions } from "../../../../../utils/StoreTypes";
import { mapFields, mapMultiRowFields } from "vuex-map-fields";
import { mapState } from "vuex";

export default {
  async created() {
    this.isLoading = true;

    await this.$store.dispatch(SurveyActions.FETCH_QUESTION_GROUP_BY_ID, {
      surveyId: this.$route.params.surveyId,
      questionGroupId: this.$route.params.questionGroupId
    });

    await setTimeout(() => {
      this.isLoading = false;
    }, 500);
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
    isLoading: false
  }),

  methods: {
    async getQuestionGroupById() {
      this.isLoading = true;

      await this.$store.dispatch(SurveyActions.FETCH_QUESTION_GROUP_BY_ID, {
        surveyId: this.$route.params.surveyId,
        questionGroupId: this.$route.params.questionGroupId
      });

      await setTimeout(() => {
        this.isLoading = false;
      }, 500);
    }
  }
};
</script>
