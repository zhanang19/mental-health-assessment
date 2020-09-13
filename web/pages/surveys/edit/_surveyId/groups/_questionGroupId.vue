<template>
  <v-container>
    <div v-if="!isLoading">
      <v-card class="rounded-lg mb-10">
        <v-card-title v-text="group.label"></v-card-title>
        <v-card-subtitle>Question Group</v-card-subtitle>
        <v-card-text v-html="group.instructions"></v-card-text>
      </v-card>
    </div>
    <div v-else>
      <v-card class="rounded-lg mb-10">
        <v-card-text
          ><v-skeleton-loader type="card-heading"></v-skeleton-loader>
          <v-skeleton-loader type="paragraph"></v-skeleton-loader
        ></v-card-text>
      </v-card>
    </div>

    <app-survey-question
      v-if="!isLoading"
      ref="appSurveyQuestionComponent"
      @duplicated="getQuestionGroupById().then(() => refresh())"
      :question-group="group"
      :question-group-index="groupIndex"
    ></app-survey-question>
    <div v-else>
      <app-circular-progress-indicator
        :color-theme="survey.color_theme || 'white'"
      ></app-circular-progress-indicator>
    </div>

    <v-tooltip bottom>
      <template #activator="{on, attrs}">
        <v-btn
          v-on="on"
          v-bind="attrs"
          @click="$router.back()"
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

    <!-- action bottom sheet activator -->
    <v-tooltip top>
      <template #activator="{on, attrs}">
        <v-btn
          v-on="on"
          v-bind="attrs"
          :loading="isLoading"
          @click="bottomSheet = !bottomSheet"
          large
          rounded
          bottom
          right
          fixed
        >
          <span>Actions</span>
        </v-btn>
      </template>
      <span>See more actions</span>
    </v-tooltip>

    <!-- action bottom sheet -->
    <v-bottom-sheet
      v-model="bottomSheet"
      scrollable
      inset
      width="500"
      eager
      class="rounded-t-lg"
    >
      <v-sheet min-height="200" class="rounded-t-lg">
        <v-toolbar flat color="transparent">
          <v-toolbar-title></v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn @click="bottomSheet = !bottomSheet" text>Close</v-btn>
        </v-toolbar>
        <v-list class="rounded-t-lg">
          <v-list-item
            @click="
              addSurveyQuestion({
                questionGroupId: $route.params.questionGroupId
              })
            "
            >Add Question</v-list-item
          >
          <v-list-item @click="refresh()">Refresh</v-list-item>
        </v-list>
      </v-sheet>
    </v-bottom-sheet>
  </v-container>
</template>

<script>
import { SurveyActions } from "../../../../../utils/StoreTypes";
import { mapFields, mapMultiRowFields } from "vuex-map-fields";
import { mapState } from "vuex";

import AppSurveyQuestion from "@/components/surveys/forms/AppSurveyQuestion";

export default {
  props: {
    isLoading: Boolean
  },

  async created() {
    await this.getQuestionGroupById();
  },

  data: () => ({ bottomSheet: false }),

  components: {
    AppSurveyQuestion
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

  methods: {
    async refresh() {
      await this.$emit("is-loading", true);
      await setTimeout(async () => {
        await this.$emit("is-loading", false);

        await this.$refs.appSurveyQuestionComponent.setQuestionsState();
      }, 500);
    },

    async getQuestionGroupById() {
      await this.$emit("is-loading", true);

      await this.$store.dispatch(SurveyActions.FETCH_QUESTION_GROUP_BY_ID, {
        surveyId: this.$route.params.surveyId,
        questionGroupId: this.$route.params.questionGroupId
      });

      await setTimeout(async () => {
        await this.$emit("is-loading", false);
      }, 500);
    },

    /**
     * @param { Object } payload
     */
    async addSurveyQuestion({ questionGroupId }) {
      await this.$store.dispatch(SurveyActions.UPDATE, {
        surveyId: this.survey.id
      });

      const res = await this.$store.dispatch(SurveyActions.CREATE_QUESTION, {
        surveyId: this.survey.id,
        questionGroupId
      });

      await this.$store.dispatch(SurveyActions.FETCH, {
        surveyId: this.$route.params.surveyId
      });
    }
  }
};
</script>
