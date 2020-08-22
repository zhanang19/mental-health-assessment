<template>
  <v-main :class="color_theme" app>
    <v-app-bar app extended>
      <v-btn @click="$router.replace({ name: 'app-surveys' })" icon>
        <v-icon>mdi-arrow-left</v-icon>
      </v-btn>
      <v-toolbar-title>{{ title || 'Untitled Survey Form' }}</v-toolbar-title>
      <v-spacer></v-spacer>
      <div>
        <v-menu transition="slide-y-transition" offset-y>
          <template #activator="{ on: menu, attrs }">
            <v-tooltip bottom>
              <template #activator="{ on: tooltip }">
                <v-btn v-on="{ ...tooltip, ...menu }" v-bind="attrs" icon>
                  <v-icon>mdi-palette-outline</v-icon>
                </v-btn>
              </template>
              <span>Select a color theme</span>
            </v-tooltip>
          </template>
          <v-list>
            <v-list-item
              @click="selectColorTheme(color)"
              v-for="(color, index) in colorThemes"
              :key="index"
            >
              <v-list-item-action>
                <v-sheet :class="`${color} pa-3 rounded-lg elevation-3`"></v-sheet>
              </v-list-item-action>
              <v-list-item-content>{{ color }}</v-list-item-content>
            </v-list-item>
          </v-list>
        </v-menu>
        <v-btn @click="save({ notify: true })" color="primary">Save Changes</v-btn>
      </div>

      <template #extension>
        <v-tabs centered>
          <v-tab>Questions</v-tab>
          <v-tab>Responses</v-tab>
        </v-tabs>
      </template>
    </v-app-bar>

    <v-container class="mb-16">
      <v-row justify="center" align="center">
        <v-col lg="8" md="10" sm="11" xs="12">
          <v-form ref="form" @submit.prevent="save({ notify: true })">
            <!-- START: Survey Details -->
            <v-card class="rounded-lg" style="margin-bottom: 5rem">
              <v-card-title>
                <span class="display-1">
                  <v-text-field
                    hint="Required"
                    persistent-hint
                    label="Form Title"
                    v-model="title"
                    :rules="rules.survey.title"
                  ></v-text-field>
                </span>
              </v-card-title>
              <v-card-subtitle>
                <v-text-field hint="Optional" persistent-hint label="Subtitle" v-model="subtitle"></v-text-field>
              </v-card-subtitle>
              <v-card-text>
                <v-textarea
                  v-model="description"
                  label="Description"
                  hint="Optional"
                  outlined
                  persistent-hint
                ></v-textarea>
              </v-card-text>
            </v-card>
            <!-- END: Survey Details -->

            <!-- START: Question Groups v-for loop -->
            <v-container
              class="pa-0 mb-10"
              v-for="(group, groupIndex) in question_groups"
              :key="groupIndex"
            >
              <!-- survey question group header -->
              <v-card class="rounded-lg mb-3">
                <v-tooltip bottom>
                  <template #activator="{ on, attrs }">
                    <v-btn v-bind="attrs" v-on="on" fab top right absolute>
                      <h3>{{ groupIndex + 1 }}</h3>
                    </v-btn>
                  </template>
                  <span>The question group number</span>
                </v-tooltip>
                <v-card-title class="headline pt-10">
                  <v-text-field
                    hint="Required"
                    persistent-hint
                    label="Group Label"
                    v-model="group.label"
                    :rules="rules.group.label"
                    @blur="save({ notify: false })"
                  ></v-text-field>
                </v-card-title>
                <v-card-text>
                  <v-textarea
                    label="Instructions"
                    v-model="group.instructions"
                    hint="Optional"
                    persistent-hint
                    @blur="save({ notify: false })"
                    outlined
                  ></v-textarea>
                </v-card-text>
                <v-card-text>
                  <v-divider></v-divider>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <div>
                    <v-tooltip bottom>
                      <template #activator="{ on, attrs }">
                        <v-btn
                          v-on="on"
                          v-bind="attrs"
                          @click="duplicateSurveyQuestionGroup({
                            questionGroupId: group.id
                          })"
                          elevation="3"
                          small
                          fab
                        >
                          <v-icon>mdi-content-copy</v-icon>
                        </v-btn>
                      </template>
                      <span>Duplicate this question group</span>
                    </v-tooltip>
                    <v-tooltip bottom>
                      <template #activator="{ on, attrs }">
                        <v-btn
                          v-on="on"
                          v-bind="attrs"
                          @click="deleteSurveyQuestionGroup({
                            questionGroupId: group.id
                          })"
                          elevation="3"
                          small
                          fab
                        >
                          <v-icon>mdi-delete-outline</v-icon>
                        </v-btn>
                      </template>
                      <span>Delete this question group</span>
                    </v-tooltip>
                  </div>
                </v-card-actions>
              </v-card>

              <!-- START: Survey Question Group v-for questions -->
              <app-survey-question
                v-if="!refreshing"
                @added="refresh()"
                @duplicated="refresh()"
                :question-group="group"
                :question-group-index="groupIndex"
              ></app-survey-question>
              <div v-else>
                <app-circular-progress-indicator :color-theme="color_theme"></app-circular-progress-indicator>
              </div>
              <!-- END: Survey Question Group v-for questions -->
            </v-container>
            <!-- END: Question Groups v-for loop -->
            <div class="text-center">
              <v-btn class="primary--text" x-large @click="addSurveyQuestionGroup()">
                <span>Add Question Group</span>
                <v-icon right>mdi-plus</v-icon>
              </v-btn>
            </div>
          </v-form>
        </v-col>
      </v-row>
    </v-container>

    <v-card
      v-if="false"
      class="rounded-xl"
      style="text-align: center; width: 50%; position: fixed; bottom: 0; left: 0; right: 0; margin-left: auto; margin-right: auto; margin-bottom: 1rem;"
    >
      <v-card-text>Test</v-card-text>
    </v-card>
  </v-main>
</template>

<script>
import { Survey, colorThemes, surveyValidations } from "../../../models/Survey";
import {
  SurveyQuestionGroup,
  surveyQuestionGroupValidations,
} from "../../../models/SurveyQuestionGroup";
import {
  SurveyQuestion,
  surveyQuestionValidations,
  surveyQuestionOptionValidations,
  inputTypes,
  inputTypesEnum,
  Option,
} from "../../../models/SurveyQuestion";
import { SurveyActions } from "../../../utils/StoreTypes";
import { mapFields, mapMultiRowFields } from "vuex-map-fields";
import { mapState } from "vuex";
import AppSurveyQuestion from "@/components/surveys/forms/AppSurveyQuestion";
import AppCircularProgressIndicator from "@/components/AppCircularProgressIndicator";

export default {
  head() {
    return {
      title: `${process.env.appName} | ${this.title || "Untitled Survey Form"}`,
    };
  },

  components: {
    AppSurveyQuestion,
    AppCircularProgressIndicator,
  },

  layout: "empty",

  async fetch({ store, params }) {
    await store.dispatch(SurveyActions.FETCH_BY_SLUG, {
      slug: params.slug,
    });
  },

  data: () => ({
    refreshing: false,
    form: {
      survey: new Survey({
        title: "Untitled Survey Form",
        color_theme: "blue darken-2",
      }),
      groups: [
        new SurveyQuestionGroup({
          label: "Untitled Question Group",
        }),
      ],
    },
  }),

  computed: {
    ...mapState("surveys", {
      survey: (state) => state.survey,
    }),

    ...mapFields("surveys", [
      "survey.title",
      "survey.subtitle",
      "survey.description",
      "survey.color_theme",
      "survey.question_groups.questions",
    ]),

    ...mapMultiRowFields("surveys", [
      "survey.question_groups",
      // "survey.question_groups.questions",
    ]),

    /**
     * Validation rules in form.
     *
     * @returns { Object }
     */
    rules() {
      return {
        survey: surveyValidations,
        group: surveyQuestionGroupValidations,
        question: surveyQuestionValidations,
        option: surveyQuestionOptionValidations,
      };
    },

    /**
     * Input types,
     * e.g. short answer, paragraph, checkboxes
     *
     * @returns { Array }
     */
    inputTypes() {
      return inputTypes;
    },

    /**
     * Enum for input types.
     *
     * @returns { Object }
     */
    inputTypesEnum() {
      return inputTypesEnum;
    },

    /**
     * List of available colors for color theming.
     *
     * @returns { Array }
     */
    colorThemes() {
      return colorThemes;
    },
  },

  methods: {
    async refresh() {
      this.refreshing = true;

      return await this.$store
        .dispatch(SurveyActions.FETCH, {
          surveyId: this.survey.id,
        })
        .finally(() => {
          setTimeout(() => {
            this.refreshing = false;
          }, 1000);
        });
    },

    async save({ notify = true }) {
      if (await this.$refs.form.validate()) {
        console.log("saved");
        const response = await this.$store.dispatch(SurveyActions.UPDATE, {
          surveyId: this.survey.id,
        });

        if (notify) {
          await this.$helpers.notify({
            type: "success",
            message: response?.message || "No message.",
          });
        }

        await this.$router.push({
          name: "surveys-edit-slug",
          params: {
            slug: response.data.slug,
          },
        });
      } else {
        return await this.$helpers.notify({
          type: "error",
          message: "Please fill in the required fields.",
        });
      }
    },

    /**
     * @param color string
     */
    selectColorTheme(color) {
      this.color_theme = color;
    },

    async addSurveyQuestionGroup() {
      const res = await this.$store.dispatch(
        SurveyActions.CREATE_QUESTION_GROUP,
        {
          surveyId: this.survey.id,
        }
      );

      await this.refresh();

      console.log(`addSurveyQuestionGroup()`, res);
    },

    /**
     * @param { Object } Payload
     */
    async deleteSurveyQuestionGroup({ questionGroupId }) {
      const res = await this.$store.dispatch(
        SurveyActions.DELETE_QUESTION_GROUP_BY_ID,
        {
          surveyId: this.survey.id,
          questionGroupId,
        }
      );

      await this.refresh();

      console.log("deleteSurveyQuestionGroup()", res);
    },

    /**
     * @todo
     * needs a deep clone so it copies properties and
     * values without referencing from the object source
     *
     * @param { Object } payload
     */
    async duplicateSurveyQuestionGroup({ questionGroupId }) {
      const res = await this.$store.dispatch(
        SurveyActions.DUPLICATE_QUESTION_GROUP,
        {
          surveyId: this.survey.id,
          questionGroupId,
        }
      );

      await this.refresh();

      console.log("duplicateSurveyQuestionGroup()", res);
    },

    /**
     * @param { Object } payload
     */
    async addSurveyQuestion({ questionGroupId }) {
      const res = await this.$store.dispatch(SurveyActions.CREATE_QUESTION, {
        surveyId: this.survey.id,
        questionGroupId,
      });

      await this.refresh();

      console.log("addSurveyQuestion()", res);

      // const totalQuestions = this.form.groups[index].questions.length;

      // this.form.groups[index].questions.push(
      //   new SurveyQuestion({
      //     identifier: totalQuestions + 1,
      //     input_type: "short answer",
      //     required: false,
      //   })
      // );
    },

    /**
     * Remove survey question from group.
     *
     * @param surveyQuestionGroupIndex survey question group index
     * @param questionIndex question index
     */
    deleteSurveyQuestion(surveyQuestionGroupIndex, questionIndex) {
      this.form.groups[surveyQuestionGroupIndex].questions.splice(
        questionIndex,
        1
      );
    },

    /**
     * @param surveyQuestionGroupIndex survey question group index
     * @param questionIndex question index
     */
    duplicateSurveyQuestion(surveyQuestionGroupIndex, questionIndex) {
      this.form.groups[surveyQuestionGroupIndex].questions.push({
        ...this.form.groups[surveyQuestionGroupIndex].questions[questionIndex],
      });
    },

    /**
     * @param surveyQuestionGroupIndex survey question group index
     * @param questionIndex question index
     */
    addSurveyQuestionOption(surveyQuestionGroupIndex, questionIndex, field) {
      if (field === "option_group_a") {
        this.form.groups[surveyQuestionGroupIndex].questions[
          questionIndex
        ].option_group_a.options.push(new Option());
      } else {
        this.form.groups[surveyQuestionGroupIndex].questions[
          questionIndex
        ].option_group_b.options.push(new Option());
      }
    },

    /**
     * @param surveyQuestionGroupIndex survey question group index
     * @param questionIndex question index
     * @param choiceAIndex question index
     */
    deleteSurveyQuestionChoice(
      surveyQuestionGroupIndex,
      questionIndex,
      choiceAIndex,
      field
    ) {
      if (field === "option_group_a") {
        this.form.groups[surveyQuestionGroupIndex].questions[
          questionIndex
        ].option_group_a.options.splice(choiceAIndex, 1);
      } else {
        this.form.groups[surveyQuestionGroupIndex].questions[
          questionIndex
        ].option_group_b.options.splice(choiceAIndex, 1);
      }
    },

    /**
     * @param surveyQuestionGroupIndex survey question group index
     * @param questionIndex question index
     * @param choiceAIndex question index
     */
    deleteSurveyQuestionOptionGroup(
      surveyQuestionGroupIndex,
      questionIndex,
      field
    ) {
      if (field === "option_group_a") {
        return this.$helpers.notify({
          type: "info",
          message: "Must have a set of options. Cannot delete option set A.",
        });
      } else {
        this.form.groups[surveyQuestionGroupIndex].questions[
          questionIndex
        ].option_group_b = {};
      }
    },
  },
};
</script>
